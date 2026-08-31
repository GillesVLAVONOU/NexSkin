<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-nex-dark">Ajouter une réalisation</h1>
        <p class="text-sm text-nex-gray-light mt-1">Créez un nouveau projet de personnalisation</p>
    </div>
    <a href="<?= url('/admin/projects') ?>" class="text-sm text-nex-gray hover:text-nex-blue transition-colors">
        ← Retour à la liste
    </a>
</div>

<?php if (!empty($errors)): ?>
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
    <ul class="list-disc list-inside">
        <?php foreach ($errors as $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="<?= url('/admin/projects') ?>" enctype="multipart/form-data" class="space-y-8">
    <?= \App\Core\Request::csrfField() ?>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Informations</h2>

                <div class="space-y-4">
                    <div>
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" id="title-input" name="title" required
                               value="<?= escapeHtml($old['title'] ?? '') ?>"
                               class="form-input" placeholder="Ex: World Explorer">
                    </div>

                    <div>
                        <label for="slug-input" class="form-label">Slug</label>
                        <input type="text" id="slug-input" name="slug"
                               value="<?= escapeHtml($old['slug'] ?? '') ?>"
                               class="form-input" placeholder="auto-généré">
                    </div>

                    <div>
                        <label for="short_description" class="form-label">Description courte</label>
                        <textarea id="short_description" name="short_description" rows="2"
                                  class="form-input resize-none"
                                  data-maxlength="500" data-counter="desc-counter"
                                  placeholder="Description en une phrase"><?= escapeHtml($old['short_description'] ?? '') ?></textarea>
                        <p id="desc-counter" class="text-xs text-nex-gray-light mt-1">500 caractères restants</p>
                    </div>

                    <div>
                        <label for="description" class="form-label">Description complète</label>
                        <textarea id="description" name="description" rows="8"
                                  class="form-input resize-none"
                                  placeholder="Détails du projet..."><?= escapeHtml($old['description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Image principale</h2>
                <div class="file-upload-area" onclick="document.getElementById('cover_image').click()">
                    <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden">
                    <i data-lucide="upload-cloud" class="w-8 h-8 text-nex-gray-light mx-auto mb-2"></i>
                    <p class="text-sm text-nex-gray">Cliquez ou glissez une image</p>
                    <p class="text-xs text-nex-gray-light mt-1">JPG, PNG, WebP — Max 5 Mo</p>
                </div>
                <img id="cover-preview" class="mt-4 hidden max-h-48 rounded-lg" alt="Aperçu de l’image principale">
                <p id="cover-status" class="mt-2 hidden text-xs text-green-700"></p>
            </div>

            <!-- Before / After -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Avant / Après</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Image avant</label>
                        <div class="file-upload-area" onclick="document.getElementById('before_image').click()">
                            <input type="file" id="before_image" name="before_image" accept="image/*" class="hidden">
                            <i data-lucide="image" class="w-6 h-6 text-nex-gray-light mx-auto mb-1"></i>
                            <p class="text-xs text-nex-gray">Photo avant</p>
                        </div>
                        <img id="before-preview" class="mt-2 hidden h-32 rounded-lg" alt="Aperçu de l’image avant">
                        <p id="before-status" class="mt-2 hidden text-xs text-green-700"></p>
                    </div>
                    <div>
                        <label class="form-label">Image après</label>
                        <div class="file-upload-area" onclick="document.getElementById('after_image').click()">
                            <input type="file" id="after_image" name="after_image" accept="image/*" class="hidden">
                            <i data-lucide="image" class="w-6 h-6 text-nex-gray-light mx-auto mb-1"></i>
                            <p class="text-xs text-nex-gray">Photo après</p>
                        </div>
                        <img id="after-preview" class="mt-2 hidden h-32 rounded-lg" alt="Aperçu de l’image après">
                        <p id="after-status" class="mt-2 hidden text-xs text-green-700"></p>
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Galerie</h2>
                <div class="file-upload-area" onclick="document.getElementById('gallery_images').click()">
                    <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple class="hidden">
                    <i data-lucide="images" class="w-8 h-8 text-nex-gray-light mx-auto mb-2"></i>
                    <p class="text-sm text-nex-gray">Sélectionnez plusieurs images</p>
                    <p class="text-xs text-nex-gray-light mt-1">Maintenez Ctrl/Cmd pour sélectionner plusieurs fichiers</p>
                </div>
                <div id="gallery-preview" class="flex flex-wrap gap-3 mt-4"></div>
                <p id="gallery-status" class="mt-2 hidden text-xs text-green-700"></p>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Publish -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Publication</h2>
                <div class="space-y-4">
                    <div>
                        <label for="status" class="form-label">Statut</label>
                        <select id="status" name="status" class="form-input">
                            <option value="draft" <?= ($old['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="published" <?= ($old['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publié</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="featured" name="featured" value="1"
                               <?= !empty($old['featured']) ? 'checked' : '' ?>
                               class="w-4 h-4 rounded border-gray-300 text-nex-blue focus:ring-nex-blue">
                        <label for="featured" class="text-sm text-nex-gray">À la une</label>
                    </div>
                    <div>
                        <label for="project_date" class="form-label">Date du projet</label>
                        <input type="date" id="project_date" name="project_date"
                               value="<?= escapeHtml($old['project_date'] ?? date('Y-m-d')) ?>"
                               class="form-input">
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Ordre d'affichage</label>
                        <input type="number" id="sort_order" name="sort_order"
                               value="<?= escapeHtml($old['sort_order'] ?? '0') ?>"
                               class="form-input" min="0">
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Catégorie</h2>
                <select name="category_id" class="form-input" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php foreach (($categories ?? []) as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= ($old['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                        <?= escapeHtml($category['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-nex-blue hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                Créer la réalisation
            </button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
        if (this.name.includes('gallery')) {
            const preview = document.getElementById('gallery-preview');
            const status = document.getElementById('gallery-status');
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const item = document.createElement('span');
                item.className = 'text-xs text-nex-gray bg-gray-100 rounded px-2 py-1';
                item.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' Ko)';
                preview.appendChild(item);
            });
            status.textContent = this.files.length + ' image(s) sélectionnée(s).';
            status.classList.remove('hidden');
            return;
        }

            const previewId = this.id + '-preview';
            const preview = document.getElementById(previewId);
            const status = document.getElementById(this.id.replace('_image', '') + '-status');
            if (!preview || !this.files[0]) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                status.textContent = this.files[0].name + ' (' + Math.round(this.files[0].size / 1024) + ' Ko) sélectionnée.';
                status.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        });
    });
});
</script>

