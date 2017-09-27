<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\SoapApiClient;

class SoapApiClientTest extends TestCase
{
    protected $apiUri = '';

    public function testFetchContentFromJsonApiCclient()
    {
        $apiClient = new SoapApiClient();

        $resultContent = $apiClient->fetch($this->apiUri);

        $this->assertNotNull($resultContent);
    }
}
