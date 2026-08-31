<div class="mb-8">
    <h1 class="text-2xl font-bold text-nex-dark">Dashboard</h1>
    <p class="text-sm text-nex-gray-light mt-1">Vue d'ensemble de votre activité</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-xl border border-nex-border">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-nex-blue-pale rounded-lg flex items-center justify-center">
                <i data-lucide="image" class="w-5 h-5 text-nex-blue"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-nex-dark"><?= $stats['total_projects'] ?></p>
                <p class="text-xs text-nex-gray-light">Réalisations</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-nex-border">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-nex-dark"><?= $stats['published_projects'] ?></p>
                <p class="text-xs text-nex-gray-light">Publiés</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-nex-border">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i data-lucide="tag" class="w-5 h-5 text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-nex-dark"><?= $stats['total_categories'] ?></p>
                <p class="text-xs text-nex-gray-light">Catégories</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-nex-border">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i data-lucide="mail" class="w-5 h-5 text-red-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-nex-dark"><?= $stats['message_counts']['new'] ?></p>
                <p class="text-xs text-nex-gray-light">Nouveaux messages</p>
            </div>
        </div>
    </div>
</div>

<!-- Message Status Breakdown -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <?php
    $statusColors = [
        'new' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'inbox'],
        'in_progress' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'icon' => 'clock'],
        'processed' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'icon' => 'check'],
        'archived' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'icon' => 'archive'],
    ];
    $statusLabels = ['new' => 'Nouveaux', 'in_progress' => 'En cours', 'processed' => 'Traités', 'archived' => 'Archivés'];
    foreach ($statusLabels as $key => $label): ?>
    <div class="<?= $statusColors[$key]['bg'] ?> p-4 rounded-xl">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium <?= $statusColors[$key]['text'] ?>"><?= $label ?></span>
            <span class="text-xl font-bold <?= $statusColors[$key]['text'] ?>"><?= $stats['message_counts'][$key] ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <!-- Recent Projects -->
    <div class="bg-white rounded-xl border border-nex-border">
        <div class="flex items-center justify-between px-5 py-4 border-b border-nex-border">
            <h2 class="font-semibold text-nex-dark">Dernières réalisations</h2>
            <a href="<?= url('/admin/projects') ?>" class="text-sm text-nex-blue hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-nex-border">
            <?php if (empty($recentProjects)): ?>
            <p class="px-5 py-4 text-sm text-nex-gray-light">Aucune réalisation.</p>
            <?php else: ?>
            <?php foreach ($recentProjects as $project): ?>
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                    <?php if ($project['cover_image']): ?>
                    <img src="<?= getImageUrl($project['cover_image']) ?>" alt="" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i data-lucide="image" class="w-4 h-4"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-nex-dark truncate"><?= escapeHtml($project['title']) ?></p>
                    <p class="text-xs text-nex-gray-light"><?= $project['category_name'] ?? '—' ?></p>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= statusColor($project['status']) ?>">
                    <?= statusLabel($project['status']) ?>
                </span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="bg-white rounded-xl border border-nex-border">
        <div class="flex items-center justify-between px-5 py-4 border-b border-nex-border">
            <h2 class="font-semibold text-nex-dark">Dernières demandes</h2>
            <a href="<?= url('/admin/messages') ?>" class="text-sm text-nex-blue hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-nex-border">
            <?php if (empty($recentMessages)): ?>
            <p class="px-5 py-4 text-sm text-nex-gray-light">Aucun message.</p>
            <?php else: ?>
            <?php foreach ($recentMessages as $message): ?>
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="w-10 h-10 bg-nex-blue-pale rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-sm font-semibold text-nex-blue">
                        <?= strtoupper(substr($message['first_name'], 0, 1)) ?>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-nex-dark truncate">
                        <?= escapeHtml($message['first_name'] . ' ' . $message['last_name']) ?>
                    </p>
                    <p class="text-xs text-nex-gray-light truncate"><?= escapeHtml($message['email']) ?></p>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= statusColor($message['status']) ?>">
                    <?= statusLabel($message['status']) ?>
                </span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

