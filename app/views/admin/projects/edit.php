<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-nex-dark">Modifier : <?= escapeHtml($project['title']) ?></h1>
        <p class="text-sm text-nex-gray-light mt-1">Modifier les informations de cette réalisation</p>
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

<form method="POST" action="<?= url('/admin/projects/update/' . $project['id']) ?>" enctype="multipart/form-data" class="space-y-8">
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
                               value="<?= escapeHtml($project['title']) ?>"
                               class="form-input">
                    </div>
                    <div>
                        <label for="short_description" class="form-label">Description courte</label>
                        <textarea id="short_description" name="short_description" rows="2"
                                  class="form-input resize-none"
                                  data-maxlength="500" data-counter="desc-counter"><?= escapeHtml($project['short_description'] ?? '') ?></textarea>
                        <p id="desc-counter" class="text-xs text-nex-gray-light mt-1">500 caractères restants</p>
                    </div>
                    <div>
                        <label for="description" class="form-label">Description complète</label>
                        <textarea id="description" name="description" rows="8"
                                  class="form-input resize-none"><?= escapeHtml($project['description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Image principale</h2>
                <?php if ($project['cover_image']): ?>
                <div class="mb-4">
                    <img src="<?= getImageUrl($project['cover_image']) ?>" alt="" class="max-h-48 rounded-lg">
                </div>
                <?php endif; ?>
                <div class="file-upload-area" onclick="document.getElementById('cover_image').click()">
                    <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden">
                    <i data-lucide="upload-cloud" class="w-8 h-8 text-nex-gray-light mx-auto mb-2"></i>
                    <p class="text-sm text-nex-gray">Remplacer l'image</p>
                </div>
                <img id="cover-preview" class="mt-4 hidden max-h-48 rounded-lg">
            </div>

            <!-- Before / After -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Avant / Après</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Image avant</label>
                        <?php if ($project['before_image']): ?>
                        <img src="<?= getImageUrl($project['before_image']) ?>" alt="" class="h-24 rounded-lg mb-2">
                        <?php endif; ?>
                        <div class="file-upload-area" onclick="document.getElementById('before_image').click()">
                            <input type="file" id="before_image" name="before_image" accept="image/*" class="hidden">
                            <p class="text-xs text-nex-gray">Photo avant</p>
                        </div>
                        <img id="before-preview" class="mt-2 hidden h-32 rounded-lg">
                    </div>
                    <div>
                        <label class="form-label">Image après</label>
                        <?php if ($project['after_image']): ?>
                        <img src="<?= getImageUrl($project['after_image']) ?>" alt="" class="h-24 rounded-lg mb-2">
                        <?php endif; ?>
                        <div class="file-upload-area" onclick="document.getElementById('after_image').click()">
                            <input type="file" id="after_image" name="after_image" accept="image/*" class="hidden">
                            <p class="text-xs text-nex-gray">Photo après</p>
                        </div>
                        <img id="after-preview" class="mt-2 hidden h-32 rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Existing Gallery -->
            <?php if (!empty($project['images'])): ?>
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Galerie existante</h2>
                <div class="flex flex-wrap gap-3">
                    <?php foreach ($project['images'] as $image): ?>
                    <div class="relative group">
                        <img src="<?= getImageUrl($image['image_path']) ?>" alt="" class="w-24 h-24 object-cover rounded-lg">
                        <label class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <input type="checkbox" name="delete_images[]" value="<?= $image['id'] ?>" class="sr-only peer">
                            <span class="flex items-center justify-center w-5 h-5 bg-red-500 text-white rounded-full text-xs cursor-pointer peer-checked:bg-red-700">✕</span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-xs text-nex-gray-light mt-2">Survolez puis cliquez ✕ pour supprimer</p>
            </div>
            <?php endif; ?>

            <!-- Add Gallery Images -->
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Ajouter des images à la galerie</h2>
                <div class="file-upload-area" onclick="document.getElementById('gallery_images').click()">
                    <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple class="hidden">
                    <i data-lucide="images" class="w-8 h-8 text-nex-gray-light mx-auto mb-2"></i>
                    <p class="text-sm text-nex-gray">Sélectionnez plusieurs images</p>
                </div>
                <div id="gallery-preview" class="flex flex-wrap gap-3 mt-4"></div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Publication</h2>
                <div class="space-y-4">
                    <div>
                        <label for="status" class="form-label">Statut</label>
                        <select id="status" name="status" class="form-input">
                            <option value="draft" <?= $project['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="published" <?= $project['status'] === 'published' ? 'selected' : '' ?>>Publié</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="featured" name="featured" value="1"
                               <?= $project['featured'] ? 'checked' : '' ?>
                               class="w-4 h-4 rounded border-gray-300 text-nex-blue focus:ring-nex-blue">
                        <label for="featured" class="text-sm text-nex-gray">À la une</label>
                    </div>
                    <div>
                        <label for="project_date" class="form-label">Date du projet</label>
                        <input type="date" id="project_date" name="project_date"
                               value="<?= escapeHtml($project['project_date'] ?? '') ?>"
                               class="form-input">
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Ordre d'affichage</label>
                        <input type="number" id="sort_order" name="sort_order"
                               value="<?= $project['sort_order'] ?>"
                               class="form-input" min="0">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-nex-border p-6">
                <h2 class="font-semibold text-nex-dark mb-4">Catégorie</h2>
                <select name="category_id" class="form-input" required>
                    <option value="">Sélectionnez</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $project['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= escapeHtml($category['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-nex-blue hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                Enregistrer les modifications
            </button>

            <form method="POST" action="<?= url('/admin/projects/delete/' . $project['id']) ?>" onsubmit="return confirm('Supprimer définitivement cette réalisation ?')">
                <?= \App\Core\Request::csrfField() ?>
                <button type="submit" class="w-full bg-white border border-red-200 text-red-600 hover:bg-red-50 font-semibold py-3 rounded-lg transition-colors">
                    Supprimer cette réalisation
                </button>
            </form>
        </div>
    </div>
</form>

<script>
document.querySelectorAll('input[type="file"]').forEach(input => {
    if (!input.name.includes('gallery')) {
        input.addEventListener('change', function() {
            const previewId = this.id + '-preview';
            const preview = document.getElementById(previewId);
            if (!preview || !this.files[0]) return;
            const reader = new FileReader();
            reader.onload = (e) => { preview.src = e.target.result; preview.classList.remove('hidden'); };
            reader.readAsDataURL(this.files[0]);
        });
    }
});
</script>


