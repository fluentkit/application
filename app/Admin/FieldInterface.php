<?php

declare(strict_types=1);

namespace FluentKit\Admin;

use Illuminate\Http\Request;

interface FieldInterface
{
    public function __construct(string $id, string $label, string $description = '');

    public function required(callable $callback): self;

    public function getId(): string;

    public function toArray(Request $request): array;
}
