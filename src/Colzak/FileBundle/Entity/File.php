<?php 

// src/Colzak/FileBundle/Entity/File.php
namespace Colzak\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Colzak\FileBundle\Entity\FileRepository")
 * @ORM\Table(name="clzk_file")
 * @ORM\HasLifecycleCallbacks
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @Assert\File
     */
    protected $file;

    protected $temp;

    /**
     * @ORM\Column(name="thumb_path")
     */
    protected $thumbPath;

    /**
     * @ORM\Column(name="profile_picture", type="boolean", nullable=false)
     */
    protected $profilePicture;

    /**
     * @var Colzak\UserBundle\Entity\Profile $profile
     *
     * @ORM\ManyToOne(targetEntity="Colzak\UserBundle\Entity\Profile", inversedBy="files")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", nullable=false)
     */
    protected $profile;

    /**
     * @var boolean isReported
     *
     * @ORM\Column(name="is_reported", type="boolean", nullable=true)
     */
    protected $isReported = false;

    /**
     * @ORM\Column(name="file_type", type="string", length=255, nullable=true)
     */
    protected $fileType;

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
        return '/uploads/files/'.$this->getProfile()->getId().'/';
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
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
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
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
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = __DIR__.'/../../../../web/'.$this->getPath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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
     * Set profile
     *
     * @param \Colzak\UserBundle\Entity\Profile $profile
     * @return File
     */
    public function setProfile(\Colzak\UserBundle\Entity\Profile $profile)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return \Colzak\UserBundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set profilePicture
     *
     * @param boolean $profilePicture
     * @return File
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return boolean 
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * Set thumbPath
     *
     * @param string $thumbPath
     * @return File
     */
    public function setThumbPath($thumbPath)
    {
        $this->thumbPath = $thumbPath;
    
        return $this;
    }

    /**
     * Get thumbPath
     *
     * @return string 
     */
    public function getThumbPath()
    {
        return $this->thumbPath;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     * @return File
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string 
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    public function __toString() {
        return $this->getPath();
    }

    /**
     * Set isReported
     *
     * @param boolean $isReported
     * @return File
     */
    public function setIsReported($isReported)
    {
        $this->isReported = $isReported;

        return $this;
    }

    /**
     * Get isReported
     *
     * @return boolean 
     */
    public function getIsReported()
    {
        return $this->isReported;
    }
}