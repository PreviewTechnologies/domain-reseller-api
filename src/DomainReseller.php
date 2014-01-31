<?php
/**
 * @Author  Shaharia Azam <shaharia.azam@gmail.com>
 * @URI http://github.com/shahariaazam/domain-reseller-api
 *
 * @description To handle and manage domain reseller program
 */

namespace DomainReseller;

use Guzzle\Common\Event;
use Guzzle\Http\Client;

require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'vendor/autoload.php';

class DomainReseller
{
    protected $apiKey;
    protected $apiMode;
    protected $resellerId;

    protected $testUrl = 'https://test.httpapi.com/api/';
    protected $liveUrl = 'https://httpapi.com/api/';

    protected $client;

    private $urlSet = array(
        'domainCheck' => 'domains/available.json'
    );

    public function __construct($apiKey = null, $resellerId = null, $test = true)
    {
        if(empty($apiKey) || empty($resellerId)){
            throw new \Exception('You must provide API Key, Reseller ID');
        }
        $this->apiKey = $apiKey;
        $this->resellerId = $resellerId;
        $this->apiMode = true;
        $this->client = new Client($this->testUrl);
        $this->client->setDefaultOption('query', array(
                'api-key' => $this->apiKey,
                'auth-userid' => $this->resellerId
            )
        );
    }

    public function domainCheck($domain = null)
    {
        $request = $this->client->get($this->urlSet['domainCheck'], array(), array(
            'query' => array(
                'domain-name' => 'shahariaazam',
                'tlds' => 'com'
            )
        ));
        return $request->send()->json();
    }
}