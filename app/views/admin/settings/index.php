<div class="mb-8">
    <h1 class="text-2xl font-bold text-nex-dark">Paramètres</h1>
    <p class="text-sm text-nex-gray-light mt-1">Configuration générale du site</p>
</div>

<?php if (!empty($success)): ?>
<div role="status" class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"><?= escapeHtml($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"><?= escapeHtml($error) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/admin/settings') ?>" enctype="multipart/form-data" class="space-y-8">
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

    <div class="bg-white rounded-xl border border-nex-border p-6">
        <h2 class="font-semibold text-nex-dark mb-2">Carrousel de la page d’accueil</h2>
        <p class="text-sm text-nex-gray-light mb-5">Ajoutez jusqu’à 8 images. Formats acceptés : JPG, PNG et WebP, 5 Mo maximum par image.</p>
        <?php
        $heroImages = json_decode($settings['hero_images'] ?? '[]', true);
        $heroImages = is_array($heroImages) ? $heroImages : [];
        ?>
        <?php if ($heroImages): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-5">
            <?php foreach ($heroImages as $index => $heroImage): ?>
            <label class="group relative overflow-hidden rounded-xl border border-nex-border cursor-pointer">
                <img src="<?= getImageUrl($heroImage) ?>" alt="Image <?= $index + 1 ?> du carrousel" class="h-32 w-full object-cover">
                <span class="flex items-center gap-2 p-2 text-xs text-nex-gray">
                    <input type="checkbox" name="remove_hero_images[]" value="<?= (int) $index ?>" class="rounded border-nex-border text-nex-blue focus:ring-nex-blue">
                    Retirer du carrousel
                </span>
            </label>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-sm text-nex-gray mb-5">Aucune image ajoutée. Le visuel actuel reste utilisé tant que le carrousel est vide.</p>
        <?php endif; ?>
        <label for="hero_images" class="form-label">Ajouter des images</label>
        <input id="hero_images" type="file" name="hero_images[]" accept="image/jpeg,image/png,image/webp" multiple class="form-input">
        <p id="hero-images-status" class="mt-2 text-xs text-nex-gray-light" aria-live="polite"></p>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-nex-blue hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors">
            Enregistrer les paramètres
        </button>
    </div>
</form>


