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

    /**
     * Initialize the API request controller object
     */
    public function setUp()
    {
        $this->Controller = new Controller($this->apiKey, $this->resellerId, true);
    }

    /**
     * Check with an already registered domain
     */
    function testCheckDomainWithRegisteredDomain()
    {
        $domain = 'shahariaazam.com';
        $this->assertArrayHasKey($domain, $this->Controller->checkDomain($domain));
    }

    /**
     * Domain name validity test (1)
     */
    function testWhetherDomainIsValidOrNot()
    {
        $domain = 'localhost';
        $this->assertTrue($this->Controller->isDomainValid($domain));
    }

    /**
     * Domain name validity test (2)
     */
    function testAnotherDomainWhetherItIsValidOrNot()
    {
        $domain = 'shahariaazam.com';
        $this->assertTrue($this->Controller->isDomainValid($domain));
    }

    /**
     * Domain name validity test (3)
     */
    function testWhetherDomainIsValidOrNotWithAnInvalidDomain()
    {
        $domain = 'try shahariaazam.com';
        $this->assertFalse($this->Controller->isDomainValid($domain));
    }

    /**
     * get domain extension for single level domain (.com, .info, .org)
     */
    function testDomainExtensionForSingleLevelDomain()
    {
        $domain = 'shahariaazam.com';
        $this->assertEquals('com',$this->Controller->getDomainExtension($domain));
    }

    /**
     * get domain extension for two level domain (.co.uk)
     */
    function testDomainExtensionForTwoLevelDomain()
    {
        $domain = 'shahariaazam.co.uk';
        $this->assertEquals('co.uk',$this->Controller->getDomainExtension($domain));
    }

}