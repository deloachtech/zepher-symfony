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

class AccountCreatedEvent extends Event
{

	private $accountId;
    private $domainId;
    private $versionId;


    public function __construct($accountId, string $domainId, string $versionId = null)
	{
		$this->accountId = $accountId;
        $this->domainId = $domainId;
        $this->versionId = $versionId;
    }



	public function getAccountId()
	{
		return $this->accountId;
	}

	public function getDomainId(): string
    {
		return $this->domainId;
	}

	public function getVersionId(): string
    {
		return $this->versionId;
	}

}