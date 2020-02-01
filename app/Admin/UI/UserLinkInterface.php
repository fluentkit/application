<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use Illuminate\Http\Request;

interface UserLinkInterface
{
    public function getId(): string;

    public function setParams(array $params): self;

    public function setQuery(array $query): self;

    public function toArray(Request $request): array;
}
