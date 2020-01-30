<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Responses;

use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasMeta;

abstract class Response implements ResponseInterface
{
    use HasLabel, HasMeta;

    protected string $type = 'response';

    protected array $meta = [];

    public function __construct(string $label)
    {
        $this->setLabel($label);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'message' => $this->getLabel(),
            'meta' => $this->getMeta()
        ];
    }
}
