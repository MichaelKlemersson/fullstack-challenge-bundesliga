<?php

namespace App\Support;

use App\Support\Contracts\ApiClient;
use SoapClient;

/**
 * Class SoapApiClient
 */
class SoapApiClient implements ApiClient
{
    public function fetch(string $url, array $params = [])
    {
        return $this
            ->getSoapClient($url)
            ->__soapCall(
                $params['action'],
                isset($params['params']) ? $params['params'] : []
            );
    }

    /**
     * Return a new SoapClient
     *
     * @param string $url
     * @return SoapClient
     */
    protected function getSoapClient(string $url)
    {
        $opts = array(
            'http' => array(
                'user_agent' => 'PHPSoapClient'
            )
        );
        
        $settings = array(
            'encoding' => 'UTF-8',
            'verifypeer' => false,
            'verifyhost' => false,
            'soap_version' => SOAP_1_2,
            'allow_self_signed' => true,
            'trace' => 1,
            'exceptions' => 1,
            "connection_timeout" => 180,
            'stream_context' => stream_context_create($opts),
            'cache_wsdl' => WSDL_CACHE_NONE
        );

        return new SoapClient("$url?WSDL", $settings);
    }
}
