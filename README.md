## Domain reseller API

This will perform all the operation to register domain, check domain, WHOIS lookup and most of the major action from your Domain reseller control panel. it's pretty simple to use.

### Installation via Composer
Install this library with composer by running the following command

```
composer require previewtechs/domain-reseller-api:dev-master
```

Now just add the following code in your PHP script where you will use this library.

```php
<?php

//Get domain name suggestions

use PreviewTechs\DomainReseller\Domains;
use PreviewTechs\DomainReseller\Exceptions\ProviderExceptions;
use PreviewTechs\DomainReseller\Providers\NetEarthOne;

require "vendor/autoload.php";

$domainResellerProvider = new NetEarthOne("NET_EARTH_ONE_API_KEY", "NET_EARTH_ONE_AUTH_ID", true);
$domain = new Domains($domainResellerProvider);
try {
    $suggestedDomains = $domain->getSuggestions("example");
} catch (\Http\Client\Exception $e) {
    echo $e->getMessage();
} catch (ProviderExceptions $e) {
    echo $e->getMessage();
}

var_dump($suggestedDomains);
```

```
array(4) {
  [0] =>
  string(14) "example.online"
  [1] =>
  string(10) "example.pt"
  [2] =>
  string(12) "example.site"
  [3] =>
  string(15) "example.website"
}
```


### Documentation
#### Register Domain Name
```php
<?php

//Get domain name suggestions

use PreviewTechs\DomainReseller\Domains;
use PreviewTechs\DomainReseller\Providers\NetEarthOne;

require "vendor/autoload.php";

$domainResellerProvider = new NetEarthOne("NET_EARTH_ONE_API_KEY", "NET_EARTH_ONE_AUTH_ID", true);
$domain = new Domains($domainResellerProvider);

$customer = new \PreviewTechs\DomainReseller\Entity\Customer();
$customer->setEmailAddress("email@example.com");
$customer->setName("Your Name");
$customer->setUsername("email@example.com");
$customer->setCompany("Company Name");

$address = new \PreviewTechs\DomainReseller\Entity\Address();
$address->setPrimaryStreet("Address Line 1");
$address->setState("State");
$address->setCity("City");
$address->setZipCode("ZIP_CODE");
$address->setCountry("2 DIGIT COUNTRY CODE");
$address->setTelephone("PHONE_NUMBER");
$address->setTelephoneCountryCode("TELEPHONE COUNTRY CODE");

$customer->setAddress($address);
$customer->setPassword("PASSWORD");
$customer->setLanguage("2 DIGIT LANGUAGE CODE");

$result = $domain->registerDomain("domainname.com", $customer, null,null, null, null, [
    'ns' => [
        'ns.yournameserver.com', 
        'ns2.yournameserver.com'
    ], 
    'invoice-option' => 'PayInvoice'
]);

var_dump($result);
```

#### Get Domain (order) Details
```php
<?php
$domainDetails = $domain->domainDetails("domainname.com");
var_dump($domainDetails);
```

#### Check Domain Availability
```php
<?php
$available = $domain->isAvailable("domainname", "com");
var_dump($available);
```

#### Get Name Suggestion
```php
<?php
$suggestions = $domain->getSuggestions("Book Store");
var_dump($suggestions);
```

#### Create Customer Account
```php
<?php
$customer = new \PreviewTechs\DomainReseller\Entity\Customer();
$customer->setEmailAddress("email@example.com");
$customer->setName("Your Name");
$customer->setUsername("email@example.com");
$customer->setCompany("Company Name");

$address = new \PreviewTechs\DomainReseller\Entity\Address();
$address->setPrimaryStreet("Address Line 1");
$address->setState("State");
$address->setCity("City");
$address->setZipCode("ZIP_CODE");
$address->setCountry("2 DIGIT COUNTRY CODE");
$address->setTelephone("PHONE_NUMBER");
$address->setTelephoneCountryCode("TELEPHONE COUNTRY CODE");
$customer->setAddress($address);
$customer->setPassword("PASSWORD");
$customer->setLanguage("2 DIGIT LANGUAGE CODE");

$customerDetails = $domain->createCustomer($customer);
var_dump($customerDetails);
```

#### Get Customer Details
```php
<?php
$customerDetails = $domain->getCustomer("CustomerID");
var_dump($customerDetails);
```


This library support multiple provider and easily extensible.

### Supported Domain Reseller API Provider

- [NetEarth One](https://www.netearthone.com)
  
  Provider Class: `PreviewTechs\DomainReseller\Providers\NetEarthOne`
  
- [ResellerClub](https://www.resellerclub.com)

  Provider Class: `\PreviewTechs\DomainReseller\Providers\ResellerClub`
  
- NameCheap (Coming Soon)

Please suggest us with any domain reseller api provider that you want by creating a [feature request](https://github.com/PreviewTechnologies/domain-reseller-api/issues/new).

### Features
- Customers
  - Creating Customers
  - Get Customer Details
  - Update Customer Information
  - Search Customers
  
- Domains
  - Availability Check
  - Name Suggestions
  
More features are coming soon!

### Support

- [Issue Tracker](https://github.com/PreviewTechnologies/domain-reseller-api/issues/new)

If you find any bug/issues please create an issue from GitHub issue tracker.

### Contributions

This library can be easily extensible. If you want to contribute in this library you are always welcome. To contribute,
please see current issues and fix them or you can directly add new providers by implementing `ProviderInterface` interface.

[Fork](https://github.com/PreviewTechnologies/domain-reseller-api/fork) this repository and send us pull request and we will be happy to merge that after verifying.

See our current [list of amazing contributors](https://github.com/PreviewTechnologies/domain-reseller-api/graphs/contributors)

### License

The MIT License (MIT)

Copyright (c) 2014 Domain Reseller API

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.