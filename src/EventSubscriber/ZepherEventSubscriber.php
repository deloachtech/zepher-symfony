<?php


namespace DeLoachTech\ZepherBundle\EventSubscriber;

use DeLoachTech\ZepherBundle\Event\AccessUpdatedEvent;
use DeLoachTech\ZepherBundle\Event\AccessCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ZepherEventSubscriber implements EventSubscriberInterface
{



    public static function getSubscribedEvents(): array
    {
        return [
            AccessCreatedEvent::class => 'accessCreated',
            AccessUpdatedEvent::class => 'accessUpdated'
        ];
    }


    public function accessCreated(AccessCreatedEvent $event)
    {


    }


    public function accessUpdated(AccessUpdatedEvent $event)
    {

    }

}