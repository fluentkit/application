<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use Illuminate\Http\Request;

interface SectionInterface
{
    public function setId(string $id);

    public function setPriority(int $priority);

    public function setLabel(string $label);

    public function getId(): string;

    public function getPriority(): int;

    public function getIcon(): string;

    public function getLabel(): string;

    public function registerScreen(ScreenInterface $screen): self;

    public function getScreen(string $id): ?ScreenInterface;

    public function toArray(Request $request): array;
}
