<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

interface ResponseInterface
{
    public function reloads(array $reloads): self;

    public function getReloads(): array;

    public function toArray(): array;
}
