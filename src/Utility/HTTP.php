<?php

namespace PreviewTechs\DomainReseller\Utility;


use Http\Adapter\Guzzle6\Client;

class HTTP
{
    /**
     * @return Client
     */
    public static function getClient()
    {
        $config = [
            'timeout' => 20
        ];
        $adapter = Client::createWithConfig($config);
        return $adapter;
    }
}