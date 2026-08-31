<?php

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\ProjectController;
use App\Controllers\ServiceController;
use App\Controllers\AboutController;
use App\Controllers\ContactController;
use App\Controllers\LegalController;
use App\Controllers\SitemapController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProjectController as AdminProjectController;
use App\Controllers\Admin\CategoryController;
use App\Controllers\Admin\MessageController;
use App\Controllers\Admin\SettingsController;
use App\Middleware\AdminMiddleware;
use App\Middleware\CsrfMiddleware;

/** @var Router $router */
$router = $GLOBALS['router'];

// Public routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/realisations', [ProjectController::class, 'index']);
$router->get('/realisations/{slug}', [ProjectController::class, 'show']);
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/a-propos', [AboutController::class, 'index']);
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'store'], [CsrfMiddleware::class]);
$router->get('/mentions-legales', [LegalController::class, 'legal']);
$router->get('/politique-confidentialite', [LegalController::class, 'privacy']);
$router->get('/sitemap.xml', [SitemapController::class, 'index']);

// Admin routes
$router->get('/admin/login', [AuthController::class, 'loginForm']);
$router->post('/admin/login', [AuthController::class, 'login'], [CsrfMiddleware::class]);
$router->post('/admin/logout', [AuthController::class, 'logout'], [CsrfMiddleware::class]);

$router->get('/admin/dashboard', [DashboardController::class, 'index'], [AdminMiddleware::class]);

$router->get('/admin/projects', [AdminProjectController::class, 'index'], [AdminMiddleware::class]);
$router->get('/admin/projects/create', [AdminProjectController::class, 'create'], [AdminMiddleware::class]);
$router->post('/admin/projects', [AdminProjectController::class, 'store'], [CsrfMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/projects/edit/{id}', [AdminProjectController::class, 'edit'], [AdminMiddleware::class]);
$router->post('/admin/projects/update/{id}', [AdminProjectController::class, 'update'], [CsrfMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/projects/delete/{id}', [AdminProjectController::class, 'delete'], [CsrfMiddleware::class, AdminMiddleware::class]);

$router->get('/admin/categories', [CategoryController::class, 'index'], [AdminMiddleware::class]);
$router->post('/admin/categories', [CategoryController::class, 'store'], [CsrfMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/categories/update/{id}', [CategoryController::class, 'update'], [CsrfMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/categories/delete/{id}', [CategoryController::class, 'delete'], [CsrfMiddleware::class, AdminMiddleware::class]);

$router->get('/admin/messages', [MessageController::class, 'index'], [AdminMiddleware::class]);
$router->post('/admin/messages/status/{id}', [MessageController::class, 'updateStatus'], [CsrfMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/messages/delete/{id}', [MessageController::class, 'delete'], [CsrfMiddleware::class, AdminMiddleware::class]);

$router->get('/admin/settings', [SettingsController::class, 'index'], [AdminMiddleware::class]);
$router->post('/admin/settings', [SettingsController::class, 'update'], [CsrfMiddleware::class, AdminMiddleware::class]);


