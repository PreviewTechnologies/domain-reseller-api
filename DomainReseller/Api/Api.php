<?php

namespace DomainReseller\Api;

use Guzzle\Http\Client;

class Api
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
    protected $urlSet = array(
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
        if (empty($apiKey) || empty($resellerId)) {
            throw new \Exception('You must provide API Key, Reseller ID');
        }
        $this->apiKey = $apiKey;
        $this->resellerId = $resellerId;
        $this->testMode = true;
        $this->client = new Client($this->testUrl);
        if ($testMode === false) {
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

}