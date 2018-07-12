<?php

namespace PreviewTechs\DomainReseller;

use PreviewTechs\DomainReseller\Entity\Customer;

class Customers
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * Customers constructor.
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function search(array $conditions = [], array $options = [])
    {
        return $this->provider->searchCustomers($conditions, $options);
    }

    /**
     * @param $identifier
     * @return \PreviewTechs\DomainReseller\Entity\Customer
     */
    public function get($identifier)
    {
        return $this->provider->getCustomer($identifier);
    }

    /**
     * @param Customer $customer
     * @return \PreviewTechs\DomainReseller\Entity\Customer
     */
    public function create(Customer $customer)
    {
        return $this->provider->createCustomer($customer);
    }

    /**
     * @param Customer $customer
     * @return \PreviewTechs\DomainReseller\Entity\Customer
     */
    public function update(Customer $customer)
    {
        return $this->provider->modifyCustomer($customer);
    }
}