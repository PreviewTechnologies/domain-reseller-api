<?php

namespace PreviewTechs\DomainReseller\Entity;


class Domain
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var Contact
     */
    public $technicalContact;

    /**
     * @var Contact
     */
    public $billingContact;

    /**
     * @var Contact
     */
    public $registrantContact;

    /**
     * @var Contact
     */
    public $administrativeContact;

    /**
     * @var string
     */
    public $registrantContactEmailVerificationStatus;

    /**
     * @var \DateTime
     */
    public $registrantContactEmailVerificationTime;

    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var DomainOrder
     */
    public $order;

    /**
     * @var array
     */
    public $nameServers;

    /**
     * @var array
     */
    public $childNameServers;

    /**
     * @var string
     */
    public $domainSecret;

    /**
     * @var string
     */
    public $currentStatus;

    /**
     * @var array
     */
    public $status;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \DateTime
     */
    public $expirationDate;

    /**
     * @var bool
     */
    public $privacyProtected;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Domain
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getTechnicalContact()
    {
        return $this->technicalContact;
    }

    /**
     * @param Contact $technicalContact
     *
     * @return Domain
     */
    public function setTechnicalContact($technicalContact)
    {
        $this->technicalContact = $technicalContact;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getBillingContact()
    {
        return $this->billingContact;
    }

    /**
     * @param Contact $billingContact
     *
     * @return Domain
     */
    public function setBillingContact($billingContact)
    {
        $this->billingContact = $billingContact;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getRegistrantContact()
    {
        return $this->registrantContact;
    }

    /**
     * @param Contact $registrantContact
     *
     * @return Domain
     */
    public function setRegistrantContact($registrantContact)
    {
        $this->registrantContact = $registrantContact;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getAdministrativeContact()
    {
        return $this->administrativeContact;
    }

    /**
     * @param Contact $administrativeContact
     *
     * @return Domain
     */
    public function setAdministrativeContact($administrativeContact)
    {
        $this->administrativeContact = $administrativeContact;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegistrantContactEmailVerificationStatus()
    {
        return $this->registrantContactEmailVerificationStatus;
    }

    /**
     * @param string $registrantContactEmailVerificationStatus
     *
     * @return Domain
     */
    public function setRegistrantContactEmailVerificationStatus($registrantContactEmailVerificationStatus)
    {
        $this->registrantContactEmailVerificationStatus = $registrantContactEmailVerificationStatus;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrantContactEmailVerificationTime()
    {
        return $this->registrantContactEmailVerificationTime;
    }

    /**
     * @param \DateTime $registrantContactEmailVerificationTime
     *
     * @return Domain
     */
    public function setRegistrantContactEmailVerificationTime($registrantContactEmailVerificationTime)
    {
        $this->registrantContactEmailVerificationTime = $registrantContactEmailVerificationTime;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     *
     * @return Domain
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return DomainOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param DomainOrder $order
     *
     * @return Domain
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return array
     */
    public function getNameServers()
    {
        return $this->nameServers;
    }

    /**
     * @param array $nameServers
     *
     * @return Domain
     */
    public function setNameServers($nameServers)
    {
        $this->nameServers = $nameServers;

        return $this;
    }

    /**
     * @return array
     */
    public function getChildNameServers()
    {
        return $this->childNameServers;
    }

    /**
     * @param array $childNameServers
     *
     * @return Domain
     */
    public function setChildNameServers($childNameServers)
    {
        $this->childNameServers = $childNameServers;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomainSecret()
    {
        return $this->domainSecret;
    }

    /**
     * @param string $domainSecret
     *
     * @return Domain
     */
    public function setDomainSecret($domainSecret)
    {
        $this->domainSecret = $domainSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @param string $currentStatus
     *
     * @return Domain
     */
    public function setCurrentStatus($currentStatus)
    {
        $this->currentStatus = $currentStatus;

        return $this;
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Domain
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Domain
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     *
     * @return Domain
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivacyProtected()
    {
        return $this->privacyProtected;
    }

    /**
     * @param bool $privacyProtected
     *
     * @return Domain
     */
    public function setPrivacyProtected($privacyProtected)
    {
        $this->privacyProtected = $privacyProtected;

        return $this;
    }

    public function toArray()
    {
        return [
            'name'                                     => $this->getName(),
            'technicalContact'                         => $this->getTechnicalContact()->toArray(),
            'billingContact'                           => $this->getBillingContact()->toArray(),
            'registrantContact'                        => $this->getRegistrantContact()->toArray(),
            'administrativeContact'                    => $this->getAdministrativeContact()->toArray(),
            'registrantContactEmailVerificationStatus' => $this->getRegistrantContactEmailVerificationStatus(),
            'registrantContactEmailVerificationTime'   => $this->getRegistrantContactEmailVerificationTime() ? $this->getRegistrantContactEmailVerificationTime()->format("Y-m-d H:i:s") : null,
            'customer'                                 => $this->getCustomer()->toArray(),
            'order'                                    => $this->getOrder()->toArray(),
            'nameservers'                              => $this->getNameServers(),
            'childNameServers'                         => $this->getChildNameServers(),
            'domainSecret'                             => $this->getDomainSecret(),
            'currentStatus'                            => $this->getCurrentStatus(),
            'status'                                   => $this->getStatus(),
            'createdAt'                                => $this->getCreatedAt() ? $this->getCreatedAt()->format("Y-m-d H:i:s") : null,
            'expirationDate'                           => $this->getExpirationDate() ? $this->getExpirationDate()->format("Y-m-d H:i:s") : null,
            'privacyProtected'                         => $this->isPrivacyProtected()
        ];
    }
}