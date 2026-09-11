<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'សូមចូលប្រព័ន្ធជាមុនសិន! (Please login first)');
        }

        // If user is Admin, allow or redirect to admin dashboard
        $user = Auth::user();
        if ($user->isAdmin()) {
            // Admin can also view customer portal or admin dashboard
            return $next($request);
        }

        if ($user->isCustomer()) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'អ្នកមិនមានសិទ្ធិចូលប្រើប្រាស់ប្រព័ន្ធនេះទេ!');
    }
}
