<?php

namespace App\Core;

class Controller
{
    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = ROOT_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View {$view} not found.");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require ROOT_PATH . '/app/views/layouts/main.php';
    }

    protected function viewAdmin(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = ROOT_PATH . '/app/views/admin/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Admin view {$view} not found.");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require ROOT_PATH . '/app/views/layouts/admin.php';
    }

    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url, int $statusCode = 302): void
    {
        $target = str_starts_with($url, '/') ? url($url) : $url;
        header("Location: {$target}", true, $statusCode);
        exit;
    }

    protected function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($referer);
    }

    protected function with(string $key, mixed $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    protected function getFlash(string $key): ?string
    {
        $value = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $value;
    }

    protected function setPagination(int $total, int $perPage, int $currentPage): array
    {
        $totalPages = (int) ceil($total / $perPage);
        $currentPage = max(1, min($currentPage, max(1, $totalPages)));
        $offset = ($currentPage - 1) * $perPage;

        return [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'offset' => $offset,
        ];
    }
}
