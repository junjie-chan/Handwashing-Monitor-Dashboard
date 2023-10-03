<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $cookie = json_decode(get_cookie('hospital'));
        if ($cookie and $cookie->expiry > time()) {
            return view('dashboard');
        } else {
            return view('login', ['error' => '', 'display' => 'none']);
        }
    }
}
