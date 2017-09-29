<?php

namespace App\Support\Api\Response;

use App\Support\Contracts\ResponseParser;

/**
 * ParseJsonResponse class
 */
class ParseJsonResponse implements ResponseParser
{
    public function parse($response)
    {
        return json_decode($response, true);
    }
}
