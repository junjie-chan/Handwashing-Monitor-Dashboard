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
            if ($cookie->code == 'higherups') {
                return redirect()->to(base_url('dashboard_2'));
            } else if ($cookie->code == 'nurses') {
                return redirect()->to(base_url('dashboard_1'));
            }
        } else {
            return redirect()->to(base_url('dashboard_2'))->with('error', '')->with('display', 'none');
        }
    }

    /**
     * Check correctness of the submitted access code.
     * @return string
     */
    public function check()
    {
        $code = $this->request->getPost('code');
        if (in_array($code, array('nurses', 'higherups'))) {
            // Set Cookie
            $expiry = time() + 3600 * 8;
            $data = array(
                'expiry' => $expiry,
                'code' => $code
            );
            setcookie('hospital', json_encode($data), $expiry, '/');

            // Direct to different version dashboards
            if ($code == 'nurses') {
                return redirect()->to(base_url('dashboard_1'));
            } else if ($code == 'higherups') {
                return redirect()->to(base_url('dashboard_2'));
            }
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
