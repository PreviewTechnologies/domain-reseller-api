<?php

namespace PreviewTechs\DomainReseller\Exceptions;


use Throwable;

class ProviderExceptions extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $message
     * @return ProviderExceptions
     */
    public static function error($message = "")
    {
        return new static($message);
    }
}