<?php

namespace App\Core;

require_once ROOT_PATH . '/app/helpers/url.php';
require_once ROOT_PATH . '/app/helpers/security.php';
require_once ROOT_PATH . '/app/helpers/image.php';
require_once ROOT_PATH . '/app/helpers/formatting.php';

class App
{
    public static function run(): void
    {
        self::registerAutoloader();
        self::loadEnvironment();
        self::configureRuntime();

        Session::start();

        $router = new Router();
        $GLOBALS['router'] = $router;
        require ROOT_PATH . '/routes/web.php';

        $router->dispatch();
    }

    private static function registerAutoloader(): void
    {
        spl_autoload_register(function (string $class): void {
            $prefix = 'App\\';
            if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
                return;
            }

            $relativeClass = substr($class, strlen($prefix));
            $segments = explode('\\', $relativeClass);
            $segments[0] = lcfirst($segments[0]);
            $file = ROOT_PATH . '/app/' . implode('/', $segments) . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    private static function loadEnvironment(): void
    {
        $envFile = ROOT_PATH . '/.env';
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strncmp($line, '#', 1) === 0 || strpos($line, '=') === false) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
        }
    }

    private static function configureRuntime(): void
    {
        date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Africa/Lagos');

        if (($_ENV['APP_ENV'] ?? 'development') === 'production') {
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
            error_reporting(E_ALL);
        }
    }
}