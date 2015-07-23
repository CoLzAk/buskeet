<?php

namespace Colzak\NotificationBundle\Service;

use Colzak\CoreBundle\Service\Service;
use Colzak\NotificationBundle\Manager\NotificationManager;

class NotificationService extends Service
{
    const STATUS_PENDING = 'PENDING';

    public function __construct(NotificationManager $notificationManager)
    {
        parent::__construct($notificationManager);
    }

    public function push($user, $content)
    {
        $notification = $this->getManager()->create();
        $notification->setStatus(self::STATUS_PENDING);
        $notification->setFrom('no.reply@buskeet.com');
        $notification->setFromName('Buskeet');
        $notification->setTo($user->getEmail());
        $notification->setSubject('Inscription');
        $notification->setContent($content);
        return $this->getManager()->update($notification);
    }
}
