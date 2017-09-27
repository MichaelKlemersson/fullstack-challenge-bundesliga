<?php

namespace App\Support\Contracts;

/**
 * Interface ResponseParser
 */
interface ResponseParser
{
    /**
     * Transformat or parse a response
     *
     * @param mixed $response
     * @return array
     */
    public function parse($response);
}
