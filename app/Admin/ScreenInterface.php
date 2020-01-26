<?php

declare(strict_types=1);

namespace FluentKit\Admin;

interface ScreenInterface
{
    public function getId(): string;

    public function getPriority(): int;

    public function getIcon(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function getFields(): array;

    public function getComponent(): string;

    public function toArray(): array;
}
