<?php
/**
 * @Author  Shaharia Azam <shaharia.azam@gmail.com>
 * @URI http://github.com/shahariaazam/domain-reseller-api
 *
 * @description Domain Reseller API Test Case
 */

require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'api/DomainReseller.php';

use DomainReseller\DomainReseller;

class DomainResellerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $apiKey = 'write-your-api-key';

    /**
     * @var int
     */
    private $resellerId = 'put-your-reseller-id-number';

    /**
     * Initialize the test enviornment and create an instance of DomainReseller class
     */
    function setUp()
    {
        $this->api = new DomainReseller($this->apiKey, $this->resellerId);
    }

    /**
     * Check with an already registered domain
     */
    function testCheckDomainWithRegisteredDomain()
    {
        $domain = 'shahariaazam';
        $tld = 'com';
        $this->assertArrayHasKey($domain.'.'.$tld,$this->api->checkDomain($domain, $tld));
    }
}
 