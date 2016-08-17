<?php

namespace DomainReseller\Domain;


use DomainReseller\Api\Api;

class Domain extends Api
{
    /**
     * @var null
     */
    protected $apiKey = null;

    /**
     * @var null
     */
    protected $resellerId = null;

    /**
     * @var
     */
    public $apiError;

    /**
     * @param null $apiKey
     * @param null $resellerId
     * @param bool $testMode
     */
    function __construct($apiKey = null, $resellerId = null, $testMode = true)
    {
        $this->api = parent::__construct($apiKey, $resellerId, $testMode);
    }


    /**
     * @param null $domain
     * @return bool|availabilityResult
     * @throws \Exception
     */
    public function checkAvailability($domain = null)
    {
        if (empty($domain)) {
            throw new \Exception('You must provide a domain name');
        }
        $request = $this->__buildRequest('domains/available.json', ['domain-name' => $this->getDomainExtension($domain, true), 'tlds' => $this->getDomainExtension($domain)]);
        if (!is_array($request->send()->json())) {
            $this->apiError = $request->send()->getHeaders();
            return false;
        }
        
        return $request->send()->json();
    }

    public function getSuggestions($keyword = null, $exact_match = true, $tld_only = '')
    {
        if (empty($keyword)) {
            throw new \Exception('You must provide a keyword');
        }

        $request = $this->__buildRequest('domains/v5/suggest-names.json', ['keyword' => $keyword, 'tld-only' => $tld_only, 'exact-match' => $exact_match]);
        if (!is_array($request->send()->json())) {
            $this->apiError = $request->send()->getHeaders();
            return false;
        }

        return $request->send()->json();
    }

    /**
     * @description Check domain is valid or not
     *
     * @param $domain
     * @return bool
     */
    protected function isDomainValid($domain)
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain)
            && preg_match("/^.{1,253}$/", $domain)
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain));
    }

    /**
     * @description  get extension from a fully qualified domain name
     *
     * @param $domain
     * @param bool $returnName
     * @return bool|string
     */
    protected function getDomainExtension($domain, $returnName = false)
    {
        $parts = explode('.', $domain);
        if ($returnName === true) {
            return $parts[0];
        }
        if (sizeof($parts) === 2) {
            return $parts[1];
        } elseif (sizeof($parts) === 3) {
            return $parts[1] . '.' . $parts[2];
        }
        return false;
    }
}
