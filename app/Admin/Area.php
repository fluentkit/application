<?php

declare(strict_types=1);

namespace FluentKit\Admin;

final class Area
{
    private array $sections = [];

    public function registerSection(SectionInterface $screen): self
    {
        $this->sections[$screen->getId()] = $screen;

        return $this;
    }

    public function getSection(string $id): ?SectionInterface
    {
        return $this->sections[$id] ?? null;
    }

    public function toArray(): array
    {
        return [
            'sections' => collect($this->sections)
                ->map(fn (SectionInterface $screen) => $screen->toArray())
                ->sortBy('priority')
                ->toArray(),
            'assetUrl' => asset('/')
        ];
    }
}
