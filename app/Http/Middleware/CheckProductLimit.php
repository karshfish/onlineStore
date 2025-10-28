<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProductLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Safety check
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Count how many products the user already has
        $productCount = $user->products()->count();

        // Set the maximum limit
        $maxProducts = 5;

        if ($productCount >= $maxProducts) {
            return redirect()
                ->route('products.index')
                ->with('error', 'You have reached the maximum product limit of ' . $maxProducts . '.');
        }

        // If user hasn't reached limit, continue
        return $next($request);
    }
}
