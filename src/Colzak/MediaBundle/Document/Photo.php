<?php
// src/Colzak/MediaBundle/Document/Photo.php

namespace Colzak\MediaBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @MongoDB\Document
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Photo
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $name;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $path;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $thumbPath;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $fileType;

    /**
     * @Assert\File
     */
    protected $file;

    protected $temp;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile", inversedBy="photos")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

    /**
     * @MongoDB\Boolean
     * @SERIAL\Type("boolean")
     */
    protected $coverPhoto;

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;

    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/uploads/photos/'.$this->getProfile()->getId().'/';
    }

    protected function createThumb()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $path = __DIR__.'/../../../../web/'.$this->getPath();
        $fileName = $this->getName();
        $fileExtension = 'jpeg';
        $mimeType = finfo_file($finfo, $path);
        $thumbWidth = 235;

        switch ($mimeType) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $img = imagecreatefrompng($path);
                break;
            case 'image/gif':
                $img = imagecreatefromgif($path);
                break;
            default:
                break;
        }

        //get the width and the height of the picture
        $width = imagesx( $img );
        $height = imagesy( $img );

        // calculate thumbnail size
        $new_width = $thumbWidth;
        $new_height = floor( $height * ( $thumbWidth / $width ) );

        // create a new temporary image
        $tmp_img = imagecreatetruecolor( $new_width, $new_height );

        // copy and resize old image into new image 
        imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

        // save thumbnail into a file
        $thumbnailPath = __DIR__.'/../../../../web/'.$this->getUploadDir().$fileName.'.thumb.'.$fileExtension;
        imagejpeg( $tmp_img, $thumbnailPath );

        return $thumbnailPath;
    }

    /**
     * @MongoDB\PrePersist()
     * @MongoDB\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->name = $filename;
            $this->path = $this->getUploadDir().$filename.'.'.$this->getFile()->guessExtension();
            $this->thumbPath = $this->getUploadDir().$filename.'.thumb.jpeg';
        }
    }

    /**
     * @MongoDB\PostPersist()
     * @MongoDB\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->temp);
            // clear the temp image path
            $this->temp = null;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->name.'.'.$this->getFile()->guessExtension()
        );

        $this->createThumb();

        $this->setFile(null);
    }

    /**
     * @MongoDB\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = __DIR__.'/../../../../web/'.$this->getPath();
    }

    /**
     * @MongoDB\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
            unlink(__DIR__.'/../../../../web/'.$this->getThumbPath());
        }
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set thumbPath
     *
     * @param string $thumbPath
     * @return self
     */
    public function setThumbPath($thumbPath)
    {
        $this->thumbPath = $thumbPath;
        return $this;
    }

    /**
     * Get thumbPath
     *
     * @return string $thumbPath
     */
    public function getThumbPath()
    {
        return $this->thumbPath;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     * @return self
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * Get fileType
     *
     * @return string $fileType
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set profile
     *
     * @param Colzak\UserBundle\Document\Profile $profile
     * @return self
     */
    public function setProfile(\Colzak\UserBundle\Document\Profile $profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return Colzak\UserBundle\Document\Profile $profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return file 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set coverPhoto
     *
     * @param boolean $coverPhoto
     * @return self
     */
    public function setCoverPhoto($coverPhoto)
    {
        $this->coverPhoto = $coverPhoto;
        return $this;
    }

    /**
     * Get coverPhoto
     *
     * @return boolean $coverPhoto
     */
    public function getCoverPhoto()
    {
        return $this->coverPhoto;
    }
}
