<div class="mb-8">
    <h1 class="text-2xl font-bold text-nex-dark">Messages</h1>
    <p class="text-sm text-nex-gray-light mt-1">Demandes de personnalisation reçues</p>
</div>

<!-- Status Tabs -->
<div class="flex flex-wrap gap-2 mb-6">
    <a href="<?= url('/admin/messages') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= $currentStatus === '' ? 'bg-nex-blue text-white' : 'bg-white border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>">
        Tous (<?= array_sum($statusCounts) ?>)
    </a>
    <a href="<?= url('/admin/messages?status=new') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= $currentStatus === 'new' ? 'bg-nex-blue text-white' : 'bg-white border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>">
        Nouveaux (<?= $statusCounts['new'] ?>)
    </a>
    <a href="<?= url('/admin/messages?status=in_progress') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= $currentStatus === 'in_progress' ? 'bg-nex-blue text-white' : 'bg-white border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>">
        En cours (<?= $statusCounts['in_progress'] ?>)
    </a>
    <a href="<?= url('/admin/messages?status=processed') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= $currentStatus === 'processed' ? 'bg-nex-blue text-white' : 'bg-white border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>">
        Traités (<?= $statusCounts['processed'] ?>)
    </a>
    <a href="<?= url('/admin/messages?status=archived') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= $currentStatus === 'archived' ? 'bg-nex-blue text-white' : 'bg-white border border-nex-border text-nex-gray hover:border-nex-blue hover:text-nex-blue' ?>">
        Archivés (<?= $statusCounts['archived'] ?>)
    </a>
</div>

<?php if (empty($messages)): ?>
<div class="bg-white rounded-xl border border-nex-border p-12 text-center">
    <i data-lucide="mail" class="w-12 h-12 text-nex-border mx-auto mb-3"></i>
    <h3 class="text-lg font-semibold text-nex-dark mb-1">Aucun message</h3>
    <p class="text-sm text-nex-gray-light">Pas de message pour ce filtre.</p>
</div>
<?php else: ?>
<div class="space-y-4">
    <?php foreach ($messages as $message): ?>
    <div class="bg-white rounded-xl border border-nex-border p-6" id="message-<?= $message['id'] ?>">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-nex-blue-pale rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-sm font-semibold text-nex-blue">
                        <?= strtoupper(substr($message['first_name'], 0, 1) . substr($message['last_name'], 0, 1)) ?>
                    </span>
                </div>
                <div>
                    <p class="font-semibold text-nex-dark"><?= escapeHtml($message['first_name'] . ' ' . $message['last_name']) ?></p>
                    <p class="text-xs text-nex-gray-light"><?= timeAgo($message['created_at']) ?></p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= statusColor($message['status']) ?> self-start">
                <?= statusLabel($message['status']) ?>
            </span>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 mb-4 text-sm">
            <div>
                <span class="text-nex-gray-light">Email:</span>
                <a href="mailto:<?= escapeHtml($message['email']) ?>" class="text-nex-blue hover:underline ml-1"><?= escapeHtml($message['email']) ?></a>
            </div>
            <?php if ($message['phone']): ?>
            <div>
                <span class="text-nex-gray-light">Téléphone:</span>
                <a href="tel:<?= escapeHtml($message['phone']) ?>" class="text-nex-blue hover:underline ml-1"><?= escapeHtml($message['phone']) ?></a>
            </div>
            <?php endif; ?>
            <?php if ($message['project_type']): ?>
            <div>
                <span class="text-nex-gray-light">Type:</span>
                <span class="ml-1"><?= escapeHtml($message['project_type']) ?></span>
            </div>
            <?php endif; ?>
            <?php if ($message['device_model']): ?>
            <div>
                <span class="text-nex-gray-light">Modèle:</span>
                <span class="ml-1"><?= escapeHtml($message['device_model']) ?></span>
            </div>
            <?php endif; ?>
            <?php if ($message['budget']): ?>
            <div>
                <span class="text-nex-gray-light">Budget:</span>
                <span class="ml-1"><?= escapeHtml($message['budget']) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <div class="bg-nex-bg rounded-lg p-4 mb-4">
            <p class="text-sm text-nex-dark leading-relaxed"><?= nl2brHtml($message['message']) ?></p>
        </div>

        <?php if ($message['reference_image']): ?>
        <div class="mb-4">
            <p class="text-xs text-nex-gray-light mb-2">Image de référence:</p>
            <img src="<?= getImageUrl($message['reference_image']) ?>" alt="Référence" class="max-h-48 rounded-lg border border-nex-border">
        </div>
        <?php endif; ?>

        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-nex-border">
            <span class="text-xs text-nex-gray-light mr-2">Changer le statut:</span>
            <?php
            $statuses = ['new' => 'Nouveau', 'in_progress' => 'En cours', 'processed' => 'Traité', 'archived' => 'Archivé'];
            foreach ($statuses as $key => $label):
                if ($key === $message['status']) continue;
            ?>
            <form method="POST" action="<?= url('/admin/messages/status/' . $message['id']) ?>" class="inline">
                <?= \App\Core\Request::csrfField() ?>
                <input type="hidden" name="status" value="<?= $key ?>">
                <button type="submit" class="px-3 py-1 text-xs font-medium border border-nex-border rounded-full text-nex-gray hover:border-nex-blue hover:text-nex-blue transition-colors">
                    <?= $label ?>
                </button>
            </form>
            <?php endforeach; ?>

            <form method="POST" action="<?= url('/admin/messages/delete/' . $message['id']) ?>" class="inline ml-auto" onsubmit="return confirm('Supprimer ce message ?')">
                <?= \App\Core\Request::csrfField() ?>
                <button type="submit" class="px-3 py-1 text-xs font-medium text-red-500 hover:text-red-700 transition-colors">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>


