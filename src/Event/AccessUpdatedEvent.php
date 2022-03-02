<?php


namespace DeLoachTech\ZepherBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class AccessUpdatedEvent extends Event
{

    private $accountId;
    private $versionId;
    private $activated;


    public function __construct(string $accountId, string $versionId, int $activated)
    {
        $this->accountId = $accountId;
        $this->versionId = $versionId;
        $this->activated = $activated;
    }


    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getVersionId(): string
    {
        return $this->versionId;
    }

    public function getActivated(): int
    {
        return $this->activated;
    }


}