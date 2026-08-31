<?php

define('ROOT_PATH', dirname(__DIR__));

$envFile = ROOT_PATH . '/.env';
$lockFile = ROOT_PATH . '/.installed';
if (!file_exists($envFile) || !file_exists($lockFile)) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $installUrl = rtrim($scriptDir, '/') === '/public' ? '../install.php' : 'install.php';

    header('Location: ' . $installUrl);
    exit;
}

require_once ROOT_PATH . '/app/core/App.php';

use App\Core\App;

App::run();