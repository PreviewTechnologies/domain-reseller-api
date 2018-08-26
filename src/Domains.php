<?php

namespace PreviewTechs\DomainReseller;


use PreviewTechs\DomainReseller\Entity\Contact;
use PreviewTechs\DomainReseller\Entity\Customer;
use PreviewTechs\DomainReseller\Entity\Domain;

class Domains
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * Domains constructor.
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param $domainName
     * @param $extensions
     * @return bool
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function isAvailable($domainName, $extensions)
    {
        return $this->provider->isDomainAvailable($domainName, $extensions);
    }

    /**
     * @param $keyword
     * @param null $tld
     * @param bool $exactMatch
     * @return array
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getSuggestions($keyword, $tld = null, $exactMatch = false)
    {
        return $this->provider->getSuggestions($keyword, $tld, $exactMatch);
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function createCustomer(Customer $customer)
    {
        return $this->provider->createCustomer($customer);
    }

    /**
     * @param $customerIdentififer
     * @return Customer
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getCustomer($customerIdentififer)
    {
        return $this->provider->getCustomer($customerIdentififer);
    }

    /**
     * @param $domainName
     * @param Customer $customer
     * @param Contact $registrantContact
     * @param Contact $administrativeContact
     * @param Contact $technicalContact
     * @param Contact $billingContact
     * @param array $options
     * @return Domain
     */
    public function registerDomain($domainName, Customer $customer, Contact $registrantContact = null, Contact $administrativeContact = null, Contact $technicalContact = null, Contact $billingContact = null, array $options = [])
    {
        return $this->provider->registerDomain($domainName, $customer, $registrantContact, $administrativeContact, $technicalContact, $billingContact, $options);
    }

    /**
     * @param $domainName
     * @param array $options
     * @return Domain
     * @throws Exceptions\ProviderExceptions
     */
    public function domainDetails($domainName, array $options = [])
    {
        return $this->provider->domainDetails($domainName, $options);
    }

    /**
     * @param $domain
     * @return array|null
     */
    public function isPremium($domain)
    {
        return $this->provider->isPremium($domain);
    }

    /**
     * @param $domain
     * @return Entity\Locks
     */
    public function getAllLocks($domain)
    {
        return $this->provider->getAllLocks($domain);
    }

    /**
     * @param $domain
     * @return array|null
     */
    public function enableTheftProtection($domain)
    {
        return $this->provider->enableTheftProtection($domain);
    }

    /**
     * @param $domain
     * @return array|null
     */
    public function disableTheftProtection($domain)
    {
        return $this->provider->disableTheftProtection($domain);
    }

    /**
     * @param $domain
     * @param null $authCode
     * @return array|null
     */
    public function changeAuthCode($domain, $authCode = null)
    {
        return $this->provider->changeAuthCode($domain, $authCode);
    }

    /**
     * @param $domain
     * @param array $nameServers
     * @return array|null
     */
    public function updateNameServers($domain, array $nameServers)
    {
        return $this->provider->updateNameServers($domain, $nameServers);
    }
}