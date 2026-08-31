<!-- Hero -->
<section class="pt-32 pb-12 lg:pt-40 lg:pb-16 bg-gradient-to-b from-nex-blue-pale/30 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-nex-dark mb-4 fade-in">
            À propos
        </h1>
        <p class="text-nex-gray text-lg max-w-2xl mx-auto fade-in fade-in-delay-1">
            Découvrez l'histoire derrière NexSkin.
        </p>
    </div>
</section>

<!-- Story -->
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- Logo -->
            <div class="fade-in">
                <div class="rounded-2xl overflow-hidden shadow-lg bg-white aspect-[4/3] flex items-center justify-center p-12">
                    <img src="<?= asset('images/logo-mark.png') ?>"
                         alt="NexSkin Logo"
                         class="w-48 h-48 object-contain"
                         loading="lazy">
                </div>
            </div>

            <!-- Text -->
            <div class="fade-in fade-in-delay-1">
                <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark mb-6">
                    Derrière NexSkin.
                </h2>
                <div class="space-y-4 text-nex-gray leading-relaxed">
                    <p>
                        NexSkin est née d'une passion simple : celle de transformer l'ordinaire en exceptionnel. Chaque ordinateur portable est un outil que nous utilisons au quotidien, et pourtant, il est rare qu'il nous ressemble vraiment.
                    </p>
                    <p>
                        Nous croyons que la technologie peut être plus fonctionnelle et esthétique. Que chaque détail compte. Que la personnalisation est un moyen d'exprimer qui nous sommes.
                    </p>
                    <p>
                        Notre mission est de créer des designs uniques qui transforment votre ordinateur en un objet qui vous ressemble. Un objet dont vous êtes fier.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-16 lg:py-24 bg-nex-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark">
                Nos valeurs.
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $values = [
                ['icon' => 'sparkles', 'title' => 'Créativité', 'desc' => 'Chaque projet est une nouvelle occasion de créer quelque chose d\'unique.'],
                ['icon' => 'eye', 'title' => 'Attention au détail', 'desc' => 'La qualité se trouve dans les moindres détails, de la conception à la pose finale.'],
                ['icon' => 'heart', 'title' => 'Passion', 'desc' => 'Nous aimons ce que nous faisons, et ça se voit dans chaque réalisation.'],
            ];
            foreach ($values as $index => $value): ?>
            <div class="bg-white p-8 rounded-2xl border border-nex-border text-center fade-in fade-in-delay-<?= $index + 1 ?>">
                <div class="w-14 h-14 bg-nex-blue-pale rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="<?= $value['icon'] ?>" class="w-7 h-7 text-nex-blue"></i>
                </div>
                <h3 class="text-xl font-semibold text-nex-dark mb-3"><?= $value['title'] ?></h3>
                <p class="text-sm text-nex-gray leading-relaxed"><?= $value['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 lg:py-24 bg-nex-blue">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
            Envie de nous rencontrer ?
        </h2>
        <p class="text-blue-100 text-lg mb-8">
            Discutons de votre prochain projet.
        </p>
        <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-white hover:bg-blue-50 text-nex-blue font-semibold px-8 py-3.5 rounded-full transition-all duration-200 hover:shadow-lg">
            Contactez-nous
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>

