<?php
$heroSlides = json_decode($settings['hero_images'] ?? '[]', true);
$heroSlides = is_array($heroSlides)
    ? array_values(array_filter($heroSlides, static fn ($image): bool => is_string($image) && $image !== ''))
    : [];
if (!$heroSlides) {
    $heroSlides = ['public/assets/images/ChatGPT Image 30 août 2026, 01_05_36.png'];
}
$heroTitle = trim($settings['hero_title'] ?? '') ?: 'Votre ordinateur. Votre style.';
$heroTitleWords = preg_split('/\s+/u', $heroTitle, -1, PREG_SPLIT_NO_EMPTY);
$heroLetterIndex = 0;
?>
<section class="home-hero">
    <div class="home-hero-carousel" data-hero-carousel role="group" aria-label="Carrousel des créations NexSkin" aria-roledescription="carrousel">
        <?php foreach ($heroSlides as $index => $heroSlide): ?>
        <img class="home-hero-image home-hero-slide<?= $index === 0 ? ' is-active' : '' ?>" src="<?= getImageUrl($heroSlide) ?>" alt="Création NexSkin, visuel <?= $index + 1 ?>" <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
        <?php endforeach; ?>
    </div>
    <div class="home-hero-shade" aria-hidden="true"></div>
    <div class="home-shell home-hero-content">
        <p class="home-eyebrow home-eyebrow-light fade-in"><span></span> Habillages personnalisés · Créés pour vous</p>
        <h1 class="home-hero-title fade-in fade-in-delay-1" aria-label="<?= escapeHtml($heroTitle) ?>"><span class="home-hero-title-text" aria-hidden="true"><?php foreach ($heroTitleWords as $wordIndex => $word): ?><?= $wordIndex > 0 ? ' ' : '' ?><span class="home-hero-word<?= $wordIndex === count($heroTitleWords) - 1 ? ' is-accent' : '' ?>"><?php foreach (preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY) as $letter): ?><span class="home-hero-letter" style="--letter-index:<?= $heroLetterIndex++ ?>"><?= escapeHtml($letter) ?></span><?php endforeach; ?></span><?php endforeach; ?></span></h1>
        <p class="home-hero-copy fade-in fade-in-delay-2"><?= escapeHtml(trim($settings['hero_subtitle'] ?? '') ?: 'Donnez une nouvelle identité à votre ordinateur grâce à un habillage imaginé selon vos envies et réalisé avec soin.') ?></p>
        <div class="home-actions fade-in fade-in-delay-3">
            <a href="<?= url('/realisations') ?>" class="home-button home-button-primary">Voir nos réalisations</a>
            <a href="<?= url('/contact') ?>" class="home-button home-button-glass">Faire mon custom</a>
        </div>
    </div>
    <?php if (count($heroSlides) > 1): ?>
    <div class="home-carousel-controls" aria-label="Commandes du carrousel">
        <button type="button" data-carousel-previous aria-label="Image précédente"><i data-lucide="arrow-left" aria-hidden="true"></i></button>
        <div class="home-carousel-dots" role="group" aria-label="Choisir une image">
            <?php foreach ($heroSlides as $index => $heroSlide): ?>
            <button type="button" data-carousel-slide="<?= $index ?>" aria-label="Afficher l’image <?= $index + 1 ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>"></button>
            <?php endforeach; ?>
        </div>
        <button type="button" data-carousel-next aria-label="Image suivante"><i data-lucide="arrow-right" aria-hidden="true"></i></button>
    </div>
    <?php endif; ?>
</section>

<section class="home-intro home-section" id="inspiration" data-section-reveal>
    <div class="home-shell home-intro-inner">
        <div class="home-intro-heading fade-in">
            <h2>Votre ordinateur,<br><span>à votre image.</span></h2>
        </div>
        <div class="home-intro-copy fade-in fade-in-delay-1">
            <p>Votre ordinateur vous accompagne partout. Faites-en une pièce personnelle, conçue avec soin et réalisée pour durer.</p>
            <a href="<?= url('/a-propos') ?>">Découvrir l’approche NexSkin <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<?php if (!empty($featuredProjects)): ?>
<section class="home-projects home-section" data-section-reveal>
    <div class="home-shell">
        <div class="home-section-heading fade-in">
            <div><p class="home-eyebrow"><span></span> Projets récents</p><h2>La créativité <span>en vrai.</span></h2></div>
            <p>Des idées singulières, transformées en réalisations uniques.</p>
        </div>

        <div class="home-project-grid">
            <?php foreach ($featuredProjects as $index => $project): ?>
            <a href="<?= url('/realisations/' . escapeHtml($project['slug'])) ?>" class="home-project-card project-card fade-in fade-in-delay-<?= $index + 1 ?>" data-category="<?= (int) $project['category_id'] ?>">
                <div class="home-project-image">
                    <img src="<?= getImageUrl($project['cover_image']) ?>" alt="<?= escapeHtml($project['title']) ?>" class="project-image" loading="lazy">
                    <span class="home-project-arrow" aria-hidden="true"><i data-lucide="arrow-up-right"></i></span>
                </div>
                <div class="home-project-caption">
                    <div><span class="home-project-category"><?= escapeHtml($project['category_name'] ?? '') ?></span>
                    <h3><?= escapeHtml($project['title']) ?></h3></div>
                    <?php if (!empty($project['short_description'])): ?>
                    <p><?= escapeHtml($project['short_description']) ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="home-centered-action fade-in">
            <a href="<?= url('/realisations') ?>" class="home-text-link">Voir toutes les réalisations <i data-lucide="arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="home-before-after home-section" data-section-reveal>
    <div class="home-shell">
        <div class="home-section-heading home-section-heading-centered fade-in">
            <div><h2>La transformation,<br><span>en un coup d’œil.</span></h2></div>
            <p>Faites glisser le curseur pour comparer les images avant et après la personnalisation.</p>
        </div>

        <div class="home-comparison fade-in">
            <div class="before-after-container" role="group" aria-label="Comparaison avant et après">
                <div class="before-after-after">
                    <img src="<?= asset('images/after-placeholder.svg') ?>" alt="Exemple d’habillage personnalisé NexSkin" loading="lazy">
                </div>
                <div class="before-after-before">
                    <img src="<?= asset('images/before-placeholder.svg') ?>" alt="Ordinateur avant personnalisation" loading="lazy">
                </div>
                <button type="button" class="before-after-slider" style="left: 50%;" role="slider" tabindex="0" aria-label="Comparer les images avant et après" aria-orientation="horizontal" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50"></button>
            </div>
        </div>
    </div>
</section>

<section class="home-services home-section" data-section-reveal>
    <div class="home-shell">
        <div class="home-section-heading fade-in">
            <div><p class="home-eyebrow"><span></span> Notre savoir-faire</p><h2>Un résultat soigné,<br><span>à chaque étape.</span></h2></div>
            <p>Du premier croquis à la pose finale, nous donnons vie à votre idée avec précision et attention.</p>
        </div>

        <div class="home-service-grid">
            <?php
            $services = [
                ['icon' => 'layers', 'title' => 'Habillage personnalisé', 'desc' => 'Donnez une nouvelle identité à votre ordinateur.'],
                ['icon' => 'pen-tool', 'title' => 'Design sur mesure', 'desc' => 'Nous créons un visuel selon vos goûts.'],
                ['icon' => 'printer', 'title' => 'Impression & préparation', 'desc' => 'Préparation du design pour un rendu propre.'],
                ['icon' => 'hand', 'title' => 'Pose du skin', 'desc' => 'Application précise de l\'habillage.'],
                ['icon' => 'lightbulb', 'title' => 'Projet personnalisé', 'desc' => 'Vous avez une idée particulière ? Parlons-en.'],
            ];
            foreach ($services as $index => $service): ?>
            <article class="home-service-card service-card fade-in fade-in-delay-<?= ($index % 3) + 1 ?>">
                <div class="home-service-icon">
                    <i data-lucide="<?= escapeHtml($service['icon']) ?>" aria-hidden="true"></i>
                </div>
                <span class="home-service-number">0<?= $index + 1 ?></span>
                <h3><?= escapeHtml($service['title']) ?></h3>
                <p><?= escapeHtml($service['desc']) ?></p>
                <span class="home-service-detail" aria-hidden="true"><i data-lucide="arrow-up-right"></i></span>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="home-services-link fade-in">
            <p>Un besoin particulier ? Nous adaptons chaque projet à votre appareil.</p>
            <a href="<?= url('/services') ?>">Découvrir tous nos services <i data-lucide="arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<section class="home-process home-section" data-section-reveal>
    <div class="home-shell">
        <div class="home-section-heading home-section-heading-centered fade-in">
            <div><h2>Un parcours clair,<br><span>du premier échange à la pose.</span></h2></div>
            <p>Vous savez ce qui se passe à chaque étape et validez le design avant sa réalisation.</p>
        </div>

        <div class="home-process-grid">
            <?php
            $steps = [
                ['num' => '01', 'title' => 'Votre idée', 'desc' => 'Vous partagez votre modèle, vos envies et vos inspirations.'],
                ['num' => '02', 'title' => 'Conception', 'desc' => 'Nous créons ou adaptons un visuel à votre style.'],
                ['num' => '03', 'title' => 'Votre validation', 'desc' => 'Vous validez le rendu avant le lancement de la réalisation.'],
                ['num' => '04', 'title' => 'Pose finale', 'desc' => 'Nous appliquons votre habillage avec soin et précision.'],
            ];
            foreach ($steps as $index => $step): ?>
            <article class="home-process-step process-step fade-in fade-in-delay-<?= $index + 1 ?>">
                <span class="home-process-number" aria-hidden="true"><?= escapeHtml($step['num']) ?></span>
                <h3><?= escapeHtml($step['title']) ?></h3>
                <p><?= escapeHtml($step['desc']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-cta home-section" data-section-reveal>
    <div class="home-shell">
        <div class="home-cta-inner fade-in">
            <div class="home-cta-main">
                <p class="home-eyebrow home-eyebrow-light"><span></span> À vous de jouer</p>
                <h2>Votre prochain design<br>commence <em>ici.</em></h2>
            </div>
            <div class="home-cta-aside">
                <p>Décrivez-nous votre ordinateur et l’idée que vous souhaitez lui donner. Nous vous aiderons à définir la suite.</p>
                <div class="home-cta-actions">
                    <a href="<?= url('/contact') ?>" class="home-button home-button-light">Parlons de votre projet <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                    <a href="<?= url('/services') ?>" class="home-cta-secondary">Découvrir nos services <i data-lucide="arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
