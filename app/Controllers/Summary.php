<?php

namespace App\Controllers;

class Summary extends BaseController
{
    public function index(): string
    {
        return view('summary');
    }
}