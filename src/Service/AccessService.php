<?php

namespace DeLoachTech\ZepherBundle\Service;

use DeLoachTech\Zepher\AccessValueObject;
use DeLoachTech\ZepherBundle\Repository\AccessRepository;

class AccessService
{

    private $accessConfig;
    private $accessRepository;

    public function __construct(AccessRepository $accessRepository, array $accessConfig)
    {
        $this->accessConfig = $accessConfig;
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
        $array = json_decode(file_get_contents($this->accessConfig['object_file']), true);
        $versionId = $versionId ?? reset($array['data']['domains'][$domainId]['versions']);

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


    public function getAccessConfig(): array
    {
        return $this->accessConfig;
    }

}