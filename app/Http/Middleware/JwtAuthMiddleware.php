<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthorizationFailsException;
use App\Exceptions\AuthorizationTokenNotFoundException;
use App\Models\Site;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use JsonException;

class JwtAuthMiddleware
{

    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (empty($guard)) {
            $guard = 'tenant';
        }

        // Assuming you're manually setting the tenant for now.
        // Make sure the tenant exists in the database
        $tenant = Tenant::where('uid', '1e8f0e7a-77dc-4151-be08-9e98350c780b')->first();

        if (!$tenant) {
            // Handle the case where tenant is not found
            abort(403, 'Tenant not found');
        }

        // Set the tenant for the 'tenant' guard
        auth($guard)->setUser($tenant);

        return $next($request);
    }

}
