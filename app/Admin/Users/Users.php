<?php

declare(strict_types=1);

namespace FluentKit\Admin\Users;

use FluentKit\Admin\Dashboard\Screens\MainDashboard;
use FluentKit\Admin\Users\Screens\Edit;
use FluentKit\Admin\UI\Section;

final class Users extends Section
{
    public function __construct()
    {
        $this->setId('users');
        $this->setIcon('fa-user');
        $this->setLabel('Users');
        $this->setPriority(20);

        $this->registerScreen(new MainDashboard());
        $this->registerScreen(new Edit());
    }
}
