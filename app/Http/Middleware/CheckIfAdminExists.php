<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfAdminExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if any admin exists in the database
        if (Admin::count() === 0) {
            // No admin exists, redirect to first-time setup
            return redirect()->route('admin.setup');
        }

        // Admin exists, proceed with the request
        return $next($request);
    }
}