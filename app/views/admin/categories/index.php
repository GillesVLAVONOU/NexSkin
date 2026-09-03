<div class="flex flex-wrap items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-nex-dark">Catégories</h1>
        <p class="text-sm text-nex-gray-light mt-1"><?= count($categories) ?> catégorie(s)</p>
    </div>
    <button type="button" onclick="document.getElementById('add-category-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-nex-blue hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Ajouter
    </button>
</div>

<div class="bg-white rounded-xl border border-nex-border overflow-hidden">
    <div class="admin-table-wrapper">
        <table class="admin-table admin-table--categories">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Projets</th>
                    <th>Ordre</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td>
                        <div>
                            <p class="font-medium text-nex-dark"><?= escapeHtml($category['name']) ?></p>
                            <?php if (!empty($category['description'])): ?>
                            <p class="text-xs text-nex-gray-light mt-0.5"><?= escapeHtml(truncate($category['description'], 60)) ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded"><?= escapeHtml($category['slug']) ?></code></td>
                    <td><span class="text-sm text-nex-gray"><?= (int) ($category['project_count'] ?? 0) ?></span></td>
                    <td><span class="text-sm text-nex-gray"><?= (int) $category['sort_order'] ?></span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" onclick='openEditModal(<?= json_encode($category, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) ?>)' class="p-2 text-nex-gray hover:text-nex-blue transition-colors" title="Modifier">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </button>
                            <form method="POST" action="<?= url('/admin/categories/delete/' . $category['id']) ?>" onsubmit="return confirm('Supprimer cette catégorie ? Les projets associés seront dissociés.')">
                                <?= \App\Core\Request::csrfField() ?>
                                <button type="submit" class="p-2 text-nex-gray hover:text-red-600 transition-colors" title="Supprimer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="admin-table-scrollbar" aria-hidden="true"><div></div></div>
</div>

<div id="add-category-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="admin-modal-panel bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-nex-dark">Ajouter une catégorie</h2>
            <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="text-nex-gray hover:text-nex-dark" aria-label="Fermer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form method="POST" action="<?= url('/admin/categories') ?>" class="space-y-4">
            <?= \App\Core\Request::csrfField() ?>
            <div>
                <label for="cat-name" class="form-label">Nom *</label>
                <input type="text" id="cat-name" name="name" required class="form-input" placeholder="Ex: Minimaliste">
            </div>
            <div>
                <label for="cat-desc" class="form-label">Description</label>
                <textarea id="cat-desc" name="description" rows="2" class="form-input resize-none" placeholder="Optionnel"></textarea>
            </div>
            <div>
                <label for="cat-order" class="form-label">Ordre d'affichage</label>
                <input type="number" id="cat-order" name="sort_order" value="0" class="form-input" min="0">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="flex-1 px-4 py-2.5 border border-nex-border rounded-lg text-sm font-medium text-nex-gray hover:bg-gray-50 transition-colors">Annuler</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-nex-blue hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">Créer</button>
            </div>
        </form>
    </div>
</div>

<div id="edit-category-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="admin-modal-panel bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-nex-dark">Modifier la catégorie</h2>
            <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="text-nex-gray hover:text-nex-dark" aria-label="Fermer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="edit-category-form" method="POST" class="space-y-4">
            <?= \App\Core\Request::csrfField() ?>
            <div>
                <label for="edit-cat-name" class="form-label">Nom *</label>
                <input type="text" id="edit-cat-name" name="name" required class="form-input">
            </div>
            <div>
                <label for="edit-cat-desc" class="form-label">Description</label>
                <textarea id="edit-cat-desc" name="description" rows="2" class="form-input resize-none"></textarea>
            </div>
            <div>
                <label for="edit-cat-order" class="form-label">Ordre d'affichage</label>
                <input type="number" id="edit-cat-order" name="sort_order" class="form-input" min="0">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="flex-1 px-4 py-2.5 border border-nex-border rounded-lg text-sm font-medium text-nex-gray hover:bg-gray-50 transition-colors">Annuler</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-nex-blue hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(category) {
    document.getElementById('edit-category-form').action = "<?= url('/admin/categories/update') ?>/" + category.id;
    document.getElementById('edit-cat-name').value = category.name || '';
    document.getElementById('edit-cat-desc').value = category.description || '';
    document.getElementById('edit-cat-order').value = category.sort_order || 0;
    document.getElementById('edit-category-modal').classList.remove('hidden');
}
</script>
