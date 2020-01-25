<?php

declare(strict_types=1);

namespace FluentKit\Admin\Dashboard\Screens;

use FluentKit\Admin\Screen;

final class MainDashboard extends Screen
{
    public const SCREEN_ID = 'main';

    protected int $priority = 10;

    protected string $label = 'Dashboard';
}
