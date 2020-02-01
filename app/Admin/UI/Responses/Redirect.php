<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Responses;

use FluentKit\Admin\UI\ResponseInterface;

final class Redirect extends Response
{
    public string $type = 'redirect';

    protected array $meta = [
        'redirect' => [],
    ];

    public static function route(string $route, array $params = []): ResponseInterface
    {
        return (new static('redirect'))
            ->setMeta('redirect.route', $route)
            ->setMeta('redirect.params', $params);
    }

    public static function url(string $url): ResponseInterface
    {
        return (new static('redirect'))->setMeta('redirect.url', $url);
    }
}
