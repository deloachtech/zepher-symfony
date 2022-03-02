<?php


namespace DeLoachTech\ZepherBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class AccountDeletedEvent extends Event
{

	private $accountId;



	public function __construct(string $accountId)
	{
		$this->accountId = $accountId;
	}



	public function getAccountId(): string
	{
		return $this->accountId;
	}

}