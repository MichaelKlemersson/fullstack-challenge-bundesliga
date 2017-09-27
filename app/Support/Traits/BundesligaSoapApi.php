<?php

namespace App\Support\Traits;

use App\Support\SoapApiClient;
use App\Support\Api\Resopnse\ParseSoapResponse;

/**
 * Trait BundesligaSoapApi 
 */
trait BundesligaSoapApi
{
    protected $soapApiUri = 'https://www.OpenLigaDB.de/Webservices/Sportsdata.asmx';

    protected function getSoapClient()
    {
        return new SoapApiClient();
    }

    /**
     * A helper function to parse soap response to array
     *
     * @param mixed $response
     * @return array
     */
    protected function parseSoapResponse($response)
    {
        return array_shift((new ParseSoapResponse())->parse($response));
    }

    /**
     * Return all availables sports
     *
     * @return array
     */
    public function getAvailabeSports()
    {
        return $this->parseSoapResponse(
            $this
                ->getSoapClient()
                ->fetch($this->soapApiUri, [
                    'action' => "GetAvailSports"
                ])
        );
    }
}