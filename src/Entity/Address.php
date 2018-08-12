<?php

namespace PreviewTechs\DomainReseller\Entity;


class Address
{
    /**
     * @var string|null
     */
    public $primaryStreet;

    /**
     * @var string|null
     */
    public $secondaryStreet;

    /**
     * @var string|null
     */
    public $anotherStreet;

    /**
     * @var string|null
     */
    public $city;

    /**
     * @var string|null
     */
    public $state;

    /**
     * @var string|null
     */
    public $country;

    /**
     * @var integer
     */
    public $telephone;

    /**
     * @var int
     */
    public $telephoneCountryCode;

    /**
     * @var int
     */
    public $telephoneExtension;

    /**
     * @var int
     */
    public $mobile;

    /**
     * @var int
     */
    public $mobileCountryCode;

    /**
     * @var int
     */
    public $fax;

    /**
     * @var int
     */
    public $faxCountryCode;

    /**
     * @return null|string
     */
    public function getPrimaryStreet()
    {
        return $this->primaryStreet;
    }

    /**
     * @param null|string $primaryStreet
     * @return Address
     */
    public function setPrimaryStreet($primaryStreet)
    {
        $this->primaryStreet = $primaryStreet;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSecondaryStreet()
    {
        return $this->secondaryStreet;
    }

    /**
     * @param null|string $secondaryStreet
     * @return Address
     */
    public function setSecondaryStreet($secondaryStreet)
    {
        $this->secondaryStreet = $secondaryStreet;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAnotherStreet()
    {
        return $this->anotherStreet;
    }

    /**
     * @param null|string $anotherStreet
     * @return Address
     */
    public function setAnotherStreet($anotherStreet)
    {
        $this->anotherStreet = $anotherStreet;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param null|string $state
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param null|string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return int
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param int $zipCode
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param int $telephone
     * @return Address
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return int
     */
    public function getTelephoneCountryCode()
    {
        return $this->telephoneCountryCode;
    }

    /**
     * @param int $telephoneCountryCode
     * @return Address
     */
    public function setTelephoneCountryCode($telephoneCountryCode)
    {
        $this->telephoneCountryCode = $telephoneCountryCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getTelephoneExtension()
    {
        return $this->telephoneExtension;
    }

    /**
     * @param int $telephoneExtension
     * @return Address
     */
    public function setTelephoneExtension($telephoneExtension)
    {
        $this->telephoneExtension = $telephoneExtension;
        return $this;
    }

    /**
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param int $mobile
     * @return Address
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return int
     */
    public function getMobileCountryCode()
    {
        return $this->mobileCountryCode;
    }

    /**
     * @param int $mobileCountryCode
     * @return Address
     */
    public function setMobileCountryCode($mobileCountryCode)
    {
        $this->mobileCountryCode = $mobileCountryCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param int $fax
     * @return Address
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return int
     */
    public function getFaxCountryCode()
    {
        return $this->faxCountryCode;
    }

    /**
     * @param int $faxCountryCode
     * @return Address
     */
    public function setFaxCountryCode($faxCountryCode)
    {
        $this->faxCountryCode = $faxCountryCode;
        return $this;
    }
}