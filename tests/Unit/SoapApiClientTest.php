<?php

namespace Tests\Unit;

use Tests\TestCase;

class SoapApiClientTest extends TestCase
{
    protected $apiUri = 'https://www.openligadb.de/api/getmatchdata/bl1';

    public function testFetchContentFromJsonApiCclient()
    {
        $apiClient = new SoapApiClient();

        $resultContent = $apiClient->fetch($this->apiUri);

        $this->assertNotNull($resultContent);
    }
}
