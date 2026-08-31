<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-nex-dark">Réalisations</h1>
        <p class="text-sm text-nex-gray-light mt-1"><?= $pagination['total'] ?> réalisation(s) au total</p>
    </div>
    <a href="<?= url('/admin/projects/create') ?>" class="inline-flex items-center gap-2 bg-nex-blue hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Ajouter
    </a>
</div>

<?php if (empty($projects)): ?>
<div class="bg-white rounded-xl border border-nex-border p-12 text-center">
    <i data-lucide="image" class="w-12 h-12 text-nex-border mx-auto mb-3"></i>
    <h3 class="text-lg font-semibold text-nex-dark mb-1">Aucune réalisation</h3>
    <p class="text-sm text-nex-gray-light mb-4">Commencez par ajouter votre première réalisation.</p>
    <a href="<?= url('/admin/projects/create') ?>" class="inline-flex items-center gap-2 bg-nex-blue hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Ajouter une réalisation
    </a>
</div>
<?php else: ?>
<div class="bg-white rounded-xl border border-nex-border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td>
                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                            <?php if ($project['cover_image']): ?>
                            <img src="<?= getImageUrl($project['cover_image']) ?>" alt="" class="w-full h-full object-cover">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <p class="font-medium text-nex-dark"><?= escapeHtml($project['title']) ?></p>
                            <?php if ($project['featured']): ?>
                            <span class="text-xs text-yellow-600">★ À la une</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="text-sm text-nex-gray"><?= escapeHtml($project['category_name'] ?? '—') ?></span>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= statusColor($project['status']) ?>">
                            <?= statusLabel($project['status']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="text-sm text-nex-gray-light">
                            <?= $project['project_date'] ? formatDate($project['project_date']) : '—' ?>
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= url('/admin/projects/edit/' . $project['id']) ?>" class="p-2 text-nex-gray hover:text-nex-blue transition-colors" title="Modifier">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="<?= url('/admin/projects/delete/' . $project['id']) ?>" onsubmit="return confirm('Supprimer cette réalisation ?')">
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
</div>

<!-- Pagination -->
<?php if ($pagination['total_pages'] > 1): ?>
<div class="flex justify-center gap-2 mt-6">
    <?php if ($pagination['current_page'] > 1): ?>
    <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="px-3 py-1.5 rounded-lg border border-nex-border text-sm text-nex-gray hover:border-nex-blue hover:text-nex-blue">←</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
    <a href="?page=<?= $i ?>" class="px-3 py-1.5 rounded-lg text-sm <?= $i === $pagination['current_page'] ? 'bg-nex-blue text-white' : 'border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
    <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="px-3 py-1.5 rounded-lg border border-nex-border text-sm text-nex-gray hover:border-nex-blue hover:text-nex-blue">→</a>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>


