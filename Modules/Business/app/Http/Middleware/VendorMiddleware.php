<?php

namespace Modules\Business\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Check if user has a vendor profile
        if (!$user->vendor) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Vendor access required.'], 403);
            }
            abort(403, 'Vendor access required.');
        }

        // Check if vendor is active
        if ($user->vendor->status !== 'active') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Vendor account is not active.'], 403);
            }
            abort(403, 'Vendor account is not active.');
        }

        return $next($request);
    }
}