<?php

namespace App\Core;

class Request
{
    public static function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public static function query(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public static function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isPost(): bool
    {
        return self::method() === 'POST';
    }

    public static function isGet(): bool
    {
        return self::method() === 'GET';
    }

    public static function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public static function csrfToken(): string
    {
        Session::start();
        if (!Session::has('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('csrf_token');
    }

    public static function csrfField(): string
    {
        return '<input type="hidden" name="_token" value="' . self::csrfToken() . '">';
    }

    public static function validateCsrf(): bool
    {
        Session::start();
        $token = $_POST['_token'] ?? '';
        $sessionToken = Session::get('csrf_token', '');
        return is_string($token) && is_string($sessionToken)
            && $sessionToken !== ''
            && hash_equals($sessionToken, $token);
    }

    public static function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }

    public static function hasFile(string $key): bool
    {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] !== UPLOAD_ERR_NO_FILE;
    }
}
