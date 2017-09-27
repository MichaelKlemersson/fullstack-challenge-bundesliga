<?php

namespace App\Support;

use App\Support\Contracts\ApiClient;

class JsonApiClient implements ApiClient
{
    public function fetch(string $url)
    {
        $curlSession = curl_init();

        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_HEADER, false);
        curl_setopt($curlSession, CURLOPT_HTTPGET, true);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curlSession);
        curl_close($curlSession);

        return json_decode($response, true);
    }
}