<?php

declare(strict_types=1);

namespace FluentKit\Admin\Dashboard;

use FluentKit\Admin\Dashboard\Screens\MainDashboard;
use FluentKit\Admin\UI\Section;

final class Dashboards extends Section
{
    public function __construct()
    {
        $this->setId('dashboards');
        $this->setIcon('fa-home');
        $this->setLabel('Dashboard');

        $this->registerScreen(new MainDashboard());
    }
}
