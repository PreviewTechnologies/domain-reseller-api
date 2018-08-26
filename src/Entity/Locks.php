<?php

namespace PreviewTechs\DomainReseller\Entity;


class Locks
{
    /**
     * @var bool
     */
    public $resellerLock;

    /**
     * @var bool
     */
    public $customerLock;

    /**
     * @var bool
     */
    public $transferLock;

    /**
     * @var string
     */
    public $resellerLockerId;

    /**
     * @var string
     */
    public $resellerLockAddedBy;

    /**
     * @var string
     */
    public $resellerLockReason;

    /**
     * @var \DateTime
     */
    public $resellerLockCreatedAt;

    /**
     * @var bool
     */
    public $theftProtectionEnabled;

    /**
     * @return bool
     */
    public function isResellerLock()
    {
        return $this->resellerLock;
    }

    /**
     * @param bool $resellerLock
     * @return Locks
     */
    public function setResellerLock($resellerLock)
    {
        $this->resellerLock = $resellerLock;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCustomerLock()
    {
        return $this->customerLock;
    }

    /**
     * @param bool $customerLock
     * @return Locks
     */
    public function setCustomerLock($customerLock)
    {
        $this->customerLock = $customerLock;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTransferLock()
    {
        return $this->transferLock;
    }

    /**
     * @param bool $transferLock
     * @return Locks
     */
    public function setTransferLock($transferLock)
    {
        $this->transferLock = $transferLock;
        return $this;
    }

    /**
     * @return string
     */
    public function getResellerLockerId()
    {
        return $this->resellerLockerId;
    }

    /**
     * @param string $resellerLockerId
     * @return Locks
     */
    public function setResellerLockerId($resellerLockerId)
    {
        $this->resellerLockerId = $resellerLockerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getResellerLockAddedBy()
    {
        return $this->resellerLockAddedBy;
    }

    /**
     * @param string $resellerLockAddedBy
     * @return Locks
     */
    public function setResellerLockAddedBy($resellerLockAddedBy)
    {
        $this->resellerLockAddedBy = $resellerLockAddedBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getResellerLockReason()
    {
        return $this->resellerLockReason;
    }

    /**
     * @param string $resellerLockReason
     * @return Locks
     */
    public function setResellerLockReason($resellerLockReason)
    {
        $this->resellerLockReason = $resellerLockReason;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getResellerLockCreatedAt()
    {
        return $this->resellerLockCreatedAt;
    }

    /**
     * @param \DateTime $resellerLockCreatedAt
     * @return Locks
     */
    public function setResellerLockCreatedAt($resellerLockCreatedAt)
    {
        $this->resellerLockCreatedAt = $resellerLockCreatedAt;
        return $this;
    }

    /**
     * @param bool $theftProtectionEnabled
     * @return Locks
     */
    public function setTheftProtectionEnabled($theftProtectionEnabled)
    {
        $this->theftProtectionEnabled = $theftProtectionEnabled;
        return $this;
    }
}