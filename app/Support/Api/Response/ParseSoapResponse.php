<?php

namespace App\Support\Api\Response;

use App\Support\Contracts\ResponseParser;

/**
 * ParseSoapResponse class
 */
class ParseSoapResponse implements ResponseParser
{
    public function parse($response)
    {
        return (array) $response;
    }
}