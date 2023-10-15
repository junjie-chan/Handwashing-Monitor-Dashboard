<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $cookie = json_decode(get_cookie('hospital'));
        if ($cookie and $cookie->expiry > time()) {
            $model = Model('DatabaseManagerModel');
            return view('dashboard_2', $model->get_label_base_data());
        } else {
            return view('login', ['error' => '', 'display' => 'none']);
        }
    }
}
