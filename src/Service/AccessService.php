<?php

namespace DeLoachTech\ZepherBundle\Service;

use DeLoachTech\Zepher\AccessValueObject;
use DeLoachTech\Zepher\Zepher;
use DeLoachTech\ZepherBundle\Repository\AccessRepository;

class AccessService
{

    private $config;
    private $accessRepository;

    public function __construct(AccessRepository $accessRepository, array $config)
    {
        $this->config = $config;
        $this->accessRepository = $accessRepository;
    }


    /**
     * When you create a new account, use this method to create its entry in the access table.
     * @param $accountId
     * @param string $domainId
     * @param string|null $versionId Optional app version id. If empty, the first version in the list will be selected.
     * @return bool
     * @throws \Exception
     */
    public function createAccount($accountId, string $domainId, string $versionId = null): bool
    {

        $json = Zepher::getConfig($this->config['object_file'])['object'];

        $versionId = $versionId ?? reset($json['data']['domains'][$domainId]['versions']);

        $vo = new AccessValueObject($accountId);
        $vo
            ->setDomainId($domainId)
            ->setVersionId($versionId);

        return $this->accessRepository->setAccessValues($vo);
    }

    /**
     * @param $accountId
     * @return bool
     */
    public function deleteAccount($accountId): bool
    {
        return $this->accessRepository->deleteAccessValues($accountId);
    }


    public function getConfig(): array
    {
        return $this->config;
    }

}