<?php

namespace App\Support\Traits;

use App\Support\JsonApiClient;

trait BundesligaJsonApi
{
    protected function getClient()
    {
        return new JsonApiClient();
    }

    
}