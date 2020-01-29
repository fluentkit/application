<?php

declare(strict_types=1);

namespace FluentKit\Admin;

interface UserLinkInterface
{
    public function getId(): string;

    public function setParams(array $params): self;

    public function setQuery(array $query): self;

    public function toArray(): array;
}
