<?php
// src/Http/Middleware/CustomCheckForMaintenanceMode.php

namespace Robinboost\DebugbarDoping\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
use Closure;

class CustomCheckForMaintenanceMode extends Middleware
{
    protected $except = [
        '_debugbar/check',
        '_debugbar/check/tag',
    ];

    public function handle($request, Closure $next)
    {
        foreach ($this->except as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        return parent::handle($request, $next);
    }
}
