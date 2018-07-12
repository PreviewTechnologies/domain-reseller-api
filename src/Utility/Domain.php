<?php

namespace PreviewTechs\DomainReseller\Utility;


class Domain
{
    public static function parse($domainName)
    {
        $data = [];

        $parts = explode('.', $domainName);
        $data['name'] = $parts[0];

        $ext = null;
        for($i=1; $i < sizeof($parts); $i++){
            $ext .= "." . $parts[$i];
        }

        $data['ext'] = $ext;

        return $data;
    }
}