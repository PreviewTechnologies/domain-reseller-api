<?php

namespace DomainReseller\Controller;


use DomainReseller\Api\Api;

class Controller extends Api
{

    protected $apiKey = null;
    protected $resellerId = null;
    public $apiError;

    function __construct($apiKey = null, $resellerId = null, $testMode = true)
    {
        $this->api = parent::__construct($apiKey, $resellerId, true);
    }

    /**
     * @param null $domain
     * @param null $tld
     * @return array|bool|float|int|string
     * @throws \Exception
     */
    public function checkDomain($domain = null, $tld = null)
    {
        if (empty($domain) || empty($tld)) {
            throw new \Exception('You must provide a domain name and TLD');
        }
        $request = $this->__buildRequest($this->urlSet['domainCheck'],
            array(
                'domain-name' => $domain,
                'tlds' => $tld
            )
        );
        if (!is_array($request->send()->json())) {
            $this->apiError = $request->send()->getHeaders();
            return false;
        }
        return $request->send()->json();
    }
}