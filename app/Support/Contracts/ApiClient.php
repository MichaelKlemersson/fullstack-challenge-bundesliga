<?php

namespace App\Support\Contracts;

/**
 * Interface ApiClient
 */
interface ApiClient
{
    /**
     * fetch contents from an url
     *
     * @param string $url
     * @return mixed
     */
    public function fetch(string $url);
}
