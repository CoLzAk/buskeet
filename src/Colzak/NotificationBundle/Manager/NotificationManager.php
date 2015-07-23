<?php

namespace Colzak\NotificationBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;
use Colzak\CoreBundle\Manager\Manager;
use Colzak\NotificationBundle\Document\Notification;

class NotificationManager extends Manager
{
    public function create()
    {
        $notification = new Notification();
        return $notification;
    }

    public function update(Notification $notification, $andFlush = true)
    {
        $this->getDocumentManager()->persist($notification);

        if ($andFlush) {
            $this->getDocumentManager()->flush();
        }

        return $notification;
    }

}
