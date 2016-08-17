<?php

namespace DomainReseller\Domain;


use DomainReseller\Api\Api;

class Suggestions extends Api
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

    public $tld_only = [];

    public $exact_match = false;

    public $keyword = null;

    /**
     * @param null $apiKey
     * @param null $resellerId
     * @param bool $testMode
     */
    function __construct($apiKey = null, $resellerId = null, $testMode = true)
    {
        $this->api = parent::__construct($apiKey, $resellerId, $testMode);
    }

    public function get($keyword = null)
    {
        if(isset($keyword)){
            $this->keyword = $keyword;
        }

        if (empty($keyword)) {
            throw new \Exception('You must provide a keyword');
        }

        $request = $this->__buildRequest('domains/v5/suggest-names.json', ['keyword' => $this->keyword, 'tld-only' => $this->tld_only, 'exact-match' => $this->exact_match]);
        if (!is_array($request->send()->json())) {
            $this->apiError = $request->send()->getHeaders();
            return false;
        }

        return $request->send()->json();
    }
}