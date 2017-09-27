<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\JsonApiClient;

class JsonApiClientTest extends TestCase
{
    protected $apiUri = 'https://www.openligadb.de/api/getmatchdata/bl1';

    public function testFetchContentFromJsonApiCclient()
    {
        $apiClient = new JsonApiClient();

        $resultContent = $apiClient->fetch($this->apiUri);

        $this->assertNotNull($resultContent);
        $this->assertInternalType('array', $resultContent);
    }
}
