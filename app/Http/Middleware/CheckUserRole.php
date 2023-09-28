<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role->name, $roles)) {
            return response()->json(['error' => 'You do not have sufficient permissions'], 403);
        }

        return $next($request);
    }
}
