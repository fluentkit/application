<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\Screen;

final class GeneralSettings extends Screen
{
    public const SCREEN_ID = 'general';

    protected int $priority = 10;

    protected string $label = 'General Settings';
}
