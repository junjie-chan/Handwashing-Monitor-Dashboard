<?php

namespace App\Controllers;

use CodeIgniter\Cookie\Cookie;

class Login extends BaseController
{
    /**
     * Display interface login page.
     * @return string
     */
    public function index()
    {
        $cookie = json_decode(get_cookie('hospital'));
        // If the cookie is not expired, show dashboard page, else show login page
        if ($cookie and $cookie->expiry > time()) {
            return view('dashboard');
        } else {
            return view('login', ['error' => '', 'display' => 'none']);
        }
    }

    /**
     * Check correctness of the submitted access code.
     * @return string
     */
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

    /**
     * Perform logout function.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        // Remove cookies and redirect back to the login page
        setcookie('hospital', '', time() - 10000, '/');
        return redirect()->to(base_url('login'));
    }
}
