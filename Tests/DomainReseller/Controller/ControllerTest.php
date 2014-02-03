<?php

require dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use DomainReseller\Controller\Controller;

class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Update it with your api key
     *
     * @var string
     */
    private $apiKey = 'your-api-key';

    /**
     * Update it with your reseller id
     *
     * @var int
     */
    private $resellerId = 000000;

    public function setUp()
    {
        //$this->Api = new Api($this->apiKey, $this->resellerId, true);
        $this->Controller = new Controller($this->apiKey, $this->resellerId, true);
    }

    /**
     * Check with an already registered domain
     */
    function testCheckDomainWithRegisteredDomain()
    {
        $domain = 'shahariaazam';
        $tld = 'com';
        $this->assertArrayHasKey($domain . '.' . $tld, $this->Controller->checkDomain($domain, $tld));
    }

}