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
     * @param array $params
     * @return mixed
     */
    public function fetch(string $url, array $params = []);
}
