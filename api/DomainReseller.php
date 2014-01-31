<?php
/**
 * @Author  Shaharia Azam <shaharia.azam@gmail.com>
 * @URI http://github.com/shahariaazam/domain-reseller-api
 *
 * @description To handle and manage domain reseller program
 */

namespace DomainReseller;

require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'vendor/autoload.php';

use Guzzle\Http\Client;

class DomainReseller
{
    /**
     * API key to access the domain reseller API
     * @var
     */
    protected $apiKey;

    /**
     * Domain reseller user ID
     * @var
     */
    protected $resellerId;

    /**
     * Testing or Live. If $testMode = true then
     * API will make request to demo API url
     *
     * @var
     */
    protected $testMode;

    /**
     * for $testMode = true this URL will be used by default for all API call
     * @var string
     */
    protected $testUrl = 'https://test.httpapi.com/api/';

    /**
     * for $testMode = false this URL will be used by default for all API call
     * @var string
     */
    protected $liveUrl = 'https://httpapi.com/api/';

    /**
     * @var
     */
    protected $client;

    /**
     * To categorize the URLS for all API call we will use this array $urlSet
     * @var array
     */
    private $urlSet = array(
        'domainCheck' => 'domains/available.json'
    );

    /**
     * @param null $apiKey
     * @param null $resellerId
     * @param bool $testMode
     * @throws \Exception
     */
    public function __construct($apiKey = null, $resellerId = null, $testMode = true)
    {
        if(empty($apiKey) || empty($resellerId)){
            throw new \Exception('You must provide API Key, Reseller ID');
        }
        $this->apiKey = $apiKey;
        $this->resellerId = $resellerId;
        $this->testMode = true;
        $this->client = new Client($this->testUrl);
        if($testMode === false){
            $this->client = new Client($this->liveUrl);
        }
        $this->client->setDefaultOption('query', array(
                'api-key' => $this->apiKey,
                'auth-userid' => $this->resellerId
            )
        );
    }

    /**
     * @param null $urlCommand
     * @param array $query
     * @param array $headers
     * @return \Guzzle\Http\Message\RequestInterface
     */
    function __buildRequest($urlCommand = null, $query = array(), $headers = array())
    {
        return $this->client->get($urlCommand, $headers, array('query' => $query));
    }

    /**
     * @param null $domain
     * @param null $tld
     * @return array|bool|float|int|string
     * @throws \Exception
     */
    public function checkDomain($domain = null, $tld = null)
    {
        if(empty($domain) || empty($tld)){
            throw new \Exception('You must provide a domain name and TLD');
        }
        $request = $this->__buildRequest($this->urlSet['domainCheck'],
            array(
                'domain-name' => $domain,
                'tlds' => $tld
            )
        );
        return $request->send()->json();
    }
}