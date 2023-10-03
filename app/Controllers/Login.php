<?php

namespace App\Controllers;

use CodeIgniter\Cookie\Cookie;

class Login extends BaseController
{
    public function index()
    {
        $cookie = json_decode(get_cookie('hospital'));
        if ($cookie and $cookie->expiry > time()) {
            return view('dashboard');
        } else {
            return view('login', ['error' => '', 'display' => 'none']);
        }
    }

    public function check()
    {
        $code = $this->request->getPost('code');
        if ($code == 'deco3801') {
            // Set Cookie
            $expiry = time() + 3600 * 8;
            $data = array(
                'expiry' => $expiry
            );
            setcookie('hospital', json_encode($data), $expiry, '/');
            return view('dashboard');
        } else {
            return view('login', ['error' => 'The access code was incorrect!', 'display' => 'block']);
        }
    }

    public function logout()
    {
        setcookie('hospital', '', time() - 10000, '/');
        return redirect()->to(base_url('login'));
    }
}
