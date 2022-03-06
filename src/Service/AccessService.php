<?php

namespace DeLoachTech\ZepherBundle\Service;

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
     * @param $accountId
     * @return bool
     */
    public function deleteAccount($accountId): bool
    {
        return $this->accessRepository->deleteAccessRecords($accountId);
    }


    public function getAccessConfig(): array
    {
        return $this->accessConfig;
    }

}