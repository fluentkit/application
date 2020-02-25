<?php

declare(strict_types=1);

namespace FluentKit\Http\Middleware;

use FluentKit\App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class BindApp
{
    public function handle(Request $request, \Closure $next)
    {
        $currentApp = App::with('domains')
            ->whereHas('domains', function (Builder $query) use ($request) {
                return $query->where('domain', $request->getHost());
            })
            ->first();

        $currentApp = tap($currentApp, function ($app) {
           return $app ?? App::master();
        });

        App::setCurrent($currentApp);
        return $next($request);
    }
}
