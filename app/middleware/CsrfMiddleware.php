<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Session;

class CsrfMiddleware
{
    public function handle(): bool
    {
        Session::start();

        if (Request::isPost() && !Request::validateCsrf()) {
            Session::flash('error', 'Token de securite invalide. Veuillez recharger la page puis reessayer.');
            $redirect = $_SERVER['HTTP_REFERER'] ?? url('/');
            header('Location: ' . $redirect);
            exit;
        }

        return true;
    }
}
