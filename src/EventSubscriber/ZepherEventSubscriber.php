<?php


namespace DeLoachTech\ZepherBundle\EventSubscriber;

use DeLoachTech\ZepherBundle\Event\AccountCreatedEvent;
use DeLoachTech\ZepherBundle\Event\AccountDeletedEvent;
use DeLoachTech\ZepherBundle\Service\AccessService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ZepherEventSubscriber implements EventSubscriberInterface
{

    private $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            AccountCreatedEvent::class => 'accountCreated',
            AccountDeletedEvent::class => 'accountDeleted'
        ];
    }


    public function accountDeleted(AccountDeletedEvent $event){
        $this->accessService->deleteAccount($event->getAccountId());
    }

    public function accountCreated(AccountCreatedEvent $event): bool
    {
       return  $this->accessService->createAccount($event->getAccountId(),$event->getDomainId(), $event->getVersionId());
    }

}