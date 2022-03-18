<?php
/**
 * This file is part of the deloachtech/zepher-symfony package.
 *
 * (c) DeLoach Tech, LLC
 * https://deloachtech.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace DeLoachTech\ZepherBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class AccessUpdatedEvent extends Event
{

    private $accountId;
    private $versionId;
    private $activated;


    public function __construct($accountId, string $versionId, int $activated)
    {
        $this->accountId = $accountId;
        $this->versionId = $versionId;
        $this->activated = $activated;
    }


    public function getAccountId()
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