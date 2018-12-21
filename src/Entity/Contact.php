<?php

namespace PreviewTechs\DomainReseller\Entity;


class Contact
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $customerId;

    /**
     * @var string
     */
    public $type;

    /**
     * @var Address
     */
    public $address;

    /**
     * @var string|null
     */
    public $currentStatus;

    /**
     * @var bool
     */
    public $whoisValidityIsValid;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     *
     * @return Contact
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     *
     * @return Contact
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Contact
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     *
     * @return Contact
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @param string|null $currentStatus
     *
     * @return Contact
     */
    public function setCurrentStatus($currentStatus)
    {
        $this->currentStatus = $currentStatus;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWhoisValidityIsValid()
    {
        return $this->whoisValidityIsValid;
    }

    /**
     * @param bool $whoisValidityIsValid
     *
     * @return Contact
     */
    public function setWhoisValidityIsValid($whoisValidityIsValid)
    {
        $this->whoisValidityIsValid = $whoisValidityIsValid;

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
     * @return Contact
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'         => $this->getId(),
            'name'       => $this->getName(),
            'company'    => $this->getCompany(),
            'email'      => $this->getEmail(),
            'customerId' => $this->getCustomerId(),
            'type'       => $this->getType(),
            'address'    => $this->getAddress()->toArray()
        ];
    }
}