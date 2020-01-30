<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

final class UserLink implements UserLinkInterface
{
    private ?string $id;

    private string $type = 'link';

    private string $text = '';

    private string $route = 'home';

    private array $params = [];

    private array $query = [];

    private int $priority = 10;

    public static function divider(string $id, int $priority = 10)
    {
        return new static($id, '', '', $priority, 'divider');
    }

    public function __construct(string $id, string $text, string $route, int $priority = 10, string $type = 'link')
    {
        $this->id = $id;
        $this->text = $text;
        $this->route = $route;
        $this->priority = $priority;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setParams(array $params): UserLinkInterface
    {
        $this->params = $params;

        return $this;
    }

    public function setQuery(array $query): UserLinkInterface
    {
        $this->query = $query;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'text' => $this->text,
            'name' => $this->route,
            'priority' => $this->priority,
            'params' => $this->params,
            'query' => $this->query,
        ];
    }
}
