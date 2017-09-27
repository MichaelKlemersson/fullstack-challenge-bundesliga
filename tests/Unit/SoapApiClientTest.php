<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\SoapApiClient;
use App\Support\Api\Response\ParseSoapResponse;

class SoapApiClientTest extends TestCase
{
    protected $apiUri = 'https://www.OpenLigaDB.de/Webservices/Sportsdata.asmx';

    public function testFetchContentFromJsonApiClient()
    {
        $apiClient = new SoapApiClient();

        $response = $apiClient->fetch($this->apiUri, [
            'action' => 'GetAvailSports'
        ]);

        $this->assertNotNull($response);
        $this->assertInternalType('object', $response);
    }

    public function testParseToArrayApiSoapResponse()
    {
        $apiClient = new SoapApiClient();
        
        $response = $apiClient->fetch($this->apiUri, [
            'action' => 'GetAvailSports'
        ]);

        $this->assertInternalType('array', (new ParseSoapResponse())->parse($response));
    }
}
