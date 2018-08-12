<?php

namespace PreviewTechs\DomainReseller;


use PreviewTechs\DomainReseller\Entity\Contact;
use PreviewTechs\DomainReseller\Entity\Customer;
use PreviewTechs\DomainReseller\Entity\Domain;
use PreviewTechs\DomainReseller\Exceptions\ProviderExceptions;

interface ProviderInterface
{
    /**
     * @param array $conditions
     * @param array $options
     * @return array
     *
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function searchCustomers(array $conditions = [], array $options = []);

    /**
     * @param $identifier
     * @return Customer
     *
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getCustomer($identifier);

    /**
     * @param Customer $customer
     * @return Customer
     *
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function createCustomer(Customer $customer);

    /**
     * @param $identifier
     * @param Customer $customer
     * @return Customer
     *
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function modifyCustomer(Customer $customer);

    /**
     * @param $domainName
     * @param $extensions
     * @return bool
     *
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function isDomainAvailable($domainName, $extensions);

    /**
     * @param $keyWord
     * @param null $tld
     * @param bool $exactMatch
     * @return array
     *
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getSuggestions($keyWord, $tld = null, $exactMatch = false);

    /**
     * @param $domainName
     * @param Customer $customer
     * @param Contact|null $registrantContact
     * @param Contact|null $administrativeContact
     * @param Contact|null $technicalContact
     * @param Contact|null $billingContact
     * @param array $options
     * @return Domain
     */
    public function registerDomain($domainName, Customer $customer, Contact $registrantContact = null, Contact $administrativeContact = null, Contact $technicalContact = null, Contact $billingContact = null, array $options = []);

    /**
     * @param $domain
     * @param array $options
     * @return Domain
     * @throws ProviderExceptions
     */
    public function domainDetails($domain, array $options = []);
}