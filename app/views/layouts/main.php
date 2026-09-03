<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?= escapeHtml($pageTitle ?? 'NexSkin') ?></title>
    <meta name="description" content="<?= escapeHtml($pageDescription ?? 'NexSkin - Personnalisation d\'ordinateurs portables') ?>">
    <link rel="canonical" href="<?= url(currentUri()) ?>">

    <meta property="og:title" content="<?= escapeHtml($pageTitle ?? 'NexSkin') ?>">
    <meta property="og:description" content="<?= escapeHtml($pageDescription ?? 'NexSkin - Personnalisation d\'ordinateurs portables') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= url(currentUri()) ?>">
    <meta property="og:site_name" content="NexSkin">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= escapeHtml($pageTitle ?? 'NexSkin') ?>">
    <meta name="twitter:description" content="<?= escapeHtml($pageDescription ?? 'NexSkin - Personnalisation d\'ordinateurs portables') ?>">

    <link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=Sintony:wght@400;700&display=swap" rel="stylesheet">

    <?php if (($_ENV['APP_ENV'] ?? 'development') === 'production'): ?>
    <link rel="stylesheet" href="<?= asset('css/tailwind.css') ?>?v=<?= filemtime(ROOT_PATH . '/public/assets/css/tailwind.css') ?>">
    <?php else: ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { nex: { blue: '#2563EB', 'blue-light': '#60A5FA', 'blue-pale': '#EFF6FF', dark: '#111827', gray: '#4B5563', 'gray-light': '#6B7280', border: '#E5E7EB', bg: '#F8FAFC' } }, fontFamily: { manrope: ['Manrope', 'sans-serif'] } } }
        }
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .form-label {
                @apply block text-sm font-medium text-nex-dark mb-1.5;
            }
            .form-input {
                @apply w-full px-4 py-2.5 rounded-lg border border-nex-border bg-white text-nex-dark text-sm placeholder:text-nex-gray-light focus:outline-none focus:ring-2 focus:ring-nex-blue/20 focus:border-nex-blue transition-colors duration-200;
            }
            .file-input {
                @apply file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-nex-blue-pale file:text-nex-blue file:cursor-pointer file:transition-colors hover:file:bg-blue-100;
            }
        }
    </style>
    <?php endif; ?>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=<?= filemtime(ROOT_PATH . '/public/assets/css/style.css') ?>">
</head>
<body class="bg-white text-nex-dark antialiased">
    <?php $siteSettings = $settings ?? []; ?>
    <header id="site-header" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-transparent transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="<?= url('/') ?>" class="flex items-center gap-2 group">
                    <img src="<?= asset('images/logo-mark.png') ?>" alt="" class="w-8 h-8 lg:w-10 lg:h-10 transition-transform group-hover:scale-105">
                    <span class="font-bold text-xl lg:text-2xl text-nex-dark">Nex<span class="text-nex-blue">Skin</span></span>
                </a>

                <nav class="hidden lg:flex items-center gap-8" aria-label="Navigation principale">
                    <a href="<?= url('/') ?>" class="nav-link text-sm font-medium text-nex-gray hover:text-nex-dark transition-colors <?= isActive('/') ?>">Accueil</a>
                    <a href="<?= url('/realisations') ?>" class="nav-link text-sm font-medium text-nex-gray hover:text-nex-dark transition-colors <?= isActive('/realisations') ?>">Réalisations</a>
                    <a href="<?= url('/services') ?>" class="nav-link text-sm font-medium text-nex-gray hover:text-nex-dark transition-colors <?= isActive('/services') ?>">Services</a>
                    <a href="<?= url('/a-propos') ?>" class="nav-link text-sm font-medium text-nex-gray hover:text-nex-dark transition-colors <?= isActive('/a-propos') ?>">À propos</a>
                    <a href="<?= url('/contact') ?>" class="nav-link text-sm font-medium text-nex-gray hover:text-nex-dark transition-colors <?= isActive('/contact') ?>">Contact</a>
                </nav>

                <div class="hidden lg:block">
                    <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-nex-blue hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25">
                        Mon custom
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <button id="mobile-menu-btn" class="lg:hidden p-2 text-nex-dark" aria-label="Ouvrir le menu" aria-controls="mobile-menu" aria-expanded="false">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="lg:hidden hidden">
            <div class="bg-white border-t border-nex-border px-4 py-6 space-y-4 text-center">
                <a href="<?= url('/') ?>" class="block text-base font-medium text-nex-dark <?= isActive('/') ?>">Accueil</a>
                <a href="<?= url('/realisations') ?>" class="block text-base font-medium text-nex-gray hover:text-nex-dark <?= isActive('/realisations') ?>">Réalisations</a>
                <a href="<?= url('/services') ?>" class="block text-base font-medium text-nex-gray hover:text-nex-dark <?= isActive('/services') ?>">Services</a>
                <a href="<?= url('/a-propos') ?>" class="block text-base font-medium text-nex-gray hover:text-nex-dark <?= isActive('/a-propos') ?>">À propos</a>
                <a href="<?= url('/contact') ?>" class="block text-base font-medium text-nex-gray hover:text-nex-dark <?= isActive('/contact') ?>">Contact</a>
                <div class="pt-4 border-t border-nex-border">
                    <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-nex-blue text-white text-sm font-semibold px-5 py-2.5 rounded-full w-full justify-center">
                        Mon custom
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="bg-nex-bg border-t border-nex-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="lg:col-span-2">
                    <a href="<?= url('/') ?>" class="flex items-center gap-2 mb-3">
                        <img src="<?= asset('images/logo-mark.png') ?>" alt="" class="w-7 h-7">
                        <span class="font-bold text-lg text-nex-dark">Nex<span class="text-nex-blue">Skin</span></span>
                    </a>
                    <p class="text-nex-gray text-xs leading-relaxed max-w-md">Votre ordinateur. Votre style.</p>
                </div>

                <div>
                    <h3 class="font-semibold text-nex-dark text-sm mb-3">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="<?= url('/') ?>" class="text-xs text-nex-gray hover:text-nex-blue transition-colors">Accueil</a></li>
                        <li><a href="<?= url('/realisations') ?>" class="text-xs text-nex-gray hover:text-nex-blue transition-colors">Réalisations</a></li>
                        <li><a href="<?= url('/services') ?>" class="text-xs text-nex-gray hover:text-nex-blue transition-colors">Services</a></li>
                        <li><a href="<?= url('/a-propos') ?>" class="text-xs text-nex-gray hover:text-nex-blue transition-colors">À propos</a></li>
                        <li><a href="<?= url('/contact') ?>" class="text-xs text-nex-gray hover:text-nex-blue transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-nex-dark text-sm mb-3">Suivez-nous</h3>
                    <div class="flex gap-2">
                        <?php if (!empty($siteSettings['instagram'])): ?>
                        <a href="<?= escapeHtml($siteSettings['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-nex-blue-pale rounded-full flex items-center justify-center text-nex-blue hover:bg-nex-blue hover:text-white transition-all" aria-label="Instagram"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($siteSettings['facebook'])): ?>
                        <a href="<?= escapeHtml($siteSettings['facebook']) ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-nex-blue-pale rounded-full flex items-center justify-center text-nex-blue hover:bg-nex-blue hover:text-white transition-all" aria-label="Facebook"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($siteSettings['tiktok'])): ?>
                        <a href="<?= escapeHtml($siteSettings['tiktok']) ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-nex-blue-pale rounded-full flex items-center justify-center text-nex-blue hover:bg-nex-blue hover:text-white transition-all" aria-label="TikTok"><i data-lucide="music-2" class="w-4 h-4"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="border-t border-nex-border mt-6 pt-5 flex flex-col sm:flex-row justify-between items-center gap-3">
                <p class="text-xs text-nex-gray-light">&copy; <?= currentYear() ?> NexSkin. Tous droits réservés.</p>
                <div class="flex gap-4">
                    <a href="<?= url('/mentions-legales') ?>" class="text-xs text-nex-gray-light hover:text-nex-gray transition-colors">Mentions légales</a>
                    <a href="<?= url('/politique-confidentialite') ?>" class="text-xs text-nex-gray-light hover:text-nex-gray transition-colors">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <?php if (!empty($siteSettings['whatsapp'])): ?>
    <a href="https://wa.me/<?= escapeHtml($siteSettings['whatsapp']) ?>?text=<?= urlencode('Bonjour NexSkin, j\'aimerais personnaliser mon ordinateur.') ?>"
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 z-40 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105"
       aria-label="Discuter sur WhatsApp">
        <img src="<?= asset('images/whatsapp.svg') ?>" alt="WhatsApp" class="w-8 h-8">
    </a>
    <?php endif; ?>

    <script src="<?= asset('js/app.js') ?>?v=<?= filemtime(ROOT_PATH . '/public/assets/js/app.js') ?>" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</body>
</html>


