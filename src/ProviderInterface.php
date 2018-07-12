<?php

namespace PreviewTechs\DomainReseller;


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
}