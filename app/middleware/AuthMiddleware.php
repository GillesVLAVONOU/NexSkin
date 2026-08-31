<?php

namespace App\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public function handle(): bool
    {
        Session::start();

        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Veuillez vous connecter.');
            header('Location: /admin/login');
            exit;
        }

        return true;
    }
}
