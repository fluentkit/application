<?php

declare(strict_types=1);

namespace FluentKit\Admin;

interface SectionInterface
{
    public function getId(): string;

    public function getPriority(): int;

    public function getIcon(): string;

    public function getLabel(): string;

    public function registerScreen(ScreenInterface $screen): self;

    public function getScreen(string $id): ?ScreenInterface;

    public function toArray(): array;
}
