<?php
declare(strict_types=1);

use App\Models\Tenant;
use App\Utilities\ApiJsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\AbstractPaginator;

if (!function_exists('tenant')) {

    /**
     * @param $guard
     * @return Tenant|null
     */
    function tenant($guard = null): Tenant|null
    {
//        /**
//         * @var Tenant $tenant
//         */
//        $tenant = auth($guard)->user();
//
//        return $tenant;

        // For temp use
        return Tenant::first();
    }
}

if (!function_exists('pagination_meta')) {

    /**
     * @param AbstractPaginator $paginator
     * @return array
     */
    function pagination_meta(AbstractPaginator $paginator): array
    {
        return [
            'cur_page_total' => $paginator->count(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'has_more' => $paginator->hasMorePages(),
            'next_page_url' => $paginator->nextPageUrl(),
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
        ];
    }
}

if (!function_exists('api')) {
    /**
     * @param array|Arrayable|string|null $data
     * @return ApiJsonResponse
     */
    function api(array|Arrayable|string|null $data = []): ApiJsonResponse
    {
        return new ApiJsonResponse($data);
    }
}
