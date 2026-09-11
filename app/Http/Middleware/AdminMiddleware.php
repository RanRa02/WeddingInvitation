<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'សូមចូលប្រព័ន្ធជាមុនសិន (Please login first)');
        }

        $user = Auth::user();
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'គណនីរបស់អ្នកត្រូវបានផ្អាក (Your account is inactive)');
        }

        return $next($request);
    }
}
