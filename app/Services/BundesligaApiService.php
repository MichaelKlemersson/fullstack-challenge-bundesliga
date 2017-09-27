<?php

namespace App\Services;

use App\Support\Traits\BundesligaJsonApi;
use App\Support\Traits\BundesligaSoapApi;

/**
 * Class BundesligaApiService
 */
class BundesligaApiService
{
    use BundesligaJsonApi, BundesligaSoapApi;
}