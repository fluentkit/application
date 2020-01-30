<?php

declare(strict_types=1);

namespace FluentKit\Admin\Dashboard;

use FluentKit\Admin\Dashboard\Screens\MainDashboard;
use FluentKit\Admin\UI\Section;

final class Dashboards extends Section
{
    public const SECTION_ID = 'dashboards';

    protected int $priority = 10;

    protected string $icon = 'fa-home';

    protected string $label = 'Dashboard';

    public function __construct()
    {
        $this->registerScreen(new MainDashboard());
    }
}
