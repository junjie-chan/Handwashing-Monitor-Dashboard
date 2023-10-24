<?php

namespace App\Controllers;

class Dashboard_V1 extends BaseController
{
    public function index(): string
    {
        return view('dashboard_v1');
    }
}
