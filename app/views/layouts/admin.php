<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?= escapeHtml($pageTitle ?? 'Admin - NexSkin') ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?php if (($_ENV['APP_ENV'] ?? 'development') === 'production'): ?>
    <link rel="stylesheet" href="<?= asset('css/tailwind.css') ?>">
    <?php else: ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { nex: { blue: '#2563EB', 'blue-light': '#60A5FA', 'blue-pale': '#EFF6FF', dark: '#111827', gray: '#4B5563', 'gray-light': '#6B7280', border: '#E5E7EB', bg: '#F8FAFC' } }, fontFamily: { manrope: ['Manrope', 'sans-serif'] } } }
        }
    </script>
    <?php endif; ?>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="font-manrope bg-nex-bg text-nex-dark antialiased">
    <div class="flex min-h-screen">
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-nex-border transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="flex items-center gap-2 px-6 py-5 border-b border-nex-border">
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center gap-2">
                    <img src="<?= asset('images/logo-mark.png') ?>" alt="" class="w-8 h-8">
                    <span class="font-bold text-lg text-nex-dark">Nex<span class="text-nex-blue">Skin</span></span>
                </a>
            </div>

            <nav class="px-4 py-6 space-y-1" aria-label="Navigation administration">
                <a href="<?= url('/admin/dashboard') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= currentUri() === '/admin/dashboard' ? 'bg-nex-blue text-white' : 'text-nex-gray hover:bg-nex-blue-pale hover:text-nex-blue' ?>"><i data-lucide="layout-dashboard" class="w-5 h-5"></i>Dashboard</a>
                <a href="<?= url('/admin/projects') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= str_starts_with(currentUri(), '/admin/projects') ? 'bg-nex-blue text-white' : 'text-nex-gray hover:bg-nex-blue-pale hover:text-nex-blue' ?>"><i data-lucide="image" class="w-5 h-5"></i>Réalisations</a>
                <a href="<?= url('/admin/categories') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= str_starts_with(currentUri(), '/admin/categories') ? 'bg-nex-blue text-white' : 'text-nex-gray hover:bg-nex-blue-pale hover:text-nex-blue' ?>"><i data-lucide="tag" class="w-5 h-5"></i>Catégories</a>
                <a href="<?= url('/admin/messages') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= str_starts_with(currentUri(), '/admin/messages') ? 'bg-nex-blue text-white' : 'text-nex-gray hover:bg-nex-blue-pale hover:text-nex-blue' ?>"><i data-lucide="mail" class="w-5 h-5"></i>Messages</a>
                <a href="<?= url('/admin/settings') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= str_starts_with(currentUri(), '/admin/settings') ? 'bg-nex-blue text-white' : 'text-nex-gray hover:bg-nex-blue-pale hover:text-nex-blue' ?>"><i data-lucide="settings" class="w-5 h-5"></i>Paramètres</a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-nex-border">
                <a href="<?= url('/') ?>" target="_blank" class="flex items-center gap-2 text-sm text-nex-gray hover:text-nex-blue transition-colors mb-3"><i data-lucide="external-link" class="w-4 h-4"></i>Voir le site</a>
                <form method="POST" action="<?= url('/admin/logout') ?>">
                    <?= \App\Core\Request::csrfField() ?>
                    <button type="submit" class="flex items-center gap-2 text-sm text-nex-gray hover:text-red-600 transition-colors w-full"><i data-lucide="log-out" class="w-4 h-4"></i>Déconnexion</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 lg:ml-64">
            <header class="bg-white border-b border-nex-border sticky top-0 z-40">
                <div class="flex items-center justify-between px-4 sm:px-6 py-4">
                    <button id="sidebar-toggle" class="lg:hidden p-2 text-nex-gray hover:text-nex-dark" aria-label="Ouvrir le menu admin"><i data-lucide="menu" class="w-5 h-5"></i></button>
                    <div class="flex items-center gap-4 ml-auto"><span class="text-sm text-nex-gray-light"><?= date('d/m/Y') ?></span></div>
                </div>
            </header>

            <div class="p-4 sm:p-6 lg:p-8">
                <?php $success = \App\Core\Session::getFlash('success'); $error = \App\Core\Session::getFlash('error'); ?>
                <?php if ($success): ?>
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2"><i data-lucide="check-circle" class="w-5 h-5"></i><?= escapeHtml($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2"><i data-lucide="alert-circle" class="w-5 h-5"></i><?= escapeHtml($error) ?></div>
                <?php endif; ?>

                <?= $content ?>
            </div>
        </div>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>
    <script src="<?= asset('js/admin.js') ?>" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</body>
</html>

