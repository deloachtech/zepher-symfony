<?php

namespace DeLoachTech\ZepherBundle\Security;

use DeLoachTech\Zepher\AccessValueObject;
use DeLoachTech\ZepherBundle\Repository\AccessRepository;
use DeLoachTech\Zepher\Zepher;
use DeLoachTech\ZepherBundle\Service\AccessService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessControl extends Zepher
{

    private $_config;
    private $accessRepository;
    private $accessService;

    public function __construct(
        AccessRepository $accessRepository,
        SessionInterface $session,
        AccessService    $accessService,
        array            $config
    )
    {
        $this->_config = $config;
        $this->accessRepository = $accessRepository;
        $this->accessService = $accessService;

        $domainId = null;

        $accountId = $session->get($config['session_keys']['account_id']);
        $userRoles = $session->get($config['session_keys']['user_roles']) ?? [];

        if ($accountId) {

            if ($accessRepository->isEmpty()) {
                $domainId = $config['app_domain_id'];
                $this->accessService->createAccount($accountId, $domainId);
            } else {
                $vo = new AccessValueObject($accountId);
                $this->accessRepository->getAccessValues($vo);
                $domainId = $vo->getDomainId();
            }
        }

        parent::__construct(
            $domainId,
            $accountId,
            $userRoles,
            $accessRepository,
            $config['object_file']
        );
    }


    public function getConfig(): array
    {
        return $this->_config;
    }
}