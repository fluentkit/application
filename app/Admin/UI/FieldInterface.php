<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use Illuminate\Http\Request;

interface FieldInterface
{
    public function __construct(string $id, string $label, string $description = '');

    public function setId(string $id);

    public function setPriority(int $priority);

    public function setLabel(string $label);

    public function required(callable $callback): self;

    public function rules(array $rules): self;

    public function disable($disabled);

    public function getId(): string;

    public function getLabel(): string;

    public function getRules(): array;

    public function getDisabled(Request $request): bool;

    public function toArray(Request $request): array;
}
