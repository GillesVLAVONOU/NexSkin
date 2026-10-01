<section class="legal-page">
    <div class="interior-reading-shell legal-content">
        <p class="legal-kicker">Informations légales</p>
        <h1>Mentions légales</h1>
        <div class="prose prose-slate max-w-none text-nex-gray leading-relaxed">
            <p>Cette page contient des informations provisoires a completer avec les donnees legales reelles de NexSkin avant la mise en production.</p>
            <h2>Editeur du site</h2>
            <p>
                <?= escapeHtml($settings['company_name'] ?? 'NexSkin') ?><br>
                Email : <?= escapeHtml($settings['email'] ?? 'contact@nexskin.com') ?><br>
                Telephone : <?= escapeHtml($settings['phone'] ?? '') ?>
            </p>
            <h2>Hebergement</h2>
            <p>Informations sur l'hebergeur a completer avant publication.</p>
            <h2>Propriete intellectuelle</h2>
            <p>Les textes, visuels, logos et realisations presentes sur ce site sont proteges. Toute reproduction necessite une autorisation prealable.</p>
        </div>
    </div>
</section>
