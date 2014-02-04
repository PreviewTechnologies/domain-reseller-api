Domain reseller API
===================

This will perform all the operation to register domain, check domain, WHOIS lookup and most of the major action from your Domain reseller control panel. it's pretty simple to use.

Installation via Composer
=========================
In your **composer.json** file just put the package name **previewict/domain-reseller-api** in require list like below

```json
"require": {
        "previewict/domain-reseller-api": "dev-master"
    },
```

now run `composer update` command and it will automatically install the [Domain Reseller API](https://github.com/previewict/domain-reseller-api) PHP library for you to use.

Now just add the following code in your PHP script where you will use this library.

```php
<?php

use DomainReseller\Controller\Controller;

$DomainController = new Controller($apiKey, $resellerId, true);

/**
* To check domain availability
*/
$domainController->checkDomain($domain);
```

and you are done!


Getting API Key and Reseller ID
===============================

1. Log in to your domain reseller panel
2. From main navigation **settings -> API**
3. In **Accessing the API** section you will get your API Key (i.e: QAiqhfakiAIRj29AKA3jalAkfjqiwladkfj).
4. Click on the main domain reseller panel's top-right **User** icon and click **Manage profile**.
5. From the **Reseller profile details** table you will get your **Reseller ID** (i.e: 123456)

Domain reseller API in PHP - This API is only usable for NetEarthOne domain resellers.
