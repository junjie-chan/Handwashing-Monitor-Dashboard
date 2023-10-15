<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $cookie = json_decode(get_cookie('hospital'));
        if ($cookie and $cookie->expiry > time()) {
            if ($cookie->code == 'higherups') {
                $model = Model('DatabaseManagerModel');
                return view('dashboard_2', $model->get_label_base_data());
            } else if ($cookie->code == 'nurses') {
                return view('dashboard_1');
            }
        } else {
            return view('login', ['error' => '', 'display' => 'none']);
        }
    }
}
