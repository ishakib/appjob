<?php
declare(strict_types=1);

use App\Enums\MixpanelEvent;
use App\Enums\PlanFeature;
use App\Exceptions\FeatureNotAllowedException;
use App\Models\Site;
use App\Services\FeatureFlag\Feature;
use App\Services\Mixpanel\MixpanelTrack;
use App\Utilities\ApiJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

if (!function_exists('site')) {

    /**
     * @param $guard
     * @return Site|null
     */
    function site($guard = null): ?Site
    {
        /**
         * @var Site $site
         */
        $site = auth($guard)->user();

        return $site;
    }
}

if (!function_exists('admin_api')) {
    function admin_api(): string
    {
        return '/admin/api/' . env('SHOPIFY_API_VERSION');
    }
}

if (!function_exists('json_parse')) {
    /**
     * @param string $data
     * @param bool $exception
     * @return array
     * @throws Exception
     */
    function json_parse(string $data, bool $exception = true): array
    {

        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        if (json_last_error() !== JSON_ERROR_NONE) {
            if ($exception) {
                throw new \Exception('Invalid JSON, Failed to parse!');
            }
            $data = [];
        }
        return $data;
    }
}

if (!function_exists('load_graphql_array_schema')) {
    /**
     * @param string $path
     * @param array $data
     * @return array
     * @throws Exception
     */
    function load_graphql_array_schema(string $path, array $data = []): array
    {
        extract($data, EXTR_SKIP);
        $path = 'graph/' . str_replace('.', '/', $path) . '.array.php';
        $path = resource_path('views/' . $path);

        if (!file_exists($path)) {
            throw new \Exception("File not found for tcp response");
        }

        return require $path;
    }
}

if (!function_exists('load_graphql_blade_schema')) {
    /**
     * @param string $path
     * @param array $data
     * @return string
     * @throws Exception
     */
    function load_graphql_blade_schema(string $path, array $data = []): string
    {
        $location = resource_path('views/graph/' . str_replace('.', '/', $path) . '.blade.php');

        if (!file_exists($location)) {
            throw new \Exception("File not found for tcp response");
        }

        return view('graph.' . $path, $data)->render();
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

if (!function_exists('get_media_prefix_directory_name')) {
    /**
     * @return string
     */
    function get_media_prefix_directory_name(): string
    {
        return Carbon::today()->format('d_m_Y') . '_media';
    }
}

if (!function_exists('carbon')) {
    /**
     * @param string|null $date
     * @param string $timezone
     * @return Carbon
     */
    function carbon(string $date = null, string $timezone = 'UTC'): Carbon
    {
        if (!$date) {
            return Carbon::now($timezone);
        }

        return (new Carbon($date, $timezone));
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

if (!function_exists('cursor_pagination_meta')) {

    /**
     * @param CursorPaginator $paginator
     * @return array
     */
    function cursor_pagination_meta(CursorPaginator $paginator): array
    {
        return [
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'next_cursor' => $paginator->nextCursor()?->encode(),
            'next_page_url' => $paginator->nextPageUrl(),
            'prev_cursor' => $paginator->previousCursor()?->encode(),
            'prev_page_url' => $paginator->previousPageUrl(),
        ];
    }
}

if (!function_exists('upper_case_snake_case_to_sentence')) {

    /**
     * @param string $sentence
     * @return string
     */
    function upper_case_snake_case_to_sentence(string $sentence): string
    {
        return Str::ucfirst(Str::lower(Str::replace('_', ' ', $sentence)));
    }
}

if (!function_exists('discount')) {

    /**
     * @return string
     */
    function discount(): string
    {
        return 'RVXP-' . Str::upper(Str::random(6));
    }
}

if (!function_exists('url_concat')) {
    function url_concat(...$uris): string
    {
        /**
         * @var \App\Utilities\UrlManager $urlManager
         */
        $urlManager = app(\App\Utilities\UrlManager::class);

        foreach ($uris as $uri) {
            if (blank($uri)) {
                continue;
            }

            $urlManager->concat($uri);
        }

        $uri = $urlManager->getUrl();
        $urlManager->setBaseUrl('');

        return $uri;

    }
}

if (!function_exists('backend_url')) {
    /**
     * @param $uri
     * @return string
     */
    function backend_url($uri): string
    {
        return url_concat(env('APP_URL', 'http://localhost:8008'), env('ROUTE_BACKEND_PREFIX', '/-'), $uri);
    }
}

if (!function_exists('app_url')) {
    function app_url($uri): string
    {
        return url_concat(env('APP_URL', 'http://localhost:8008'), $uri);
    }
}

if (!function_exists('from_gid')) {
    /**
     * @param $gid
     * @props int $id
     * @props string $type
     * @return ?object
     */
    function from_gid($gid): ?object
    {
        if (!str_contains($gid, 'gid://')) {
            return null;
        }

        $data = [];

        $extractedData = explode('/', substr($gid, strpos($gid, 'gid') + 6));

        $data['node'] = $extractedData[1];
        $data['id'] = (int)$extractedData[2];

        return (object)$data;

    }
}

if (!function_exists('load_data')) {
    /**
     * @param string $path
     * @param array $data
     * @return array
     * @throws Exception
     */
    function load_data(string $path, array $data = []): array
    {
        extract($data, EXTR_SKIP);
        $path = 'data/' . str_replace('.', '/', $path) . '.data.php';
        $file = resource_path($path);

        if (!file_exists($file)) {
            throw new \Exception("Data file not found");
        }

        return require $file;
    }
}

if (!function_exists('slug')) {
    /**
     * @param string|null $string
     * @return string
     */
    function slug(string $string = null): string
    {
        return Str::slug($string);
    }
}

if (!function_exists('rating_show')) {
    /**
     * @param string $ratingValue
     * @return string
     */
    function rating_show(string $ratingValue = '1'): string
    {
        return match ($ratingValue) {
            '5' => "★★★★★",
            '4' => "★★★★☆",
            '3' => "★★★☆☆",
            '2' => "★★☆☆☆",
            default => "★☆☆☆☆",
        };
    }
}

if (!function_exists('text_replacer')) {

    /**
     * @param string $text
     * @param array $data
     * @return string
     */
    function text_replacer(string $text, array $data): string
    {
        if (array_is_list($data)) {
            return $text;
        }

        $replacer = [];

        foreach ($data as $key => $value) {
            $replacer['[' . strtolower($key) . ']'] = $value;
        }

        return strtr($text, $replacer);
    }
}

if (!function_exists('signed_url')) {

    /**
     * @param string $url
     * @return string
     */
    function signed_url(string $url): string
    {
        $salt = config('app.key');

        $hashString = $salt . '::' . $url;
        $urlData = parse_url($url);
        parse_str($urlData['query'] ?? '', $query);

        $hash = sha1($hashString);
        $query['hash'] = $hash;

        $query = http_build_query($query);

        return urldecode($urlData['scheme'] . '://' . $urlData['host'] . (isset($urlData['port']) ? ':' . $urlData['port'] : '') . $urlData['path'] . '?' . $query);

    }
}

if (!function_exists('validate_signed_url')) {

    /**
     * @param string $url
     * @return bool
     */
    function validate_signed_url(string $url): bool
    {
        $salt = config('app.key');

        $parsedUrl = parse_url($url);

        if (!isset($parsedUrl['query'])) {
            return false;
        }

        parse_str($parsedUrl['query'], $query);

        if (!isset($query['hash'])) {
            return false;
        }

        $hash = $query['hash'];

        unset($query['hash']);
        $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . (isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '') . $parsedUrl['path'] . (!empty($query) ? '?' . http_build_query($query) : '');

        $hashString = $salt . '::' . $url;

        return sha1($hashString) === $hash;

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

if (!function_exists('feature_allows')) {
    /**
     * @param PlanFeature $feature
     * @param Site|null $site
     * @return void
     * @throws FeatureNotAllowedException
     */
    function feature_allows(PlanFeature $feature, ?Site $site = null): void
    {
        /**
         * @var Feature $featureFlag
         */
        $featureFlag = app(Feature::class);

        $featureFlag->allows($feature, $site);
    }
}

if (!function_exists('feature_enabled')) {
    /**
     * @param PlanFeature $feature
     * @param ?Site $site
     * @return bool
     */
    function feature_enabled(PlanFeature $feature, ?Site $site = null): bool
    {
        /**
         * @var Feature $featureFlag
         */
        $featureFlag = app(Feature::class);

        return $featureFlag->hasEnabled($feature, $site);
    }
}

if (!function_exists('feature_get')) {
    /**
     * @param PlanFeature $feature
     * @param Site|null $site
     * @return mixed
     */
    function feature_get(PlanFeature $feature, ?Site $site = null): mixed
    {
        /**
         * @var Feature $featureFlag
         */
        $featureFlag = app(Feature::class);

        return $featureFlag->getFlagValue($feature, $site);
    }
}

if (!function_exists('url_replacer')) {

    /**
     * @param string $url
     * @param array $attr
     * @return string
     */
    function url_replacer(string $url, array $attr): string
    {
        if (array_is_list($attr)) {
            return $url;
        }

        $replacer = [];

        foreach ($attr as $key => $value) {
            $replacer['{' . strtolower($key) . '}'] = $value;
        }

        return strtr($url, $replacer);
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

if (!function_exists('download_from_url')) {

//    function download_from_url(string $url, string $prefix = ''): ?string
//    {
//        if (! $stream = @fopen($url, 'r')) {
//            throw new \Exception('Can not open file from ' . $url);
//        }
//
//        $tempFile = tempnam(sys_get_temp_dir(), $prefix);
//
//        if (file_put_contents($tempFile, $stream)) {
//            return $tempFile;
//        }
//
//        return null;
//    }


    /**
     * @param string $url
     * @param string $prefix
     * @return string|null
     * @throws Exception
     */
    function download_from_url(string $url, string $prefix = ''): ?string
    {
        $tempFile = tempnam(sys_get_temp_dir(), $prefix);

        if (!copy($url, $tempFile)) {
            throw new \Exception('Unable to download file from ' . $url);
        }

        return $tempFile;
    }

}

if (!function_exists('sanitizeAndCapitalizeName')) {
    /**
     * @param string $text
     * @return string
     */
    function sanitizeAndCapitalizeName(string $text): string
    {
        return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
    }
}

if (!function_exists('mixpanel_event_enqueue')) {
    /**
     * @param Site $site
     * @param MixpanelEvent $event
     * @param array $properties
     * @return void
     */
    function mixpanel_event_enqueue(Site $site, MixpanelEvent $event, array $properties = []): void
    {
        /**
         * @var MixpanelTrack $mixpanel
         */
        $mixpanel = app(MixpanelTrack::class);

        $mixpanel->eventEnqueue($site, $event, $properties);
    }
}

if (!function_exists('str_inject_before')) {

    /**
     * @param string $contents
     * @param string $text
     * @param string $find
     * @param bool $newline
     * @return string
     */
    function str_inject_before(string $contents, string $text, string $find, bool $newline = true): string
    {
        $bodyPos = strpos($contents, $find);

        if ($bodyPos === false) {
            return $contents;
        }

        if ($newline) {
            $text = $text . PHP_EOL;
        }

        return substr_replace($contents, $text, $bodyPos, 0);
    }
}

if (!function_exists('str_inject_after')) {

    /**
     * @param string $contents
     * @param string $text
     * @param string $find
     * @param bool $newline
     * @return string
     */
    function str_inject_after(string $contents, string $text, string $find, bool $newline = true): string
    {
        $bodyPos = strpos($contents, $find);

        if ($bodyPos === false) {
            return $contents;
        }

        $bodyPos += strlen($find);

        if ($newline) {
            $text = PHP_EOL . $text;
        }

        return substr_replace($contents, $text, $bodyPos, 0);
    }
}

if (!function_exists('str_append')) {

    /**
     * @param string $contents
     * @param string $text
     * @param bool $newline
     * @return string
     */
    function str_append(string $contents, string $text, bool $newline = true): string
    {
        if ($newline) {
            $text = "\n" . $text;
        }

        return $contents . $text;
    }
}

if (!function_exists('str_prepend')) {

    /**
     * @param string $contents
     * @param string $text
     * @param bool $newline
     * @return string
     */
    function str_prepend(string $contents, string $text, bool $newline = true): string
    {
        if ($newline) {
            $text = $text . "\n";
        }

        return $text . $contents;
    }
}

if (!function_exists('get_client_token')) {
    /**
     * @param Request $request
     * @return string
     */
    function get_client_token(Request $request): string
    {
        $data = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        return sha1(json_encode($data));
    }
}

if (!function_exists('do_until')) {
    /**
     * @param callable $do
     * @param callable $until
     * @param int $sleep
     * @return void
     */
    function do_until(callable $do, callable $until, int $sleep = 1000): void
    {
        while (!$until()) {
            $do();
            usleep($sleep);
        }
    }
}

if (!function_exists('pipe_do_until')) {
    /**
     * @param callable $do
     * @param callable $until
     * @param int $sleep
     * @return mixed
     */
    function pipe_do_until(callable $do, callable $until, int $sleep = 1000): mixed
    {
        $res = null;

        while (true) {
            $res = $do($res);
            if ($until($res)) {
                break;
            }

            usleep($sleep);
        }

        return $res;
    }
}

if (!function_exists('make_dto')) {
    /**
     * @pure
     *
     * @template T of object
     *
     * @param string|class-string<T> $signature
     * @return T
     * @phpstan-return (
     *     $signature is class-string<T>
     *         ? T
     *         : ($signature is class-string ? object : mixed)
     * )
     *
     */
    function make_dto(string $signature, array $data, ?callable $opt = null): mixed
    {
        try {
            return (new \CuyZ\Valinor\MapperBuilder())
                ->supportDateFormats('Y-m-d H:i:s', 'Y-m-d', 'd M Y')
                ->mapper()
                ->map(
                    $signature,
                    $data
                );
        } catch (\CuyZ\Valinor\Mapper\MappingError $error) {
            return null;
        }
    }
}

if (!function_exists('str_unique_with_prefix')) {

    function str_unique_with_prefix($prefix = ''): string
    {
        return $prefix . str_unique();
    }
}

if (!function_exists('get_random_date_with_in_year')) {

    function get_random_date_with_in_year(int $startYear, int $totalNumberOfDates, int $years): array
    {
        $datesPerYear = (int)ceil($totalNumberOfDates / $years);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $dates = [];

        // Generate dates from startYear up to the current year
        for ($year = $startYear; $year <= $currentYear; $year++) {
            for ($i = 0; $i < $datesPerYear && count($dates) < $totalNumberOfDates; $i++) {
                $date = Carbon::create($year, 1, 1)->addDays($i);
                $dates[] = $date->toDateTimeString();
            }
        }

        // Ensure at least one date from the current month of the current year
        $currentMonthDate = Carbon::create($currentYear, $currentMonth, 1)->toDateTimeString();
        if (!in_array($currentMonthDate, $dates)) {
            $dates[count($dates) - 1] = $currentMonthDate;
        }

        // Slice to ensure exact number of dates
        return array_slice($dates, 0, $totalNumberOfDates);
    }
}

if (!function_exists('calculate_average_ratings')) {

    function calculate_average_ratings($ratings): float|int
    {
        $total = array_sum($ratings);
        return $total / count($ratings);
    }
}

if (!function_exists('distribute_rating')) {

    function distribute_rating(float $rating, array $criteria = []): array
    {
        if (count($criteria) === 0) {
            return [];
        }

        $distributedRatings = [];
        foreach ($criteria as $criterion) {
            $distributedRatings[$criterion] = (float)$rating;
        }

        return $distributedRatings;
    }
}

if (!function_exists('average_rating')) {

    function average_rating(array $criteria = [], array $keys = []): float
    {
        if (empty($criteria) || empty($keys)) {
            return 0.0;
        }

        $filteredCriteria = array_intersect_key($criteria, array_flip($keys));
        $total = array_sum($filteredCriteria);
        $count = count($filteredCriteria);

        if ($count === 0) {
            return 0.0;
        }

        return round($total / $count, 2);
    }
}


// app/helpers.php

if (!function_exists('log_current_date_time')) {
    function log_current_date_time($message): void
    {
        date_default_timezone_set('UTC');
        $now = microtime(true);
        $dateTime = \DateTime::createFromFormat('U.u', sprintf('%.6F', $now));
        $formattedDateTime = $dateTime->format('Y-m-d H:i:s.u');
    }
}

if (!function_exists('str_limit')) {
    function str_limit(string $text = null, int $limit = 255): ?string
    {
        return Str::limit($text, $limit, '');
    }
}

if (!function_exists('debug_log')) {
    function debug_log(string $message, array $context = []): void
    {
        if (app()->environment('production')) {
            return;
        }

        logger()->debug($message, $context);
    }
}

if (!function_exists('format_date_with_time_from_string')) {
    function format_date_with_time_from_string(Carbon|string|array|null $value): Carbon|null
    {
        if ($value === null || is_array($value)) {
            return null;
        }

        if (!$value instanceof Carbon) {
            $value = \Illuminate\Support\Carbon::parse($value);
        }

        return $value;
    }
}

if (!function_exists('generate_random_string')) {

    function generate_random_string($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        // Generate the random string
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

}

if (!function_exists('_getSubscriptionName')) {
    /**
     * @param $id
     * @return string
     */
    function _getSubscriptionName($id): string
    {
        $subscription = config('subscription');

        return $subscription[$id]['name'];
    }
}


if (!function_exists('make_full_url')) {
    function make_full_url($baseUrl): string
    {
        return "https://" . rtrim($baseUrl, '/');
    }
}

if (!function_exists('client_url')) {
    function client_url($path = '', $params = []): string
    {
        $clientUrl = env('CLIENT_URL', url('/'));

        $url = rtrim($clientUrl, '/') . '/' . ltrim($path, '/');

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}
if (!function_exists('s3_cdn')) {
    function s3_cdn($link): string
    {
        return env('S3_CDN') . $link;
    }
}

if (!function_exists('sanitize_phone')) {
    /**
     * Sanitize a phone number by trimming, removing internal spaces,
     * and limiting the length to a specified number of characters.
     *
     * @param string|null $phone
     * @param int $maxLength
     * @return string|null
     */
    function sanitize_phone(?string $phone, int $maxLength = 20): ?string
    {
        if (!$phone) {
            return null;
        }

        return substr(preg_replace('/\s+/', '', trim($phone)), 0, $maxLength);
    }
}

if (!function_exists('sanitize_address')) {
    /**
     * Sanitize an address by trimming, removing internal spaces,
     * and limiting the length to a specified number of characters.
     *
     * @param string|null $address
     * @param int $maxLength
     * @return string|null
     */
    function sanitize_address(?string $address, int $maxLength = 250): ?string
    {
        if (!$address) {
            return null;
        }

        return substr(preg_replace('/\s+/', ' ', trim($address)), 0, $maxLength);
    }
}
