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
$DomainController->checkDomain($domain);
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

Report Bugs, Issues, Proposals
==============================
If you get any Bug or face any issue of if you have something to propose for the future development of this library. Please [submit your issue](https://github.com/previewict/domain-reseller-api/issues) here.

License
=============
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


Contributors
=============

[List of our great contributors](https://github.com/previewict/domain-reseller-api/graphs/contributors)
