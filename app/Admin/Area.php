<?php

declare(strict_types=1);

namespace FluentKit\Admin;

use FluentKit\Admin\UI\SectionInterface;
use FluentKit\Admin\UI\UserLinkInterface;

final class Area
{
    private array $servingCallbacks = [];

    private array $sections = [];

    private array $userLinks = [];

    public function serving(callable $callback): self
    {
        $this->servingCallbacks[] = $callback;

        return $this;
    }

    public function serve(): void
    {
        foreach ($this->servingCallbacks as $callback) {
            $callback($this);
        }
    }

    public function registerSection(SectionInterface $screen): self
    {
        $this->sections[$screen->getId()] = $screen;

        return $this;
    }

    public function getSection(string $id): ?SectionInterface
    {
        return $this->sections[$id] ?? null;
    }

    public function registerUserLink(UserLinkInterface $link): self
    {
        $this->userLinks[$link->getId()] = $link;

        return $this;
    }

    public function getUserLink(string $id): ?UserLinkInterface
    {
        return $this->userLinks[$id] ?? null;
    }

    public function toArray(): array
    {
        return [
            'sections' => $this->getSections(),
            'assetUrl' => asset('/'),
            'user' => request()->user(),
            'userLinks' => $this->getUserLinks()
        ];
    }

    private function getSections(): array
    {
        return collect($this->sections)
            ->map(fn(SectionInterface $screen) => $screen->toArray())
            ->sortBy('priority')
            ->toArray();
    }

    private function getUserLinks(): array
    {
        return collect($this->userLinks)
            ->map(fn(UserLinkInterface $link) => $link->toArray())
            ->sortBy('priority')
            ->values()
            ->toArray();
    }
}
