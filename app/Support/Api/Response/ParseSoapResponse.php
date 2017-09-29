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
        return $this->mapObjectToArray($response);
    }

    /**
     * Map the response, provided as a standard object, by soap request to array
     *
     * @param mixed $data
     * @return array
     */
    protected function mapObjectToArray($data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        if (is_array($data)) {
            foreach ($data as $index => $value) {
                $data[$index] = $this->mapObjectToArray($value);
            }
        }

        return $data;
    }
}
