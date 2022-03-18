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

namespace DeLoachTech\ZepherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DeLoachTech\ZepherBundle\Repository\AccessRepository;

/**
 * @ORM\Entity(repositoryClass=AccessRepository::class)
 * @ORM\Table(name="zepher_access")
 */
class Access
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", options={"collation":"utf8_bin"}, nullable=false, length=20)
     */
    private $accountId;

    public function setAccountId($accountId): self
    {
        $this->accountId = $accountId;
        return $this;
    }


    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", options={"collation":"utf8_bin"}, nullable=false, length=20)
     */
    private $versionId;

    public function setVersionId(string $versionId): self
    {
        $this->versionId = $versionId;
        return $this;
    }


    public function getVersionId(): string
    {
        return $this->versionId;
    }

    /**
     * @ORM\Column(type="string", nullable=false, length=20)
     */
    private $domainId;

    public function setDomainId(string $domainId): self
    {
        $this->domainId = $domainId;
        return $this;
    }


    public function getDomainId(): string
    {
        return $this->domainId;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true}, length=14)
     */
    private $activated;

    public function setActivated(int $activated): self
    {
        $this->activated = $activated;
        return $this;
    }


    public function getActivated(): int
    {
        return $this->activated;
    }


    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned": true},  length=14)
     */
    private $lastProcess;

    public function setLastProcess(?int $lastProcess): self
    {
        $this->lastProcess = $lastProcess;
        return $this;
    }


    public function getLastProcess(): ?int
    {
        return $this->lastProcess;
    }


    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned": true},  length=14)
     */
    private $closed;

    public function setClosed(?int $closed): self
    {
        $this->closed = $closed;
        return $this;
    }


    public function getClosed(): ?int
    {
        return $this->closed;
    }
}