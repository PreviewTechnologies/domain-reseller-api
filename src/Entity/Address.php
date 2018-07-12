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
     * @var int
     */
    public $zipCode;

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
}