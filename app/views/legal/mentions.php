<section class="pt-28 pb-16 lg:pt-36 lg:pb-24 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-sm font-semibold text-nex-blue uppercase tracking-wide mb-3">Informations legales</p>
        <h1 class="text-4xl lg:text-5xl font-bold text-nex-dark mb-6">Mentions legales</h1>
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
