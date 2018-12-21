<?php

namespace PreviewTechs\DomainReseller\Providers;

use DateTime;
use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client;
use Http\Client\Exception;
use PreviewTechs\DomainReseller\Entity\Address;
use PreviewTechs\DomainReseller\Entity\Contact;
use PreviewTechs\DomainReseller\Entity\Customer;
use PreviewTechs\DomainReseller\Entity\Domain;
use PreviewTechs\DomainReseller\Entity\Locks;
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
    protected function sendRequest($method = "GET", $path, $params = null)
    {
        $params = array_merge(['auth-userid' => $this->authUserId, 'api-key' => $this->apiKey], $params);

        $requestUrl = $this->apiEndpoint . $path . "?" . $this->query_builder($params);

        $request = new Request($method, $requestUrl);

        $response = $this->httpClient->sendRequest($request);

        $data = null;

        if (strpos($response->getHeaderLine("Content-Type"), "text/xml") === 0) {
            $xml = simplexml_load_string((string)$response->getBody());
            $data = json_decode(json_encode($xml), TRUE);
        } elseif (strpos($response->getHeaderLine("Content-Type"), "application/xml") === 0) {
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

    protected function query_builder($a, $b = 0, $c = 0)
    {
        if (!is_array($a)) return false;
        foreach ((array)$a as $k => $v) {
            if ($c) $k = $b . ""; elseif (is_int($k)) $k = $b . $k;
            if (is_array($v) || is_object($v)) {
                $r[] = $this->query_builder($v, $k, 1);
                continue;
            }
            $r[] = urlencode($k) . "=" . urlencode($v);
        }
        return implode("&", $r);
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

        if (!empty($customerData['address2'])) {
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
        if ($customer->getUsername()) {
            try {
                $isAlreadyExists = $this->getCustomer($customer->getUsername());
            } catch (Exception $e) {
            } catch (ProviderExceptions $e) {
            }

            if (!empty($isAlreadyExists)) {
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
        foreach ($requiredFields as $requiredField) {
            if (empty($requiredField)) {
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
        } else {
            $customer->setId(intval($data[0]));
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
            $result = array_values($result);
            $data = reset($result);
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

    /**
     * @param $customerId
     * @param Contact $contact
     *
     * @return null|Contact|Customer
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function addContact($customerId, Contact $contact)
    {
        if (!empty($contact->getId())) {
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
        if (is_int($results)) {
            $contact->setId($results);
            return $contact;
        }

        return null;
    }

    /**
     * @param $customerId
     * @param array $conditions
     * @param array $options
     *
     * @return mixed|null|Contact[]
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function listContacts($customerId, array $conditions = [], array $options = [])
    {
        $limit = 10;
        $page = 1;
        if(!empty($options['limit'])){
            $limit = intval($options['limit']);
        }

        if(!empty($options['page'])){
            $page = intval($options['page']);
        }

        if($limit < 10){
            throw new ProviderExceptions("Invalid limit specified. Please enter a value between 10 and 500.");
        }

        $conditions = array_merge(['no-of-records' => $limit, 'page-no' => $page, 'customer-id' => $customerId], $conditions);
        $result = $this->sendRequest("GET", "/contacts/search.json", $conditions);

        $data = [
            'pagination' => [
                'perPage' => $limit,
                'page' => $page,
                'total' => intval($result['recsindb'])
            ],
            'contacts' => []
        ];

        foreach ($result['result'] as $item => $value){
            if(is_array($value)){
                $tc = new Contact();
                $tc->setId($value['contact.contactid']);
                $tc->setCompany($value['contact.company']);
                $tc->setName($value['contact.name']);
                $tc->setEmail($value['contact.emailaddr']);
                $tc->setType($value['contact.type']);

                $address = new Address();
                $address->setTelephoneCountryCode($value['contact.telnocc']);
                $address->setTelephone($value['contact.telno']);
                $address->setPrimaryStreet($value['contact.address1']);
                $address->setCity($value['contact.city']);
                $address->setState($value['contact.state']);
                $address->setZipCode($value['contact.zip']);
                $address->setCountry($value['contact.country']);
                $tc->setAddress($address);
                $data['contacts'][] = $tc;
            }
        }

        return $data;
    }

    public function contactDetails($contactId)
    {
        $contactArray = $this->sendRequest("GET", "/contacts/details.json", ['contact-id' => $contactId]);
        if(empty($contactArray)){
            return null;
        }

        $tc = new Contact();
        $tc->setId($contactArray['contactid']);
        $tc->setCompany($contactArray['company']);
        $tc->setName($contactArray['name']);
        $tc->setEmail($contactArray['emailaddr']);
        $tc->setType($contactArray['type']);

        $address = new Address();
        $address->setTelephoneCountryCode($contactArray['telnocc']);
        $address->setTelephone($contactArray['telno']);
        $address->setPrimaryStreet($contactArray['address1']);
        $address->setCity($contactArray['city']);
        $address->setState($contactArray['state']);
        $address->setZipCode($contactArray['zip']);
        $address->setCountry($contactArray['country']);
        $tc->setAddress($address);

        return $tc;
    }

    /**
     * @param $customerId
     * @param string $type
     * @param $registrantContactId
     * @param $technicalContactId
     * @param $billingContactId
     * @param $adminContactId
     * @return array|bool
     * @throws Exception
     * @throws ProviderExceptions
     */
    protected function setDefaultContacts($customerId, $type = "Contact", $registrantContactId, $technicalContactId, $billingContactId, $adminContactId)
    {
        $params = [
            'customer-id' => $customerId,
            'reg-contact-id' => $registrantContactId,
            'admin-contact-id' => $adminContactId,
            'tech-contact-id' => $technicalContactId,
            'billing-contact-id' => $billingContactId,
            'type' => $type
        ];

        $result = $this->sendRequest("POST", "/contacts/modDefault.json", $params);
        if (empty($result)) {
            return false;
        }

        return $params;
    }

    /**
     * @param $customerId
     * @param string $type
     * @return bool|mixed
     * @throws Exception
     * @throws ProviderExceptions
     */
    protected function getDefaultContacts($customerId, $type = "Contact")
    {
        $params = [
            'customer-id' => $customerId,
            'type' => $type
        ];

        $result = $this->sendRequest("GET", "/contacts/default.json", $params);

        if (empty($result) || !array_key_exists("Contact", $result)) {
            return false;
        }

        $contacts = [
            'registrant' => !empty($result['Contact']['registrant']) ? intval($result['Contact']['registrant']) : null,
            'technical' => !empty($result['Contact']['tech']) ? intval($result['Contact']['tech']) : null,
            'billing' => !empty($result['Contact']['billing']) ? intval($result['Contact']['billing']) : null,
            'administrative' => !empty($result['Contact']['admin']) ? intval($result['Contact']['admin']) : null,
        ];

        /*foreach ($result['Contact'] as $item => $value){
            if(is_array($value)){
                $tc = new Contact();
                $tc->setId($value['contact.contactid']);
                $tc->setCompany($value['contact.company']);
                $tc->setName($value['contact.name']);
                $tc->setEmail($value['contact.emailaddr']);
                $tc->setType($value['contact.type']);

                $address = new Address();
                $address->setTelephoneCountryCode($value['contact.telnocc']);
                $address->setTelephone($value['contact.telno']);
                $address->setPrimaryStreet($value['contact.address1']);
                $address->setCity($value['contact.city']);
                $address->setState($value['contact.state']);
                $address->setZipCode($value['contact.zip']);
                $address->setCountry($value['contact.country']);
                $tc->setAddress($address);
                $contacts[$item] = $tc;
            }
        }*/

        return $contacts;
    }

    /**
     * @param $domainName
     * @param Customer $customer
     * @param Contact|null $registrantContact
     * @param Contact|null $administrativeContact
     * @param Contact|null $technicalContact
     * @param Contact|null $billingContact
     * @param array $options
     * @return Domain
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function registerDomain($domainName, Customer $customer, Contact $registrantContact = null, Contact $administrativeContact = null, Contact $technicalContact = null, Contact $billingContact = null, array $options = [])
    {
        if (empty($options['ns'])) {
            throw new ProviderExceptions("options[ns] value must be provided to register domain");
        }

        if (!empty($options['invoice-option'])) {
            if (!in_array($options['invoice-option'], ['PayInvoice', 'NoInvoice', 'KeepInvoice', 'OnlyAdd'])) {
                throw new ProviderExceptions("Invalid `options[invoice-option]` value. Accepted values are: PayInvoice, NoInvoice, KeepInvoice, OnlyAdd");
            }
        }

        $customerId = $customer->getId();
        if (empty($customer->getId())) {
            $customer = $this->createCustomer($customer);
            $customerId = $customer->getId();
        }

        $defaultContacts = $this->getDefaultContacts($customerId);

        if (!$registrantContact && empty($defaultContacts['registrant'])) {
            throw new ProviderExceptions("You must provide registrant contact information");
        }

        if (!$administrativeContact && empty($defaultContacts['administrative'])) {
            throw new ProviderExceptions("You must provide administrative contact information");
        }

        if (!$billingContact && empty($defaultContacts['billing'])) {
            throw new ProviderExceptions("You must provide billing contact information");
        }

        if (!$technicalContact && empty($defaultContacts['technical'])) {
            throw new ProviderExceptions("You must provide technical contact information");
        }

        $registrantContactId = !empty($registrantContact) ? $this->addContact($customerId, $registrantContact) : (new Contact())->setId($defaultContacts['registrant']);
        $administrativeContactId = !empty($administrativeContact) ? $this->addContact($customerId, $administrativeContact) : (new Contact())->setId($defaultContacts['administrative']);
        $technicalContactId = !empty($technicalContact) ? $this->addContact($customerId, $technicalContact) : (new Contact())->setId($defaultContacts['technical']);
        $billingContactId = !empty($billingContact) ? $this->addContact($customerId, $billingContact) : (new Contact())->setId($defaultContacts['billing']);

        if (!$defaultContacts || !$defaultContacts['technical'] || !$defaultContacts['billing'] || !$defaultContacts['registrant'] || !$defaultContacts['administrative']) {
            $this->setDefaultContacts($customerId, 'Contact', $registrantContactId->getId(), $technicalContactId->getId(), $billingContactId->getId(), $administrativeContactId->getId());
        }

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
            "purchase-privacy" => !empty($options['purchase-privacy']) ? boolval($options['purchase-privacy']) : false,
            'protect-privacy' => !empty($options['protect-privacy']) ? boolval($options['protect-privacy']) : false,
            'auto-renew' => !empty($options['auto-renew']) ? boolval($options['auto-renew']) : false
        ];

        $result = $this->sendRequest("GET", "/domains/register.xml", $queryParams);

        if (!array_key_exists("entry", $result)) {
            throw new ProviderExceptions("Unknown error occured. Error: " . json_encode($result));
        }

        $output = [];
        foreach ($result['entry'] as $item) {
            $output[$item['string'][0]] = $item['string'][1];
        }

        if ($output['status'] === "error") {
            throw new ProviderExceptions($output['error']);
        }

        $refinedOutput = [
            'orderId' => $output['entityid'],
            'status' => $output['status'] === "Success" ? "success" : null,
            'domain' => $domainName
        ];

        if (!empty($output['actionstatus'])) {
            $refinedOutput['actionStatus'] = $output['actionstatus'] === "Success" ? "success" : strtolower($output['actionstatus']);
        }

        if (!empty($output['eaqid'])) {
            $refinedOutput['privacyProtectionPurchaseActionId'] = $output['eaqid'];
        }

        if (!empty($output['customerid'])) {
            $refinedOutput['customerId'] = $output['customerid'];
        }

        if (!empty($output['invoiceid'])) {
            $refinedOutput['invoiceId'] = $output['invoiceid'];
        }

        if (!empty($output['sellingcurrencysymbol'])) {
            $refinedOutput['sellingCurrency'] = $output['sellingcurrencysymbol'];
        }

        if (!empty($output['sellingamount'])) {
            $refinedOutput['sellingAmount'] = $output['sellingamount'];
        }

        if (!empty($output['pendingamount'])) {
            $refinedOutput['pendingAmount'] = $output['pendingamount'];
        }

        return $this->domainDetails($domainName);
    }

    /**
     * @param $domain
     * @param array $options
     * @return \PreviewTechs\DomainReseller\Entity\Domain
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function domainDetails($domain, array $options = [])
    {
        $queryParams = [
            'domain-name' => $domain,
            'options' => "All"
        ];

        $result = $this->sendRequest("GET", "/domains/details-by-name.json", $queryParams);

        if (empty($result['domainname'])) {
            throw new ProviderExceptions("Domain not found");
        }

        $domain = new \PreviewTechs\DomainReseller\Entity\Domain();
        $order = new \PreviewTechs\DomainReseller\Entity\DomainOrder();

        $domain->setName($result['domainname']);

        if (!empty($result['creationtime'])) {
            $createdAt = DateTime::createFromFormat(DATE_ATOM, date(DATE_ATOM, $result['creationtime']));
            $domain->setCreatedAt($createdAt);
        }

        if (!empty($result['endtime'])) {
            $expirationTime = DateTime::createFromFormat(DATE_ATOM, date(DATE_ATOM, $result['endtime']));
            $domain->setExpirationDate($expirationTime);
        }

        $domain->setCurrentStatus($result['currentstatus']);

        if (!empty($result['domsecret'])) {
            $domain->setDomainSecret($result['domsecret']);
        }

        if (!empty($result['domainstatus'])) {
            $domain->setStatus($result['domainstatus']);
        }

        $noOfNS = intval($result['noOfNameServers']);
        for ($i = 1; $i <= $noOfNS; $i++) {
            $nameServers[$i] = $result['ns' . $i];
        }
        $domain->setNameServers($nameServers);

        if (!empty($result['raaVerificationStatus'])) {
            $domain->setRegistrantContactEmailVerificationStatus($result['raaVerificationStatus']);
        }

        if (!empty($result['raaVerificationStartTime'])) {
            $raaVerificationStartTime = DateTime::createFromFormat(DATE_ATOM, date(DATE_ATOM, $result['raaVerificationStartTime']));
            $domain->setRegistrantContactEmailVerificationTime($raaVerificationStartTime);
        }

        $registrantContact = new Contact();
        $registrantContact->setCompany($result['registrantcontact']['company']);
        $registrantContact->setName($result['registrantcontact']['name']);
        $registrantContact->setEmail($result['registrantcontact']['emailaddr']);
        $registrantContact->setType($result['registrantcontact']['type']);
        $registrantContact->setCustomerId($result['registrantcontact']['customerid']);
        $registrantContact->setId($result['registrantcontact']['contactid']);

        $registrantContactAddress = new Address();
        $registrantContactAddress->setPrimaryStreet($result['registrantcontact']['address1']);
        $registrantContactAddress->setTelephone($result['registrantcontact']['telno']);
        $registrantContactAddress->setTelephoneCountryCode($result['registrantcontact']['telnocc']);
        $registrantContactAddress->setCountry($result['registrantcontact']['country']);
        $registrantContactAddress->setState($result['registrantcontact']['state']);
        $registrantContactAddress->setCity($result['registrantcontact']['city']);
        $registrantContactAddress->setZipCode($result['registrantcontact']['zip']);
        $registrantContact->setAddress($registrantContactAddress);
        $domain->setRegistrantContact($registrantContact);

        $adminContact = new Contact();
        $adminContact->setCompany($result['admincontact']['company']);
        $adminContact->setName($result['admincontact']['name']);
        $adminContact->setEmail($result['admincontact']['emailaddr']);
        $adminContact->setType($result['admincontact']['type']);
        $adminContact->setCustomerId($result['admincontact']['customerid']);
        $adminContact->setId($result['admincontact']['contactid']);

        $adminContactAddress = new Address();
        $adminContactAddress->setPrimaryStreet($result['admincontact']['address1']);
        $adminContactAddress->setTelephone($result['admincontact']['telno']);
        $adminContactAddress->setTelephoneCountryCode($result['admincontact']['telnocc']);
        $adminContactAddress->setCountry($result['admincontact']['country']);
        $adminContactAddress->setState($result['admincontact']['state']);
        $adminContactAddress->setCity($result['admincontact']['city']);
        $adminContactAddress->setZipCode($result['admincontact']['zip']);
        $adminContact->setAddress($adminContactAddress);
        $domain->setAdministrativeContact($adminContact);

        $techContact = new Contact();
        $techContact->setCompany($result['techcontact']['company']);
        $techContact->setName($result['techcontact']['name']);
        $techContact->setEmail($result['techcontact']['emailaddr']);
        $techContact->setType($result['techcontact']['type']);
        $techContact->setCustomerId($result['techcontact']['customerid']);
        $techContact->setId($result['techcontact']['contactid']);

        $techContactAddress = new Address();
        $techContactAddress->setPrimaryStreet($result['techcontact']['address1']);
        $techContactAddress->setTelephone($result['techcontact']['telno']);
        $techContactAddress->setTelephoneCountryCode($result['techcontact']['telnocc']);
        $techContactAddress->setCountry($result['techcontact']['country']);
        $techContactAddress->setState($result['techcontact']['state']);
        $techContactAddress->setCity($result['techcontact']['city']);
        $techContactAddress->setZipCode($result['techcontact']['zip']);
        $techContact->setAddress($techContactAddress);
        $domain->setTechnicalContact($techContact);

        $billingContact = new Contact();
        $billingContact->setCompany($result['billingcontact']['company']);
        $billingContact->setName($result['billingcontact']['name']);
        $billingContact->setEmail($result['billingcontact']['emailaddr']);
        $billingContact->setType($result['billingcontact']['type']);
        $billingContact->setCustomerId($result['billingcontact']['customerid']);
        $billingContact->setId($result['billingcontact']['contactid']);

        $billingContactAddress = new Address();
        $billingContactAddress->setPrimaryStreet($result['billingcontact']['address1']);
        $billingContactAddress->setTelephone($result['billingcontact']['telno']);
        $billingContactAddress->setTelephoneCountryCode($result['billingcontact']['telnocc']);
        $billingContactAddress->setCountry($result['billingcontact']['country']);
        $billingContactAddress->setState($result['billingcontact']['state']);
        $billingContactAddress->setCity($result['billingcontact']['city']);
        $billingContactAddress->setZipCode($result['billingcontact']['zip']);
        $billingContact->setAddress($billingContactAddress);
        $domain->setBillingContact($billingContact);


        $order->setId($result['orderid']);
        if (!empty($result['actionstatus'])) {
            $order->setActionStatus($result['actionstatus']);
        }

        if (!empty($result['actionstatusdesc'])) {
            $order->setActionStatusDescription($result['actionstatusdesc']);
        }

        $order->setAllowedDeletion((bool)$result['allowdeletion']);
        $order->setIsOrderSuspendedUponExpiry((bool)$result['isOrderSuspendedUponExpiry']);
        $order->setOrderSuspendedByParent((bool)$result['orderSuspendedByParent']);
        $order->setProductKey($result['productkey']);
        $order->setProductCategory($result['productcategory']);
        $order->setCustomerCost((double)$result['customercost']);
        $order->setClassName($result['classname']);
        $order->setStatus($result['orderstatus']);

        $customer = $this->getCustomer($result['customerid']);
        $domain->setCustomer($customer);
        $order->setCustomer($customer);

        if (!empty($result['isprivacyprotected'])) {
            $domain->setPrivacyProtected($result['isprivacyprotected']);
            $order->setPrivacyProtected($result['isprivacyprotected']);
        } else {
            $domain->setPrivacyProtected(false);
            $order->setPrivacyProtected(false);
        }

        $domain->setOrder($order);

        return $domain;
    }

    /**
     * @param $domainName
     * @return array|null
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function isPremium($domainName)
    {
        $queryParams = [
            'domain-name' => $domainName
        ];

        $result = $this->sendRequest("GET", "/domains/premium-check.json", $queryParams);
        return $result;
    }

    /**
     * @param $domain
     * @return array|Locks
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function getAllLocks($domain)
    {
        $orderId = $this->getOrderId($domain);
        if (empty($orderId)) {
            throw new ProviderExceptions("Failed to get order id for this domain");
        }

        $queryParams = [
            'order-id' => $orderId
        ];

        $result = $this->sendRequest("GET", "/domains/locks.json", $queryParams);
        if (!is_array($result) || sizeof($result) < 1) {
            return [];
        }

        if (array_key_exists('transferlock', $result) && array_key_exists("customerlock", $result) && $result['customerlock'] === true && $result['transferlock'] === true) {
            $result['theft_protection'] = true;
        }

        $lock = new Locks();
        if (!empty($result['customerlock'])) {
            $lock->setCustomerLock($result['customerlock']);
        }

        if (!empty($result['transferlock'])) {
            $lock->setTransferLock($result['transferlock']);
        }

        if (!empty($result['resellerlock'])) {
            $lock->setResellerLock(true);
            !empty($result['resellerlock'][1]['lockerid']) ? $lock->setResellerLockerId($result['resellerlock'][1]['lockerid']) : null;
            !empty($result['resellerlock'][1]['addedby']) ? $lock->setResellerLockAddedBy($result['resellerlock'][1]['addedby']) : null;
            !empty($result['resellerlock'][1]['reason']) ? $lock->setResellerLockReason($result['resellerlock'][1]['reason']) : null;

            if (!empty($result['resellerlock'][1]['creationdt'])) {
                $cd = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s", $result['resellerlock'][1]['creationdt']));
                $lock->setResellerLockCreatedAt($cd);
            }
        }

        if (!empty($result['theft_protection'])) {
            $lock->setTheftProtectionEnabled(true);
        } else {
            $lock->setTheftProtectionEnabled(false);
        }

        return $lock;
    }

    /**
     * @param $domain
     * @return array|null
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function enableTheftProtection($domain)
    {
        $orderId = $this->getOrderId($domain);
        if (empty($orderId)) {
            throw new ProviderExceptions("Failed to get order id for this domain");
        }

        $queryParams = [
            'order-id' => $orderId
        ];

        $result = $this->sendRequest("GET", "/domains/enable-theft-protection.json", $queryParams);
        return $result;
    }

    /**
     * @param $domain
     * @return array|null
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function disableTheftProtection($domain)
    {
        $orderId = $this->getOrderId($domain);
        if (empty($orderId)) {
            throw new ProviderExceptions("Failed to get order id for this domain");
        }

        $queryParams = [
            'order-id' => $orderId
        ];

        $result = $this->sendRequest("GET", "/domains/disable-theft-protection.json", $queryParams);
        return $result;
    }

    /**
     * @param $domain
     * @param array $nameServers
     * @return array|null
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function updateNameServers($domain, array $nameServers)
    {
        $orderId = $this->getOrderId($domain);
        if (empty($orderId)) {
            throw new ProviderExceptions("Failed to get order id for this domain");
        }

        $queryParams = [
            'order-id' => $orderId,
            'ns' => $nameServers
        ];

        $result = $this->sendRequest("GET", "/domains/modify-ns.json", $queryParams);
        return $result;
    }

    /**
     * @param array $domain
     * @param null $authCode
     * @return array
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function changeAuthCode($domain, $authCode = null)
    {
        if(empty($authCode)){
            throw new ProviderExceptions("Auth code must be required");
        }

        //AuthCode validation
        $re = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}/m';

        preg_match_all($re, $authCode, $matches, PREG_SET_ORDER, 0);
        if(sizeof($matches) < 1){
            throw new ProviderExceptions("Auth code must contain atleast one alphabet, one number and one special character");
        }

        $orderId = $this->getOrderId($domain);
        if (empty($orderId)) {
            throw new ProviderExceptions("Failed to get order id for this domain");
        }

        $queryParams = [
            'order-id' => $orderId,
            'auth-code' => $authCode
        ];

        $result = $this->sendRequest("GET", "/domains/modify-auth-code.json", $queryParams);
        return $result;
    }

    /**
     * @param $domain
     * @return int
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function getOrderId($domain)
    {
        $result = $this->sendRequest("GET", "/domains/orderid.json", ['domain-name' => $domain]);
        return $result;
    }

    /**
     * @param $customerId
     *
     * @param string $type
     *
     * @return Contact[]
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function getCustomerDefaultContacts($customerId, $type = "Contact")
    {
        return $this->sendRequest("GET", "/contacts/default.json", ['customer-id' => $customerId, 'type' => $type]);
    }

    /**
     * @param $domain
     * @param array $conditions
     * @param array $options
     *
     * @return mixed
     * @throws Exception
     * @throws ProviderExceptions
     */
    public function actionList(array $conditions = [], array $options = [])
    {
        if(!empty($conditions['domain'])){
            $conditions['order-id'] = $this->getOrderId($conditions['domain']);
            if (empty($conditions['order-id'])) {
                throw new ProviderExceptions("Failed to get order id for this domain");
            }
        }

        $noOfRecords = 5;
        $pageNumber = 1;
        if(!empty($options['limit'])){
            $noOfRecords = intval($options['limit']);
        }

        if(!empty($options['page'])){
            $pageNumber = intval($options['page']);
        }

        unset($conditions['domain']);

        $result = $this->sendRequest("GET", "/actions/search-current.json", array_merge($conditions, ['no-of-records' => $noOfRecords, 'page-no' => $pageNumber]));

        $data = [
            'actions' => null
        ];

        if(is_array($result)){
            $data['pagination'] = [
                'page' => $pageNumber,
                'perPage' => $noOfRecords,
                'total' => intval($result['recsindb'])
            ];

            unset($result['recsindb'], $result['recsonpage']);
            $data['actions'] = $result;
        }

        return $data;
    }
}