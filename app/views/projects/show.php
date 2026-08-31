<!-- Project Header -->
<section class="pt-32 pb-8 lg:pt-40 lg:pb-12 bg-gradient-to-b from-nex-blue-pale/30 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-nex-gray-light mb-6 fade-in">
            <a href="<?= url('/') ?>" class="hover:text-nex-blue transition-colors">Accueil</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <a href="<?= url('/realisations') ?>" class="hover:text-nex-blue transition-colors">Réalisations</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-nex-dark"><?= escapeHtml($project['title']) ?></span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <a href="<?= url('/realisations?category=' . $project['category_id']) ?>" class="inline-block text-xs font-medium text-nex-blue uppercase tracking-wide mb-2 hover:underline">
                    <?= escapeHtml($project['category_name'] ?? '') ?>
                </a>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-nex-dark fade-in">
                    <?= escapeHtml($project['title']) ?>
                </h1>
            </div>
            <?php if ($project['project_date']): ?>
            <p class="text-sm text-nex-gray-light fade-in">
                <?= formatDate($project['project_date'], 'F Y') ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Cover Image -->
<section class="pb-12 lg:pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($project['cover_image']): ?>
        <div class="rounded-2xl overflow-hidden shadow-lg fade-in">
            <img src="<?= getImageUrl($project['cover_image']) ?>"
                 alt="<?= escapeHtml($project['title']) ?>"
                 class="w-full h-auto object-cover max-h-[70vh]">
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Project Details -->
<?php if ($project['description']): ?>
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none fade-in">
            <?= nl2brHtml($project['description']) ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Gallery -->
<?php if (!empty($project['images'])): ?>
<section class="py-12 lg:py-16 bg-nex-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-nex-dark mb-8 fade-in">Galerie</h2>
        <div class="gallery-grid">
            <?php foreach ($project['images'] as $index => $image): ?>
            <div class="rounded-xl overflow-hidden shadow-sm fade-in fade-in-delay-<?= ($index % 3) + 1 ?>">
                <img src="<?= getImageUrl($image['image_path']) ?>"
                     alt="<?= escapeHtml($image['alt_text'] ?: $project['title']) ?>"
                     class="w-full h-64 object-cover hover:scale-105 transition-transform duration-500"
                     loading="lazy">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Before / After -->
<?php if ($project['before_image'] && $project['after_image']): ?>
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-nex-dark mb-8 text-center fade-in">Avant / Après</h2>
        <div class="before-after-container rounded-xl overflow-hidden shadow-lg aspect-video bg-gray-100 fade-in">
            <div class="before-after-after">
                <img src="<?= getImageUrl($project['after_image']) ?>" alt="Après">
                <span class="before-after-label before-after-label-after">APRÈS</span>
            </div>
            <div class="before-after-before">
                <img src="<?= getImageUrl($project['before_image']) ?>" alt="Avant">
                <span class="before-after-label before-after-label-before">AVANT</span>
            </div>
            <div class="before-after-slider" style="left: 50%;"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Navigation -->
<section class="py-8 border-t border-nex-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <?php if ($prevProject): ?>
            <a href="<?= url('/realisations/' . escapeHtml($prevProject['slug'])) ?>" class="flex items-center gap-2 text-sm text-nex-gray hover:text-nex-blue transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <?= escapeHtml(truncate($prevProject['title'], 30)) ?>
            </a>
            <?php else: ?>
            <div></div>
            <?php endif; ?>

            <a href="<?= url('/realisations') ?>" class="text-sm text-nex-gray hover:text-nex-blue transition-colors">
                Toutes les réalisations
            </a>

            <?php if ($nextProject): ?>
            <a href="<?= url('/realisations/' . escapeHtml($nextProject['slug'])) ?>" class="flex items-center gap-2 text-sm text-nex-gray hover:text-nex-blue transition-colors">
                <?= escapeHtml(truncate($nextProject['title'], 30)) ?>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <?php else: ?>
            <div></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Related Projects -->
<?php if (!empty($relatedProjects)): ?>
<section class="py-16 lg:py-24 bg-nex-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-nex-dark mb-8 fade-in">Projets similaires</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php foreach ($relatedProjects as $index => $related): ?>
            <a href="<?= url('/realisations/' . escapeHtml($related['slug'])) ?>"
               class="project-card group block bg-white rounded-xl overflow-hidden shadow-sm fade-in fade-in-delay-<?= $index + 1 ?>">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="<?= getImageUrl($related['cover_image']) ?>"
                         alt="<?= escapeHtml($related['title']) ?>"
                         class="project-image w-full h-full object-cover"
                         loading="lazy">
                </div>
                <div class="p-5">
                    <span class="text-xs font-medium text-nex-blue uppercase tracking-wide">
                        <?= escapeHtml($related['category_name'] ?? '') ?>
                    </span>
                    <h3 class="text-lg font-semibold text-nex-dark mt-1 group-hover:text-nex-blue transition-colors">
                        <?= escapeHtml($related['title']) ?>
                    </h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="py-16 lg:py-24 bg-nex-blue">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
            Vous avez une idée similaire ?
        </h2>
        <p class="text-blue-100 text-lg mb-8">
            Créons ensemble votre prochaine réalisation.
        </p>
        <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-white hover:bg-blue-50 text-nex-blue font-semibold px-8 py-3.5 rounded-full transition-all duration-200 hover:shadow-lg">
            Faire mon custom
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>


