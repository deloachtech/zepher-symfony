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

namespace DeLoachTech\ZepherBundle\Security;

use DeLoachTech\Zepher\AccessValueObject;
use DeLoachTech\ZepherBundle\Repository\AccessRepository;
use DeLoachTech\Zepher\Zepher;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessControl extends Zepher
{

    private $accessConfig;

    public function __construct(
        AccessRepository $accessRepository,
        SessionInterface $session,
        array            $accessConfig
    )
    {
        $this->accessConfig = $accessConfig;

        $domainId = null;
        $userRoles = [];

        if($accountId = $session->get($this->accessConfig['session_keys']['account_id'])){
            if ($accessRepository->isEmpty()) {
                $domainId =  $this->accessConfig['app_domain_id'];
            }

            $accessValueObject = new AccessValueObject($accountId);
            $accessRepository->getCurrentAccessRecord($accessValueObject);

//            $domainId = $accessValueObject->getDomainId();

            $userRoles = $session->get($this->accessConfig['session_keys']['user_roles']) ?? [];
        }


        parent::__construct(
            $domainId,
            $accountId,
            $userRoles,
            $accessRepository,
            $this->accessConfig['object_file']
        );
    }

    public function getAccessConfig(): array
    {
        return $this->accessConfig;
    }

}