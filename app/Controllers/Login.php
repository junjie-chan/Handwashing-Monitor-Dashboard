<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('login', ['error' => '', 'display' => 'none']);
    }

    public function check()
    {
        $code = $this->request->getPost('code');
        if ($code == 'deco3801') {
            return view('dashboard');
        } else {
            return view('login', ['error' => 'The access code was incorrect!', 'display' => 'block']);
        }
    }
}
