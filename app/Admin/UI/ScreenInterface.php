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

    public function addAction(ActionInterface $action);

    public function hide($hidden = true);

    public function getId(): string;

    public function getPriority(): int;

    public function getIcon(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function getComponent(): string;

    public function toArray(Request $request): array;

    public function getHidden(Request $request): bool;

    public function getField(string $id): ?FieldInterface;

    public function getFields(Request $request): array;

    public function getAttributes(Request $request): array;

    public function getAction(string $id): ?ActionInterface;

    public function getActions(Request $request): array;
}
