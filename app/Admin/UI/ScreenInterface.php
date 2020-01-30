<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use Illuminate\Http\Request;

interface ScreenInterface
{
    public function setId(string $id);

    public function setPriority(int $priority);

    public function setLabel(string $label);

    public function addField(FieldInterface $field);

    public function getId(): string;

    public function getPriority(): int;

    public function getIcon(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function getComponent(): string;

    public function toArray(): array;

    public function getField(string $id): ?FieldInterface;

    public function getFields(Request $request): array;

    public function getAttributes(Request $request): array;

    public function getActions(Request $request): array;
}
