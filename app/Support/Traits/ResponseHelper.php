<?php

namespace App\Support\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ResponseHelper
 */
trait ResponseHelper
{
    /**
     * Return a json paginated or not based on passed content
     *
     * @param mixed $content
     * @param boolean $paginated
     * @param int $statusCode
     * @return string
     */
    public function makeApiResponse($content, $paginated = false, $statusCode = Response::HTTP_OK)
    {
        if ($paginated && is_array($content)) {
            return $constent = (new LengthAwarePaginator($content, count($content), 15, request('page', 1)))->toArray();
        }

        return response()->json($content, $statusCode);
    }
}
