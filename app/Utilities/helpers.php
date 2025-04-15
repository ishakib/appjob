<?php
declare(strict_types=1);

use App\Models\Tenant;
use App\Utilities\ApiJsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Str;

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

if (!function_exists('str_unique_with_prefix')) {

    function str_unique_with_prefix($prefix = ''): string
    {
        return $prefix . str_unique();
    }
}


if (!function_exists('str_unique')) {
    /**
     * @param int $length
     * @return string
     */
    function str_unique(int $length = 16): string
    {
        $side = rand(0, 1); // 0 = left, 1 = right
        $salt = rand(0, 9);
        $len = $length - 1;
        $string = Str::random($len <= 0 ? 7 : $len);

        $separatorPos = (int)ceil($length / 4);

        $string = $side === 0 ? ($salt . $string) : ($string . $salt);
        $string = substr_replace($string, '-', $separatorPos, 0);

        return substr_replace($string, '-', negative_value($separatorPos), 0);
    }
}

if (!function_exists('negative_value')) {
    /**
     * @param int|float $value
     * @param bool $float
     * @return int|float
     */
    function negative_value(int|float $value, bool $float = false): int|float
    {
        if ($float) {
            $value = (float)$value;
        }

        return 0 - abs($value);
    }
}
