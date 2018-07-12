<?php

namespace PreviewTechs\DomainReseller;


class Domains
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * Domains constructor.
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param $domainName
     * @param $extensions
     * @return bool
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function isAvailable($domainName, $extensions)
    {
        return $this->provider->isDomainAvailable($domainName, $extensions);
    }

    /**
     * @param $keyword
     * @param null $tld
     * @param bool $exactMatch
     * @return array
     * @throws Exceptions\ProviderExceptions
     * @throws \Http\Client\Exception
     */
    public function getSuggestions($keyword, $tld = null, $exactMatch = false)
    {
        return $this->provider->getSuggestions($keyword, $tld, $exactMatch);
    }
}