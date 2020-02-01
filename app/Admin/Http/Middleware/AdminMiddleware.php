<?php

declare(strict_types=1);

namespace FluentKit\Admin\Http\Middleware;

use FluentKit\Admin\Area;
use Illuminate\Http\Request;

final class AdminMiddleware
{
    private ?Area $admin = null;

    public function __construct(Area $admin)
    {
        $this->admin = $admin;
    }

    public function handle(Request $request, \Closure $next)
    {
        $this->admin->serve($request);

        return $next($request);
    }
}
