<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\JsonApiClient;
use App\Support\Api\Response\ParseJsonResponse;

class JsonApiClientTest extends TestCase
{
    protected $apiUri = 'https://www.openligadb.de/api/getmatchdata/bl1';

    public function testFetchContentFromJsonApiClient()
    {
        $apiClient = new JsonApiClient();
        $response = $apiClient->fetch($this->apiUri);

        $this->assertNotNull($response);
        $this->assertInternalType('string', $response);
    }

    public function testParseToArrayApiJsonResponse()
    {
        $apiClient = new JsonApiClient();
        $response = $apiClient->fetch($this->apiUri);

        $this->assertInternalType('array', (new ParseJsonResponse())->parse($response));
    }
}
