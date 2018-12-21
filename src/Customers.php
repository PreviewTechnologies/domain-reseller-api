<?php

namespace PreviewTechs\DomainReseller;

use Exception;
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

    /**
     * @param array $conditions
     * @param array $options
     *
     * @return array
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function search(array $conditions = [], array $options = [])
    {
        return $this->provider->searchCustomers($conditions, $options);
    }

    /**
     * @param $identifier
     *
     * @return \PreviewTechs\DomainReseller\Entity\Customer
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function get($identifier)
    {
        return $this->provider->getCustomer($identifier);
    }

    /**
     * @param Customer $customer
     *
     * @return \PreviewTechs\DomainReseller\Entity\Customer
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function create(Customer $customer)
    {
        return $this->provider->createCustomer($customer);
    }

    /**
     * @param Customer $customer
     *
     * @return \PreviewTechs\DomainReseller\Entity\Customer
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function update(Customer $customer)
    {
        return $this->provider->modifyCustomer($customer);
    }

    /**
     * @param $customerId
     *
     * @return Entity\Contact[]
     */
    public function getCustomerDefaultContacts($customerId, $type = "Contact")
    {
        $contacts = $this->provider->getCustomerDefaultContacts($customerId, $type);
        if(!array_key_exists("Contact", $contacts)){
            return null;
        }

        $cc = [];
        foreach ($contacts['Contact'] as $key => $value){
            if(is_array($value)){
                $nc = new \PreviewTechs\DomainReseller\Entity\Contact();
                $nc->setCompany($value['contact.company']);

                $na = new \PreviewTechs\DomainReseller\Entity\Address();
                $na->setTelephone($value['contact.telno']);
                $na->setZipCode($value['contact.zip']);
                $na->setCity($value['contact.city']);
                $na->setState($value['contact.state']);
                $na->setCountry($value['contact.country']);
                $na->setPrimaryStreet($value['contact.address1']);

                $nc->setId($value['entity.entityid']);
                $nc->setEmail($value['contact.emailaddr']);
                $nc->setType($value['contact.type']);
                $nc->setCustomerId($value['entity.customerid']);
                $nc->setWhoisValidityIsValid($value['whoisValidity']['valid']);
                $nc->setAddress($na);
                $nc->setCurrentStatus($value['entity.currentstatus']);

                try {
                    $nc->setCreatedAt(new \DateTime(strtotime($value['contact.creationdt'] * 1000),
                        new \DateTimeZone("UTC")));
                } catch (Exception $e) {
                }

                $cc[$key] = $nc;
            }
        }

        return $cc;
    }
}