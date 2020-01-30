<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use Illuminate\Http\Request;

interface ActionInterface
{
    public function __construct(string $id, string $label);

    public function setId(string $id);

    public function setLabel(string $label);

    public function setPriority(int $priority);

    public function setMeta(string $key, $value): self;

    public function getId(): string;

    public function getLabel(): string;

    public function getPriority(): int;

    public function getMeta(string $key = null): array;

    public function toArray(Request $request): array;

    public function handle(Request $request, ScreenInterface $screen): array;
}
