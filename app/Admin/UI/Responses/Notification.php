<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Responses;

use FluentKit\Admin\UI\ResponseInterface;

final class Notification extends Response
{
    public string $type = 'notification';

    protected array $meta = [
        'toast' => [
            'type' => 'toast'
        ],
    ];

    public static function success(string $label): ResponseInterface
    {
        return (new static($label))->setMeta('toast.type', 'success');
    }

    public static function info(string $label): ResponseInterface
    {
        return (new static($label))->setMeta('toast.type', 'info');
    }

    public static function error(string $label): ResponseInterface
    {
        return (new static($label))->setMeta('toast.type', 'error');
    }
}
