<div class="mb-8">
    <h1 class="text-2xl font-bold text-nex-dark">Paramètres</h1>
    <p class="text-sm text-nex-gray-light mt-1">Configuration générale du site</p>
</div>

<form method="POST" action="<?= url('/admin/settings') ?>" class="space-y-8">
    <?= \App\Core\Request::csrfField() ?>

    <!-- Company Info -->
    <div class="bg-white rounded-xl border border-nex-border p-6">
        <h2 class="font-semibold text-nex-dark mb-4">Informations de l'entreprise</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Nom de l'entreprise</label>
                <input type="text" name="company_name" value="<?= escapeHtml($settings['company_name'] ?? '') ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Slogan</label>
                <input type="text" name="slogan" value="<?= escapeHtml($settings['slogan'] ?? '') ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Email public</label>
                <input type="email" name="email" value="<?= escapeHtml($settings['email'] ?? '') ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Email de notification</label>
                <input type="email" name="contact_notification_email" value="<?= escapeHtml($settings['contact_notification_email'] ?? ($settings['email'] ?? '')) ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Téléphone</label>
                <input type="text" name="phone" value="<?= escapeHtml($settings['phone'] ?? '') ?>" class="form-input" placeholder="+221 7X XXX XX XX">
            </div>
            <div class="sm:col-span-2">
                <label class="form-label">Adresse</label>
                <input type="text" name="address" value="<?= escapeHtml($settings['address'] ?? '') ?>" class="form-input">
            </div>
            <div class="sm:col-span-2">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-input resize-none"><?= escapeHtml($settings['description'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div class="bg-white rounded-xl border border-nex-border p-6">
        <h2 class="font-semibold text-nex-dark mb-4">Réseaux sociaux</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">WhatsApp (numéro international)</label>
                <input type="text" name="whatsapp" value="<?= escapeHtml($settings['whatsapp'] ?? '') ?>" class="form-input" placeholder="2217XXXXXXXX">
                <p class="text-xs text-nex-gray-light mt-1">Format: code pays + numéro sans espaces ni +</p>
            </div>
            <div>
                <label class="form-label">Instagram</label>
                <input type="url" name="instagram" value="<?= escapeHtml($settings['instagram'] ?? '') ?>" class="form-input" placeholder="https://instagram.com/nexskin">
            </div>
            <div>
                <label class="form-label">Facebook</label>
                <input type="url" name="facebook" value="<?= escapeHtml($settings['facebook'] ?? '') ?>" class="form-input" placeholder="https://facebook.com/nexskin">
            </div>
            <div>
                <label class="form-label">TikTok</label>
                <input type="url" name="tiktok" value="<?= escapeHtml($settings['tiktok'] ?? '') ?>" class="form-input" placeholder="https://tiktok.com/@nexskin">
            </div>
        </div>
    </div>

    <!-- SEO -->
    <div class="bg-white rounded-xl border border-nex-border p-6">
        <h2 class="font-semibold text-nex-dark mb-4">SEO</h2>
        <div class="space-y-4">
            <div>
                <label class="form-label">Meta description</label>
                <textarea name="meta_description" rows="2" class="form-input resize-none" data-maxlength="160" data-counter="seo-counter"><?= escapeHtml($settings['meta_description'] ?? '') ?></textarea>
                <p id="seo-counter" class="text-xs text-nex-gray-light mt-1">160 caractères restants</p>
            </div>
            <div>
                <label class="form-label">Titre Hero (page d'accueil)</label>
                <input type="text" name="hero_title" value="<?= escapeHtml($settings['hero_title'] ?? '') ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Sous-titre Hero (page d'accueil)</label>
                <textarea name="hero_subtitle" rows="2" class="form-input resize-none"><?= escapeHtml($settings['hero_subtitle'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-nex-blue hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors">
            Enregistrer les paramètres
        </button>
    </div>
</form>


