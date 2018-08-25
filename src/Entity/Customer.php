<?php

namespace PreviewTechs\DomainReseller\Entity;


class Customer
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $emailAddress;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int|null
     */
    public $resellerId;

    /**
     * @var Address
     */
    public $address;

    /**
     * @var string|null
     */
    public $company;

    /**
     * @var string|null
     */
    public $status;

    /**
     * @var string|int
     */
    public $pin;

    /**
     * @var string
     */
    public $language;

    /**
     * @var null|bool
     */
    public $twoFactorAuthEnabled = null;

    /**
     * @var string
     */
    public $password;


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
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return Customer
     */
    public function setUsername($username)
    {
        $this->username = $username;

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
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getResellerId()
    {
        return $this->resellerId;
    }

    /**
     * @param int|null $resellerId
     *
     * @return Customer
     */
    public function setResellerId($resellerId)
    {
        $this->resellerId = $resellerId;

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
     * @return Customer
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null|string $company
     *
     * @return Customer
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null|string $status
     *
     * @return Customer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     *
     * @return Customer
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     *
     * @return Customer
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     *
     * @return Customer
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     *
     * @return Customer
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param int|string $pin
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return Customer
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getTwoFactorAuthEnabled()
    {
        return $this->twoFactorAuthEnabled;
    }

    /**
     * @param bool|null $twoFactorAuthEnabled
     *
     * @return Customer
     */
    public function setTwoFactorAuthEnabled($twoFactorAuthEnabled)
    {
        $this->twoFactorAuthEnabled = $twoFactorAuthEnabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                   => $this->getId(),
            'username'             => $this->getUsername(),
            'emailAddress'         => $this->getEmailAddress(),
            'resellerId'           => $this->getResellerId(),
            'name'                 => $this->getName(),
            'address'              => $this->getAddress()->toArray(),
            'company'              => $this->getCompany(),
            'pin'                  => $this->getPin(),
            'status'               => $this->getStatus(),
            'language'             => $this->getLanguage(),
            'twoFactorAuthEnabled' => $this->getTwoFactorAuthEnabled(),
            'password'             => $this->getPassword()
        ];
    }
}