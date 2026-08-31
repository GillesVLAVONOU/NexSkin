<!-- Hero -->
<section class="pt-32 pb-12 lg:pt-40 lg:pb-16 bg-gradient-to-b from-nex-blue-pale/30 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-nex-dark mb-4 fade-in">
            Nos réalisations
        </h1>
        <p class="text-nex-gray text-lg max-w-2xl mx-auto fade-in fade-in-delay-1">
            Chaque projet est une nouvelle manière de raconter une histoire.
        </p>
    </div>
</section>

<!-- Filters & Gallery -->
<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="flex flex-wrap justify-center gap-3 mb-12 fade-in">
            <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium border border-nex-border <?= !$currentCategory ? 'active' : 'bg-white text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>"
                    data-filter="all">
                Tous
            </button>
            <?php foreach ($categories as $category): ?>
            <a href="<?= url('/realisations?category=' . $category['id']) ?>"
               class="filter-btn px-5 py-2 rounded-full text-sm font-medium border border-nex-border <?= $currentCategory == $category['id'] ? 'active' : 'bg-white text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>">
                <?= escapeHtml($category['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Gallery -->
        <?php if (empty($projects)): ?>
        <div class="text-center py-16 fade-in">
            <i data-lucide="image" class="w-16 h-16 text-nex-border mx-auto mb-4"></i>
            <h3 class="text-xl font-semibold text-nex-dark mb-2">Aucune réalisation</h3>
            <p class="text-nex-gray">Revenez bientôt, nos projets arrivent.</p>
        </div>
        <?php else: ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php foreach ($projects as $index => $project): ?>
            <a href="<?= url('/realisations/' . escapeHtml($project['slug'])) ?>"
               class="project-card group block bg-white rounded-xl overflow-hidden shadow-sm fade-in fade-in-delay-<?= ($index % 3) + 1 ?>"
               data-category="<?= $project['category_id'] ?>">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="<?= getImageUrl($project['cover_image']) ?>"
                         alt="<?= escapeHtml($project['title']) ?>"
                         class="project-image w-full h-full object-cover"
                         loading="lazy">
                </div>
                <div class="p-5">
                    <span class="text-xs font-medium text-nex-blue uppercase tracking-wide">
                        <?= escapeHtml($project['category_name'] ?? '') ?>
                    </span>
                    <h3 class="text-lg font-semibold text-nex-dark mt-1 group-hover:text-nex-blue transition-colors">
                        <?= escapeHtml($project['title']) ?>
                    </h3>
                    <?php if ($project['short_description']): ?>
                    <p class="text-sm text-nex-gray mt-2 line-clamp-2">
                        <?= escapeHtml($project['short_description']) ?>
                    </p>
                    <?php endif; ?>
                    <?php if ($project['project_date']): ?>
                    <p class="text-xs text-nex-gray-light mt-3">
                        <?= formatDate($project['project_date']) ?>
                    </p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pagination['total_pages'] > 1): ?>
        <div class="flex justify-center gap-2 mt-12">
            <?php if ($pagination['current_page'] > 1): ?>
            <a href="?page=<?= $pagination['current_page'] - 1 ?><?= $currentCategory ? '&category=' . $currentCategory : '' ?>"
               class="px-4 py-2 rounded-lg border border-nex-border text-sm font-medium text-nex-gray hover:border-nex-blue hover:text-nex-blue transition-colors">
                ← Précédent
            </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
            <a href="?page=<?= $i ?><?= $currentCategory ? '&category=' . $currentCategory : '' ?>"
               class="px-4 py-2 rounded-lg text-sm font-medium <?= $i === $pagination['current_page'] ? 'bg-nex-blue text-white' : 'border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?> transition-colors">
                <?= $i ?>
            </a>
            <?php endfor; ?>

            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
            <a href="?page=<?= $pagination['current_page'] + 1 ?><?= $currentCategory ? '&category=' . $currentCategory : '' ?>"
               class="px-4 py-2 rounded-lg border border-nex-border text-sm font-medium text-nex-gray hover:border-nex-blue hover:text-nex-blue transition-colors">
                Suivant →
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="py-16 lg:py-24 bg-nex-blue">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
            Vous avez un projet en tête ?
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


