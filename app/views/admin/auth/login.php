<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?= escapeHtml($pageTitle ?? 'Connexion - Admin NexSkin') ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php if (($_ENV['APP_ENV'] ?? 'development') === 'production'): ?>
    <link rel="stylesheet" href="<?= asset('css/tailwind.css') ?>">
    <?php else: ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { nex: { blue: '#2563EB', bg: '#F8FAFC' } }, fontFamily: { manrope: ['Manrope', 'sans-serif'] } } } }
    </script>
    <?php endif; ?>
</head>
<body class="font-manrope bg-nex-bg flex items-center justify-center min-h-screen px-4 text-gray-900">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="<?= url('/') ?>" class="inline-flex items-center gap-2">
                <img src="<?= asset('images/logo-mark.png') ?>" alt="" class="w-10 h-10">
                <span class="font-bold text-2xl">Nex<span class="text-nex-blue">Skin</span></span>
            </a>
            <p class="text-gray-500 mt-2 text-sm">Administration</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <?php if (!empty($error)): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <?= escapeHtml($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= url('/admin/login') ?>" class="space-y-5">
                <?= \App\Core\Request::csrfField() ?>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required autocomplete="username"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           placeholder="admin@nexskin.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           placeholder="Mot de passe">
                </div>

                <button type="submit" class="w-full bg-nex-blue hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-colors">
                    Se connecter
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">&copy; <?= date('Y') ?> NexSkin. Tous droits réservés.</p>
    </div>
</body>
</html>

