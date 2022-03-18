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

    public function createAccount($accountId, string $domainId, ?string $versionId = null): bool
    {
        $accessValueObject = new AccessValueObject($accountId);
        $accessValueObject
            ->setDomainId($domainId)
            ->setVersionId($versionId)
            ->setActivated(time());
        return $this->accessRepository->createAccessRecord($accessValueObject);
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