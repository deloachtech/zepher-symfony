<?php

namespace DeLoachTech\ZepherBundle\Repository;

use DeLoachTech\ZepherBundle\Entity\Access;
use DeLoachTech\ZepherBundle\Event\AccessCreatedEvent;
use DeLoachTech\ZepherBundle\Event\AccessUpdatedEvent;
use DeLoachTech\Zepher\AccessValueObject;
use DeLoachTech\Zepher\FeeProviderPersistenceInterface;
use DeLoachTech\Zepher\PersistenceClassInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;


/**
 * @method Access|null find($id, $lockMode = null, $lockVersion = null)
 * @method Access|null findOneBy(array $criteria, array $orderBy = null)
 * @method Access[]    findAll()
 * @method Access[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessRepository extends ServiceEntityRepository implements PersistenceClassInterface, FeeProviderPersistenceInterface
{
    private $eventDispatcher;

    public function __construct(
        ManagerRegistry          $registry,
        EventDispatcherInterface $eventDispatcher
    )
    {
        parent::__construct($registry, Access::class);
        $this->eventDispatcher = $eventDispatcher;
    }


    public function isEmpty(): bool
    {
        return $this->getEntityManager()->getConnection()->executeQuery("select account_id from zepher_access limit 1")->rowCount() == 0;
    }


    /**
     * @param AccessValueObject $accessValueObject
     * @return bool
     */
    public function createAccessRecord(AccessValueObject $accessValueObject): bool
    {
        return $this->_createAccessRecord(
            $accessValueObject->getAccountId(),
            $accessValueObject->getDomainId(),
            $accessValueObject->getVersionId(),
            $accessValueObject->getActivated(),
            $accessValueObject->getLastProcess(),
            $accessValueObject->getClosed()
        );
    }


    /**
     * @param AccessValueObject $accessValueObject
     * @return bool
     */
    public function updateAccessRecord(AccessValueObject $accessValueObject): bool
    {
        return $this->_updateAccessRecord(
            $accessValueObject->getAccountId(),
            $accessValueObject->getVersionId(),
            $accessValueObject->getActivated(),
            $accessValueObject->getLastProcess(),
            $accessValueObject->getClosed()
        );
    }


    /**
     * @param $accountId
     * @return bool
     */
    public function deleteAccessRecords($accountId): bool
    {
        return $this->_deleteAccessRecords($accountId);
    }


    /**
     * @param AccessValueObject $accessValueObject
     * @return void
     */
    public function getCurrentAccessRecord(AccessValueObject $accessValueObject)
    {
        $values = $this->_getLatestAccessValues($accessValueObject->getAccountId());

        $accessValueObject
            ->setDomainId($values['domain_id'])
            ->setVersionId($values['version_id'] ?? null)
            ->setActivated($values['activated'] ?? null)
            ->setLastProcess($values['last_process'])
            ->setClosed($values['closed']);
    }


    /**
     * Zepher/FeeProviderPersistenceInterface method
     * @param $accountId
     * @return array
     */
    public function getAccessValueObjects($accountId): array
    {
        $array = [];

        $vos = $this->getAccountRecords($accountId);

        foreach ($vos as $vo) {
            $array[] = (new AccessValueObject($accountId))
                ->setDomainId($vo['domain_id'])
                ->setVersionId($vo['version_id'])
                ->setActivated($vo['activated'])
                ->setClosed($vo['closed'])
                ->setLastProcess($vo['last_process']);
        }
        return $array;
    }


    /**
     * Zepher/FeeProviderPersistenceInterface method
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    public function getAccountIdsReadyForFeeProcessing(): array
    {
        return $this->getEntityManager()->getConnection()->executeQuery("select account_id from zepher_access where coalesce(last_process,activated) < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 DAY)) and closed is null")->fetchFirstColumn() ?? [];
    }


    /**
     * Zepher/FeeProviderPersistenceInterface method
     * @param $objectFile
     * @return void
     */
    public function objectFile($objectFile)
    {

    }


    // Helper methods

    private function _deleteAccessRecords($accountId): bool
    {
        return $this->getEntityManager()->getConnection()->executeQuery("delete from zepher_access where account_id = ?", [$accountId])->rowCount() >= 0;

    }

    private function _getAccountRecords(string $accountId): array
    {
        return $this->getEntityManager()->getConnection()->executeQuery("select account_id, domain_id, version_id, activated, last_process, closed from zepher_access where account_id = ?", [$accountId])->fetchAllAssociative() ?? [];
    }

    private function _getRecord(?string $accountId, ?string $versionId, ?int $activated)
    {
        if (!empty($accountId) || !empty($versionId) || !empty($activated)) {
            return [];
        }
        return $this->getEntityManager()->getConnection()->executeQuery("select account_id, domain_id, version_id, activated, last_process, closed from zepher_access where account_id = ? and version_id = ? and activated = ? limit 1", [$accountId, $versionId, $activated])->fetchAssociative() ?? [];
    }

    private function _createAccessRecord(string $accountId, string $domainId, string $versionId, int $activated, ?int $lastProcess, ?int $closed): bool
    {
        if ($this->getEntityManager()->getConnection()->executeQuery("insert into zepher_access (account_id, domain_id, version_id, activated, last_process, closed)  values (?,?,?,?,?,?)", [$accountId, $domainId, $versionId, $activated, $lastProcess, $closed])->rowCount() == 1) {
            $this->eventDispatcher->dispatch(new AccessCreatedEvent($accountId, $versionId, $activated));
            return true;
        }
        return false;
    }

    private function _updateAccessRecord(string $accountId, string $versionId, int $activated, ?int $lastProcess, ?int $closed): bool
    {
        if ($this->getEntityManager()->getConnection()->executeQuery("update zepher_access set last_process = ?, closed = ? where account_id = ? and version_id = ? and activated = ?", [$lastProcess, $closed, $accountId, $versionId, $activated])->rowCount() == 1) {
            $this->eventDispatcher->dispatch(new AccessUpdatedEvent($accountId, $versionId, $activated));
            return true;
        }
        return false;
    }

    private function _getLatestAccessValues($accountId)
    {
        return $this->getEntityManager()->getConnection()->executeQuery("select account_id, domain_id, version_id, activated, last_process, closed from zepher_access where account_id = ? order by activated DESC limit 1", [$accountId])->fetchAssociative() ?? [];
    }
}
