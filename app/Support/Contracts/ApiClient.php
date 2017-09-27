<?php

namespace App\Support\Contracts;

interface ApiClient
{
    public function fetch(string $url);
}