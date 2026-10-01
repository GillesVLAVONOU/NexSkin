<section class="portfolio-hero">
    <div class="portfolio-shell portfolio-hero-content">
        <p class="portfolio-eyebrow fade-in"><span></span> L’atelier NexSkin</p>
        <h1 class="fade-in fade-in-delay-1">Nos <span>réalisations</span></h1>
        <p class="portfolio-intro fade-in fade-in-delay-2">Chaque ordinateur a son histoire. Découvrez les créations imaginées et réalisées sur mesure dans notre atelier.</p>
        <div class="portfolio-count fade-in fade-in-delay-3"><strong><?= (int) $pagination['total'] ?></strong><?= $pagination['total'] === 1 ? ' projet présenté' : ' projets présentés' ?></div>
    </div>
</section>

<section class="portfolio-section">
    <div class="portfolio-shell">
        <nav class="portfolio-filters fade-in" aria-label="Filtrer les réalisations par catégorie">
            <a href="<?= url('/realisations') ?>" class="portfolio-filter<?= !$currentCategory ? ' is-active' : '' ?>" <?= !$currentCategory ? 'aria-current="page"' : '' ?>>Toutes les créations</a>
            <?php foreach ($categories as $category): ?>
            <a href="<?= url('/realisations?category=' . $category['id']) ?>"
               class="portfolio-filter<?= (int) $currentCategory === (int) $category['id'] ? ' is-active' : '' ?>"
               <?= (int) $currentCategory === (int) $category['id'] ? 'aria-current="page"' : '' ?>>
                <?= escapeHtml($category['name']) ?>
            </a>
            <?php endforeach; ?>
        </nav>

        <?php if (empty($projects)): ?>
        <div class="portfolio-empty fade-in">
            <span class="portfolio-empty-icon"><i data-lucide="images" aria-hidden="true"></i></span>
            <h2>Aucune réalisation pour le moment</h2>
            <p>De nouveaux projets arrivent bientôt. Revenez découvrir les prochaines créations NexSkin.</p>
            <?php if ($currentCategory): ?>
            <a class="portfolio-reset" href="<?= url('/realisations') ?>">Voir toutes les réalisations</a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="portfolio-grid">
            <?php foreach ($projects as $index => $project): ?>
            <a href="<?= url('/realisations/' . escapeHtml($project['slug'])) ?>"
               class="portfolio-card project-card fade-in fade-in-delay-<?= ($index % 3) + 1 ?>">
                <div class="portfolio-card-image">
                    <img src="<?= getImageUrl($project['cover_image']) ?>"
                         alt="<?= escapeHtml($project['title']) ?>"
                         class="project-image"
                         loading="lazy">
                    <span class="portfolio-card-open" aria-hidden="true"><i data-lucide="arrow-up-right"></i></span>
                </div>
                <div class="portfolio-card-content">
                    <div class="portfolio-card-meta">
                        <span class="portfolio-category"><?= escapeHtml($project['category_name'] ?? 'Projet personnalisé') ?></span>
                        <?php if ($project['project_date']): ?>
                        <span class="portfolio-date"><?= formatDate($project['project_date']) ?></span>
                        <?php endif; ?>
                    </div>
                    <h2><?= escapeHtml($project['title']) ?></h2>
                    <?php if (!empty($project['short_description'])): ?>
                    <p><?= escapeHtml($project['short_description']) ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if ($pagination['total_pages'] > 1): ?>
        <?php
        $pageStart = max(1, $pagination['current_page'] - 2);
        $pageEnd = min($pagination['total_pages'], $pagination['current_page'] + 2);
        $categoryQuery = $currentCategory ? '&category=' . (int) $currentCategory : '';
        ?>
        <nav class="portfolio-pagination fade-in" aria-label="Pagination des réalisations">
            <?php if ($pagination['current_page'] > 1): ?>
            <a href="?page=<?= $pagination['current_page'] - 1 ?><?= $categoryQuery ?>" class="portfolio-page-arrow">
                <i data-lucide="arrow-left" aria-hidden="true"></i><span>Précédent</span>
            </a>
            <?php endif; ?>

            <?php if ($pageStart > 1): ?>
            <a href="?page=1<?= $categoryQuery ?>" class="portfolio-page-number">1</a>
            <?php if ($pageStart > 2): ?><span class="portfolio-page-ellipsis" aria-hidden="true">…</span><?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $pageStart; $i <= $pageEnd; $i++): ?>
            <a href="?page=<?= $i ?><?= $categoryQuery ?>" class="portfolio-page-number<?= $i === $pagination['current_page'] ? ' is-active' : '' ?>" <?= $i === $pagination['current_page'] ? 'aria-current="page"' : '' ?>>
                <?= $i ?>
            </a>
            <?php endfor; ?>

            <?php if ($pageEnd < $pagination['total_pages']): ?>
            <?php if ($pageEnd < $pagination['total_pages'] - 1): ?><span class="portfolio-page-ellipsis" aria-hidden="true">…</span><?php endif; ?>
            <a href="?page=<?= $pagination['total_pages'] ?><?= $categoryQuery ?>" class="portfolio-page-number"><?= $pagination['total_pages'] ?></a>
            <?php endif; ?>

            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
            <a href="?page=<?= $pagination['current_page'] + 1 ?><?= $categoryQuery ?>" class="portfolio-page-arrow">
                <span>Suivant</span><i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<section class="home-cta home-section" data-section-reveal>
    <div class="home-shell">
        <div class="home-cta-inner fade-in">
            <div class="home-cta-main">
                <p class="home-eyebrow home-eyebrow-light"><span></span> Votre idée ensuite</p>
                <h2>Créons votre<br>prochaine <em>pièce.</em></h2>
            </div>
            <div class="home-cta-aside">
                <p>Parlons de votre ordinateur et imaginons ensemble une personnalisation qui vous ressemble.</p>
                <div class="home-cta-actions">
                    <a href="<?= url('/contact') ?>" class="home-button home-button-light">Présenter mon projet <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>


