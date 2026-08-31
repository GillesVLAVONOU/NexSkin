<?php

namespace App\Middleware;

use App\Core\Session;

class AdminMiddleware
{
    public function handle(): bool
    {
        Session::start();

        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Accès non autorisé.');
            header('Location: ' . url('/admin/login'));
            exit;
        }

        $role = Session::get('user_role');
        if ($role !== 'admin') {
            Session::flash('error', 'Accès réservé aux administrateurs.');
            header('Location: ' . url('/admin/login'));
            exit;
        }

        return true;
    }
}

