<?php

// src/Colzak/CommandBundle/Command/SendNotificationMailCommand.php
namespace Colzak\CommandBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Colzak\NotificationBundle\Document\Notification;

class SendNotificationMailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('notification:send-mail')
            ->setDescription('Send notification mails')
            ->addArgument('status', InputArgument::OPTIONAL, 'Which mail do you want to send ?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "Retrieving mails ... \n";
        $time = array();
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();

        $status = $input->getArgument('status');
        if ($status) {
            $notifications = $dm->getRepository('ColzakNotificationBundle:Notification')->findByStatus(strtoupper($status));
            $time['get_notifications'] = $this->microtime_float();
        } else {
            $notifications = $dm->getRepository('ColzakNotificationBundle:Notification')->findByStatus(Notification::STATUS_PENDING);
            $time['get_notifications'] = $this->microtime_float();
        }

        echo count($notifications)." mails to send...\n";
        $i = 0;
        foreach ($notifications as $notification) {
            echo $notification->getId()."\n";

            $message = \Swift_Message::newInstance()
                ->setSubject($notification->getSubject())
                ->setFrom('notify@buskeet.com')
                ->setTo($notification->getTo())
                ->setBody($notification->getContent(), "text/html");
            $this->getContainer()->get('mailer')->send($message);
            $notification->setStatus(Notification::STATUS_SENT);
            $dm->persist($notification);
            $i++;
            echo $i." mail(s) sent !\n";
            if ($i === count($notifications)) {
                $time['mail_sent'] = $this->microtime_float();
            }
        }

        $dm->flush();

        $output->writeln($this->dump($time, $output));
    }

    protected function microtime_float() {
        list($usec,$sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }

    protected function dump($a, OutputInterface $output) {
        $old = reset($a);
        foreach($a as $step => $time) {
            $output->writeln(str_pad($step, 8, ' ', STR_PAD_LEFT) . ' : ' . round($time - $old,5). ' sec.');
            $old = $time;
        }
        $first = reset($a);
        $end   = end($a);
        $output->writeln("\033[32mCommand successfully executed in : " . round($end - $first,5) . " sec.\033[37m\r\n");
    }
}