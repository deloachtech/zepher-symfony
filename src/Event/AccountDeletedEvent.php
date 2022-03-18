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

class AccountDeletedEvent extends Event
{

	private $accountId;



	public function __construct($accountId)
	{
		$this->accountId = $accountId;
	}



	public function getAccountId()
	{
		return $this->accountId;
	}

}