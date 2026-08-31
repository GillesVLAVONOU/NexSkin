<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 900;

    public function loginForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/admin/dashboard');
            return;
        }

        $pageTitle = 'Connexion - Admin NexSkin';
        $error = Session::getFlash('error');
        require ROOT_PATH . '/app/views/admin/auth/login.php';
    }

    public function login(): void
    {
        if ($this->isLockedOut()) {
            Session::flash('error', 'Trop de tentatives. Veuillez reessayer dans quelques minutes.');
            $this->redirect('/admin/login');
            return;
        }

        $email = trim((string) Request::input('email', ''));
        $password = (string) Request::input('password', '');

        if ($email === '' || $password === '') {
            $this->recordFailedAttempt();
            Session::flash('error', 'Email et mot de passe requis.');
            $this->redirect('/admin/login');
            return;
        }

        $user = (new User())->findByEmail($email);

        if (!$user || !verifyPassword($password, $user['password'])) {
            $this->recordFailedAttempt();
            Session::flash('error', 'Identifiants incorrects.');
            $this->redirect('/admin/login');
            return;
        }

        Session::remove('login_attempts');
        Session::remove('login_locked_until');
        Session::login($user);
        $this->redirect('/admin/dashboard');
    }

    public function logout(): void
    {
        Session::logout();
        $this->redirect('/admin/login');
    }

    private function isLockedOut(): bool
    {
        return (int) Session::get('login_locked_until', 0) > time();
    }

    private function recordFailedAttempt(): void
    {
        $attempts = (int) Session::get('login_attempts', 0) + 1;
        Session::set('login_attempts', $attempts);

        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            Session::set('login_locked_until', time() + self::LOCKOUT_SECONDS);
        }
    }
}
