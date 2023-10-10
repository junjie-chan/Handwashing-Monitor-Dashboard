<?php

namespace App\Controllers;

use App\Models\DatabaseManagerModel;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Model;

class Login extends BaseController
{
    /**
     * Display interface login page.
     * @return string
     */
    public function index()
    {
        return view('notice');
    }

    public function load_data()
    {
        // Generate 1 month base data at the very beginning
        $model = Model('DatabaseManagerModel');
        $model->generate_base_data(1);
        return view('notice2');
    }

    public function login()
    {
        $cookie = json_decode(get_cookie('hospital'));
        // If the cookie is not expired, show dashboard page, else show login page
        if ($cookie and $cookie->expiry > time()) {
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('dashboard'))->with('error', '')->with('display', 'none');
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
        return redirect()->to(base_url('user_login'));
    }
}
