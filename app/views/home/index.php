<section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden">
    <div class="absolute inset-0">
        <img src="<?= asset('images/ChatGPT Image 30 août 2026, 01_05_36.png') ?>" alt="" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-nex-dark/80 via-nex-dark/40 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-nex-blue/60 via-transparent to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 w-full">
        <div class="max-w-xl fade-in">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    Votre ordinateur.
                    <span class="text-blue-200">Votre style.</span>
                </h1>

                <p class="text-lg text-white/80 leading-relaxed mb-8">
                    <?= escapeHtml($settings['hero_subtitle'] ?? 'NexSkin transforme votre ordinateur en une pièce unique grâce à des designs et habillages personnalisés.') ?>
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= url('/realisations') ?>" class="inline-flex items-center justify-center gap-2 bg-nex-blue hover:bg-blue-700 text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25">
                        Voir les réalisations
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="<?= url('/contact') ?>" class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold px-8 py-3.5 rounded-full border border-white/30 transition-all duration-200">
                        Faire mon custom
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center fade-in">
            <p class="text-nex-gray text-lg mb-4">Un ordinateur ne doit pas forcément ressembler à tous les autres.</p>
            <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark">Nous personnalisons ce que vous utilisez chaque jour.</h2>
        </div>
    </div>
</section>

<?php if (!empty($featuredProjects)): ?>
<section class="py-16 lg:py-24 bg-nex-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark mb-4">Des designs qui ne ressemblent qu'à vous.</h2>
            <p class="text-nex-gray text-lg max-w-2xl mx-auto">Découvrez quelques-unes de nos personnalisations.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php foreach ($featuredProjects as $index => $project): ?>
            <a href="<?= url('/realisations/' . escapeHtml($project['slug'])) ?>" class="project-card group block bg-white rounded-xl overflow-hidden shadow-sm fade-in fade-in-delay-<?= $index + 1 ?>" data-category="<?= (int) $project['category_id'] ?>">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="<?= getImageUrl($project['cover_image']) ?>" alt="<?= escapeHtml($project['title']) ?>" class="project-image w-full h-full object-cover" loading="lazy">
                </div>
                <div class="p-5">
                    <span class="text-xs font-medium text-nex-blue uppercase tracking-wide"><?= escapeHtml($project['category_name'] ?? '') ?></span>
                    <h3 class="text-lg font-semibold text-nex-dark mt-1 group-hover:text-nex-blue transition-colors"><?= escapeHtml($project['title']) ?></h3>
                    <?php if (!empty($project['short_description'])): ?>
                    <p class="text-sm text-nex-gray mt-2 line-clamp-2"><?= escapeHtml($project['short_description']) ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 fade-in">
            <a href="<?= url('/realisations') ?>" class="inline-flex items-center gap-2 text-nex-blue hover:text-blue-700 font-semibold transition-colors">
                Voir toutes les réalisations
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark mb-4">De l'ordinaire à l'unique.</h2>
            <p class="text-nex-gray text-lg max-w-2xl mx-auto">Regardez la transformation en déplaçant le curseur.</p>
        </div>

        <div class="max-w-3xl mx-auto fade-in">
            <div class="before-after-container rounded-xl overflow-hidden shadow-lg aspect-video bg-gray-100">
                <div class="before-after-after">
                    <img src="<?= asset('images/after-placeholder.svg') ?>" alt="Après NexSkin">
                    <span class="before-after-label before-after-label-after">APRÈS</span>
                </div>
                <div class="before-after-before">
                    <img src="<?= asset('images/before-placeholder.svg') ?>" alt="Avant NexSkin">
                    <span class="before-after-label before-after-label-before">AVANT</span>
                </div>
                <div class="before-after-slider" style="left: 50%;"></div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 lg:py-24 bg-nex-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark mb-4">Votre idée. Notre savoir-faire.</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $services = [
                ['icon' => 'layers', 'title' => 'Habillage personnalisé', 'desc' => 'Donnez une nouvelle identité à votre ordinateur.'],
                ['icon' => 'pen-tool', 'title' => 'Design sur mesure', 'desc' => 'Nous créons un visuel selon vos goûts.'],
                ['icon' => 'printer', 'title' => 'Impression & préparation', 'desc' => 'Préparation du design pour un rendu propre.'],
                ['icon' => 'hand', 'title' => 'Pose du skin', 'desc' => 'Application précise de l\'habillage.'],
                ['icon' => 'lightbulb', 'title' => 'Projet personnalisé', 'desc' => 'Vous avez une idée particulière ? Parlons-en.'],
            ];
            foreach ($services as $index => $service): ?>
            <div class="service-card bg-white p-6 rounded-xl fade-in fade-in-delay-<?= ($index % 3) + 1 ?>">
                <div class="w-12 h-12 bg-nex-blue-pale rounded-xl flex items-center justify-center mb-4">
                    <i data-lucide="<?= escapeHtml($service['icon']) ?>" class="w-6 h-6 text-nex-blue"></i>
                </div>
                <h3 class="text-lg font-semibold text-nex-dark mb-2"><?= escapeHtml($service['title']) ?></h3>
                <p class="text-sm text-nex-gray"><?= escapeHtml($service['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-nex-dark">De l'idée au résultat.</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $steps = [
                ['num' => '01', 'title' => 'Votre idée', 'desc' => 'Vous nous expliquez ce que vous imaginez.'],
                ['num' => '02', 'title' => 'Le design', 'desc' => 'Nous préparons ou adaptons le visuel.'],
                ['num' => '03', 'title' => 'Validation', 'desc' => 'Vous validez le rendu avant réalisation.'],
                ['num' => '04', 'title' => 'Transformation', 'desc' => 'Votre ordinateur reçoit son nouvel habillage.'],
            ];
            foreach ($steps as $index => $step): ?>
            <div class="process-step text-center fade-in fade-in-delay-<?= $index + 1 ?>">
                <div class="w-12 h-12 bg-nex-blue text-white rounded-full flex items-center justify-center text-sm font-bold mx-auto mb-4 relative z-10"><?= escapeHtml($step['num']) ?></div>
                <h3 class="text-lg font-semibold text-nex-dark mb-2"><?= escapeHtml($step['title']) ?></h3>
                <p class="text-sm text-nex-gray"><?= escapeHtml($step['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-16 lg:py-24 bg-nex-blue">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Et si votre ordinateur vous ressemblait vraiment ?</h2>
        <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">Parlons de votre projet et donnons une nouvelle identité à votre ordinateur.</p>
        <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-white hover:bg-blue-50 text-nex-blue font-semibold px-8 py-3.5 rounded-full transition-all duration-200 hover:shadow-lg">
            Faire mon custom
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>
