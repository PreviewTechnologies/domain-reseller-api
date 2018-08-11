<?php

namespace PreviewTechs\DomainReseller\Providers;

use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client;
use Http\Client\Exception;
use PreviewTechs\DomainReseller\Entity\Address;
use PreviewTechs\DomainReseller\Entity\Contact;
use PreviewTechs\DomainReseller\Entity\Customer;
use PreviewTechs\DomainReseller\Entity\Domain;
use PreviewTechs\DomainReseller\Exceptions\ProviderExceptions;
use PreviewTechs\DomainReseller\ProviderInterface;
use PreviewTechs\DomainReseller\Utility\HTTP;

class NetEarthOne implements ProviderInterface
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string|int
     */
    protected $authUserId;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * @var bool
     */
    protected $sandbox = false;

    /**
     * NetEarthone constructor.
     * @param $apiKey
     * @param $authUserId
     * @param bool $sandbox
     */
    public function __construct($apiKey, $authUserId, $sandbox = false)
    {
        $this->apiKey = $apiKey;
        $this->authUserId = $authUserId;

        $this->httpClient = HTTP::getClient();

        $sandbox === true ? $this->apiEndpoint = "https://test.httpapi.com/api" : $this->apiEndpoint = "https://httpapi.com/api";
    }

    /**
     * @param string $method
     * @param $path
     * @param array $params
     * @return mixed
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function sendRequest($method = "GET", $path, $params = null)
    {
        $params = array_merge(['auth-userid' => $this->authUserId, 'api-key' => $this->apiKey], $params);

        $requestUrl = $this->apiEndpoint . $path . "?" . http_build_query($params);

        $request = new Request($method, $requestUrl);

        $response = $this->httpClient->sendRequest($request);

        $data = null;

        if (strpos($response->getHeaderLine("Content-Type"), "text/xml") === 0) {
            $xml = simplexml_load_string((string)$response->getBody());
            $data = json_decode(json_encode($xml), TRUE);
        }elseif (strpos($response->getHeaderLine("Content-Type"), "application/xml") === 0) {
            $xml = simplexml_load_string((string)$response->getBody());
            $data = json_decode(json_encode($xml), TRUE);
        } elseif (strpos($response->getHeaderLine("Content-Type"), "application/json") === 0) {
            $data = json_decode((string)$response->getBody(), true);
        } else {
            $data = (string)$response->getBody();
        }

        if (!empty($data['status']) && $data['status'] === "ERROR") {
            throw ProviderExceptions::error($data['message']);
        }

        return $data;
    }

    /**
     * @param array $conditions
     * @param array $options
     * @return array
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function searchCustomers(array $conditions = [], array $options = [])
    {
        $limit = 10;
        $page = 1;

        if (!empty($options['limit']) && ($options['limit'] > 500 || $options['limit'] < 10)) {
            throw new \InvalidArgumentException("Limit per search should be between 10 and 500");
        }

        !empty($options['limit']) ? $limit = $options['limit'] : null;

        if (!empty($options['page']) && $options['page'] > 0) {
            $page = $options['page'];
        }

        $data = $this->sendRequest("GET", "/customers/search.json", ['no-of-records' => $limit, 'page-no' => $page]);

        if (sizeof($data) < 1) {
            return [];
        }

        $result = ['count' => intval($data['recsonpage']), 'total' => intval($data['recsindb']), 'page' => $page, "limit" => $limit];

        $customer = [];
        foreach ($data as $datum) {
            if (!is_array($datum)) {
                continue;
            }

            $c = new Customer();
            $c->setName($datum['customer.name']);
            $c->setUsername($datum['customer.username']);
            $c->setEmailAddress($datum['customer.username']);
            $c->setResellerId($datum['customer.resellerid'] ? intval($datum['customer.resellerid']) : null);

            !empty($datum['customer.company']) ? $c->setCompany($datum['customer.company']) : null;
            !empty($datum['customer.customerstatus']) ? $c->setStatus(strtolower($datum['customer.customerstatus'])) : null;

            $c->setId(intval($datum['customer.customerid']));

            $address = new Address();
            $address->setCity($datum['customer.city']);
            $address->setCountry($datum['customer.country']);
            $c->setAddress($address);

            $customer[] = $c;
        }

        $result['customers'] = $customer;

        return $result;
    }

    /**
     * @param $usernameOrId
     * @return mixed
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getCustomer($usernameOrId)
    {
        if (!strpos($usernameOrId, '@')) {
            $customerData = $this->sendRequest("GET", "/customers/details-by-id.json", ["customer-id" => $usernameOrId]);
        } else {
            $customerData = $this->sendRequest("GET", "/customers/details.json", ["username" => $usernameOrId]);
        }

        $customer = new Customer();
        $customer->setId(intval($customerData['customerid']));
        $customer->setStatus(strtolower($customerData['customerstatus']));
        $customer->setName($customerData['name']);
        $customer->setUsername($customerData['username']);

        !empty($customerData['company']) ? $customer->setCompany($customerData['company']) : null;
        !empty($customerData['resellerid']) ? $customer->setResellerId($customerData['resellerid']) : null;
        !empty($customerData['langpref']) ? $customer->setLanguage($customerData['langpref']) : null;
        $customerData['twofactorauth_enabled'] === "false" ? $customer->setTwoFactorAuthEnabled(false) : $customer->setTwoFactorAuthEnabled(true);

        $customer->setEmailAddress($customerData['useremail']);

        if (!empty($customerData['pin'])) {
            $customer->setPin($customerData['pin']);
        }

        $address = new Address();
        $address->setPrimaryStreet($customerData['address1']);

        if(!empty($customerData['address2'])){
            $address->setSecondaryStreet($customerData['address2']);
        }

        $address->setCity($customerData['city']);
        $address->setState($customerData['state']);
        $address->setZipCode($customerData['zip']);

        if (!empty($customerData['mobileno'])) {
            !empty($customerData['telnocc']) ? $address->setMobileCountryCode(intval($customerData['telnocc'])) : null;
            $address->setMobile(intval($customerData['mobileno']));
        }

        if (!empty($customerData['telno'])) {
            !empty($customerData['telnocc']) ? $address->setTelephoneCountryCode(intval($customerData['telnocc'])) : null;
            $address->setTelephone(intval($customerData['telno']));
        }

        if (!empty($customerData['faxno'])) {
            !empty($customerData['faxnocc']) ? $address->setFaxCountryCode(intval($customerData['faxnocc'])) : null;
            $address->setFax(intval($customerData['faxno']));
        }

        $customer->setAddress($address);

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function createCustomer(Customer $customer)
    {
        if($customer->getUsername()){
            $isAlreadyExists = $this->getCustomer($customer->getUsername());
            if(!empty($isAlreadyExists)){
                return $isAlreadyExists;
            }
        }

        $params = [
            'username' => $customer->getUsername(),
            'name' => $customer->getName(),
            'company' => $customer->getCompany(),
            'address-line-1' => $customer->getAddress()->getPrimaryStreet(),
            'city' => $customer->getAddress()->getCity(),
            'state' => $customer->getAddress()->getState(),
            'country' => $customer->getAddress()->getCountry(),
            'zipcode' => $customer->getAddress()->getZipCode(),
            'phone-cc' => $customer->getAddress()->getTelephoneCountryCode(),
            'lang-pref' => $customer->getLanguage(),
            'passwd' => $customer->getPassword(),
            'phone' => $customer->getAddress()->getTelephone()
        ];

        $requiredFields = ["username", "name", "company", "address-line-1", "city", "state", "country", "zipcode", "phone-cc", "lang-pref", "phone", "passwd"];
        foreach ($requiredFields as $requiredField){
            if(empty($requiredField)){
                throw new ProviderExceptions(sprintf("`%s` field value required", $requiredField));
            }
        }

        $data = $this->sendRequest("POST", "/customers/v2/signup.xml", $params);

        $customer->setPassword(null);

        if (!is_array($data)) {
            $re = '/<int>(.*)<\/int>/m';
            $str = $data;

            preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
            if (sizeof($matches) > 0) {
                $customer->setId(intval($matches[0][1]));
                return $customer;
            }
        }

        if (empty($customer->getId())) {
            throw new ProviderExceptions("Failed to created customer. Unknown error");
        }

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function modifyCustomer(Customer $customer)
    {
        if (empty($customer->getId())) {
            throw new \InvalidArgumentException("Customer ID must be present to update customer information");
        }

        $params = [
            'customer-id' => intval($customer->getId()),
            'username' => $customer->getUsername(),
            'name' => $customer->getName(),
            'company' => $customer->getCompany(),
            'address-line-1' => $customer->getAddress()->getPrimaryStreet(),
            'city' => $customer->getAddress()->getCity(),
            'state' => $customer->getAddress()->getState(),
            'country' => $customer->getAddress()->getCountry(),
            'zipcode' => $customer->getAddress()->getZipCode(),
            'phone-cc' => $customer->getAddress()->getTelephoneCountryCode(),
            'lang-pref' => $customer->getLanguage(),
            'phone' => $customer->getAddress()->getTelephone()
        ];
        $data = $this->sendRequest("POST", "/customers/modify.json", $params);

        if ($data) {
            $customer->setPassword(null);
            return $customer;
        }

        throw new ProviderExceptions("Failed to update customer. Unknown reason");
    }

    /**
     * @param $domainName
     * @param array $extensions
     * @return bool
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function isDomainAvailable($domainName, $extensions)
    {
        $result = $this->sendRequest('GET', '/domains/available.json', ['domain-name' => $domainName, 'tlds' => $extensions]);

        if (is_array($result)) {
            $data = reset(array_values($result));
            if (!empty($data['status']) && $data['status'] === "available") {
                return true;
            } elseif (!empty($data['status']) && $data['status'] === "regthroughothers") {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $keyWord
     * @param null $tld
     * @param bool $exactMatch
     * @return array
     * @throws ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getSuggestions($keyWord, $tld = null, $exactMatch = false)
    {
        $results = $this->sendRequest("GET", "/domains/v5/suggest-names.json", ['keyword' => $keyWord, 'exact-match' => $exactMatch, 'tld-only' => $tld]);

        if (sizeof($results) < 1) {
            return [];
        }

        return array_keys($results);
    }

    protected function addContact($customerId, Contact $contact)
    {
        if(!empty($contact->getId())){
            return $contact;
        }

        $queryParams = [
            'name' => $contact->getName(),
            'customer-id' => $customerId,
            'company' => $contact->getCompany(),
            'email' => $contact->getEmail(),
            'address-line-1' => $contact->getAddress()->getPrimaryStreet(),
            'address-line-2' => $contact->getAddress()->getSecondaryStreet(),
            'city' => $contact->getAddress()->getCity(),
            'state' => $contact->getAddress()->getState(),
            'country' => $contact->getAddress()->getCountry(),
            'zipcode' => $contact->getAddress()->getZipCode(),
            'phone-cc' => $contact->getAddress()->getTelephoneCountryCode(),
            'phone' => $contact->getAddress()->getTelephone(),
            'fax-cc' => $contact->getAddress()->getFaxCountryCode(),
            'fax' => $contact->getAddress()->getFax(),
            'type' => $contact->getType()
        ];

        $results = $this->sendRequest("GET", "/contacts/add.json", $queryParams);
        if(is_int($results)){
            $contact->setId($results);
            return $contact;
        }

        return null;
    }

    public function registerDomain($domainName, Customer $customer, Contact $registrantContact = null, Contact $administrativeContact = null, Contact $technicalContact = null, Contact $billingContact = null, array $options = [])
    {
        if(empty($options['ns'])){
            throw new ProviderExceptions("options[ns] value must be provided to register domain");
        }

        $customerId = $customer->getId();
        if(empty($customer->getId())){
            $customer = $this->createCustomer($customer);
            $customerId = $customer->getId();
        }

        $registrantContactId = $this->addContact($customerId, $registrantContact);
        $administrativeContactId = $this->addContact($customerId, $administrativeContact);
        $technicalContactId = $this->addContact($customerId, $technicalContact);
        $billingContactId = $this->addContact($customerId, $billingContact);

        $queryParams = [
            "domain-name" => $domainName,
            "years" => !empty($options['years']) ? intval($options['years']) : 1,
            'ns' => $options['ns'],
            'customer-id' => $customerId,
            'reg-contact-id' => $registrantContactId->getId(),
            'admin-contact-id' => $administrativeContactId->getId(),
            'tech-contact-id' => $technicalContactId->getId(),
            'billing-contact-id' => $billingContactId->getId(),
            'invoice-option' => !empty($options['invoice-option']) ? $options['invoice-option'] : "PayInvoice",
            "purchase-privacy" => !empty($options['purchase-privacy']) ? $options['purchase-privacy'] : false,
            'protect-privacy' => !empty($options['protect-privacy']) ? $options['protect-privacy'] : false,
            'auto-renew' => !empty($options['auto-renew']) ? $options['auto-renew'] : false
        ];

        $result = $this->sendRequest("GET", "/domains/register.xml", $queryParams);

        return $result;
    }
}