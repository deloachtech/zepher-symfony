<?php

namespace DeLoachTech\ZepherBundle\Security;

use DeLoachTech\Zepher\AccessValueObject;
use DeLoachTech\ZepherBundle\Repository\AccessRepository;
use DeLoachTech\Zepher\Zepher;
use DeLoachTech\ZepherBundle\Service\AccessService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessControl extends Zepher
{

    private $accessRepository;
    private $accessService;
    private $_config;

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

        // Use the Zepher extra impersonation feature.
        $extra = Zepher::getConfig($config['object_file'])['extra'] ??[];
        $domainId = $extra['impersonate_domain']??$domainId;
        $accountId = $extra['impersonate_account']??$accountId;
        $userRoles = isset($extre['impersonate_role']) ? (array)$extra['extra']['impersonate_role'] : $userRoles;

        if ($accountId) {

            if ($accessRepository->isEmpty()) {
                $this->accessService->createAccount($accountId, $domainId ?? $config['app_domain_id']);
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

    public function getAccessConfig(): array
    {
        return $this->_config;
    }
}