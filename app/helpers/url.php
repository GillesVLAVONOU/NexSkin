<?php

function url(string $path = ''): string
{
    $base = rtrim($_ENV['APP_URL'] ?? 'http://localhost/nexskin', '/');
    $path = '/' . ltrim($path, '/');
    return $base . $path;
}

function routeUrl(string $path = ''): string
{
    return url($path);
}

function asset(string $path): string
{
    return url('public/assets/' . ltrim($path, '/'));
}

function upload(string $path): string
{
    return url('public/uploads/' . ltrim($path, '/'));
}

function currentUri(): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $basePath = parse_url($_ENV['APP_URL'] ?? '', PHP_URL_PATH) ?: '';
    $basePath = rtrim($basePath, '/');

    foreach (array_filter([$basePath . '/public', $basePath]) as $prefix) {
        if ($prefix !== '' && str_starts_with($uri, $prefix)) {
            $uri = substr($uri, strlen($prefix)) ?: '/';
            break;
        }
    }

    return '/' . trim($uri, '/');
}

function isActive(string $path): string
{
    $current = currentUri();
    if ($path === '/') {
        return $current === '/' ? 'active' : '';
    }
    return str_starts_with($current, $path) ? 'active' : '';
}
