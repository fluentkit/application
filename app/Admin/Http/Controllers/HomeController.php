<?php

declare(strict_types=1);

namespace FluentKit\Admin\Http\Controllers;

use FluentKit\Admin\Area;
use FluentKit\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    private $admin = null;

    public function __construct(Area $admin)
    {
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        return view('admin.layouts.default', ['admin' => $this->admin->toArray($request)]);
    }
}
