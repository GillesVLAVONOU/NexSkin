<!-- Hero -->
<section class="pt-32 pb-12 lg:pt-40 lg:pb-16 bg-gradient-to-b from-nex-blue-pale/30 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-nex-dark mb-4 fade-in">
            Contact
        </h1>
        <p class="text-nex-gray text-lg max-w-2xl mx-auto fade-in fade-in-delay-1">
            Parlons de votre idée.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-12 lg:gap-16">
            <!-- Form -->
            <div class="lg:col-span-3 fade-in">
                <div class="bg-white p-8 lg:p-10 rounded-2xl border border-nex-border shadow-sm">
                    <h2 class="text-2xl font-bold text-nex-dark mb-2">Envoyez-nous votre projet</h2>
                    <p class="text-nex-gray text-sm mb-8">
                        Vous avez déjà votre design ou simplement une idée ? Remplissez le formulaire ci-dessous.
                    </p>

                    <?php if ($success): ?>
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <?= escapeHtml($success) ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <p class="font-medium mb-2">Veuillez corriger les erreurs :</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            <?php foreach ($errors as $fieldErrors): ?>
                                <?php foreach ($fieldErrors as $error): ?>
                                    <li><?= escapeHtml($error) ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= url('/contact') ?>" enctype="multipart/form-data" class="space-y-6">
                        <?= \App\Core\Request::csrfField() ?>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="form-label">Prénom *</label>
                                <input type="text" id="first_name" name="first_name" required
                                       value="<?= escapeHtml($old['first_name'] ?? '') ?>"
                                       class="form-input" placeholder="Votre prénom">
                            </div>
                            <div>
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text" id="last_name" name="last_name" required
                                       value="<?= escapeHtml($old['last_name'] ?? '') ?>"
                                       class="form-input" placeholder="Votre nom">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" id="email" name="email" required
                                       value="<?= escapeHtml($old['email'] ?? '') ?>"
                                       class="form-input" placeholder="votre@email.com">
                            </div>
                            <div>
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" id="phone" name="phone"
                                       value="<?= escapeHtml($old['phone'] ?? '') ?>"
                                       class="form-input" placeholder="+221 7X XXX XX XX">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="project_type" class="form-label">Type de personnalisation</label>
                                <select id="project_type" name="project_type" class="form-input">
                                    <option value="">Sélectionnez</option>
                                    <option value="habillage" <?= ($old['project_type'] ?? '') === 'habillage' ? 'selected' : '' ?>>Habillage complet</option>
                                    <option value="design" <?= ($old['project_type'] ?? '') === 'design' ? 'selected' : '' ?>>Design sur mesure</option>
                                    <option value="partiel" <?= ($old['project_type'] ?? '') === 'partiel' ? 'selected' : '' ?>>Habillage partiel</option>
                                    <option value="autre" <?= ($old['project_type'] ?? '') === 'autre' ? 'selected' : '' ?>>Autre</option>
                                </select>
                            </div>
                            <div>
                                <label for="device_model" class="form-label">Modèle de l'ordinateur</label>
                                <input type="text" id="device_model" name="device_model"
                                       value="<?= escapeHtml($old['device_model'] ?? '') ?>"
                                       class="form-input" placeholder="ex: MacBook Pro 14&quot;">
                            </div>
                        </div>

                        <div>
                            <label for="budget" class="form-label">Budget indicatif</label>
                            <input type="text" id="budget" name="budget" readonly
                                   value="<?= escapeHtml($old['budget'] ?? '') ?>"
                                   class="form-input bg-gray-50" placeholder="Sélectionnez un type de personnalisation">
                        </div>

                        <div>
                            <label for="reference_image" class="form-label">Image de référence</label>
                            <input type="file" id="reference_image" name="reference_image" accept="image/*"
                                   class="form-input file-input">
                            <p class="text-xs text-nex-gray-light mt-1">JPG, PNG ou WebP — Max 5 Mo</p>
                        </div>

                        <div>
                            <label for="message" class="form-label">Description du projet *</label>
                            <textarea id="message" name="message" required rows="5"
                                      class="form-input resize-none"
                                      placeholder="Décrivez votre projet, votre idée, vos envies..."><?= escapeHtml($old['message'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-nex-blue hover:bg-blue-700 text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25">
                            Envoyer le projet
                            <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="lg:col-span-2 fade-in fade-in-delay-1">
                <div class="space-y-8">
                    <!-- WhatsApp -->
                    <div class="bg-white p-6 rounded-2xl border border-nex-border">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <img src="<?= asset('images/whatsapp.svg') ?>" alt="WhatsApp" class="w-7 h-7">
                            </div>
                            <div>
                                <h3 class="font-semibold text-nex-dark">WhatsApp</h3>
                                <p class="text-sm text-nex-gray">Réponse rapide</p>
                            </div>
                        </div>
                        <a href="https://wa.me/<?= escapeHtml($settings['whatsapp'] ?? '') ?>?text=<?= urlencode('Bonjour NexSkin, j\'aimerais personnaliser mon ordinateur.') ?>"
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium text-sm transition-colors">
                            Discuter de mon projet
                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>

                    <!-- Email -->
                    <div class="bg-white p-6 rounded-2xl border border-nex-border">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-nex-blue-pale rounded-xl flex items-center justify-center">
                                <i data-lucide="mail" class="w-6 h-6 text-nex-blue"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-nex-dark">Email</h3>
                                <p class="text-sm text-nex-gray">Réponse sous 24-48h</p>
                            </div>
                        </div>
                        <a href="mailto:<?= escapeHtml($settings['email'] ?? 'contact@nexskin.com') ?>"
                           class="text-nex-blue hover:text-blue-700 font-medium text-sm transition-colors">
                            <?= escapeHtml($settings['email'] ?? 'contact@nexskin.com') ?>
                        </a>
                    </div>

                    <!-- Social -->
                    <div class="bg-white p-6 rounded-2xl border border-nex-border">
                        <h3 class="font-semibold text-nex-dark mb-4">Suivez-nous</h3>
                        <div class="flex gap-3">
                            <?php if (!empty($settings['instagram'])): ?>
                            <a href="<?= escapeHtml($settings['instagram']) ?>" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 bg-nex-blue-pale rounded-full flex items-center justify-center text-nex-blue hover:bg-nex-blue hover:text-white transition-all">
                                <i data-lucide="instagram" class="w-5 h-5"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($settings['facebook'])): ?>
                            <a href="<?= escapeHtml($settings['facebook']) ?>" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 bg-nex-blue-pale rounded-full flex items-center justify-center text-nex-blue hover:bg-nex-blue hover:text-white transition-all">
                                <i data-lucide="facebook" class="w-5 h-5"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($settings['tiktok'])): ?>
                            <a href="<?= escapeHtml($settings['tiktok']) ?>" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 bg-nex-blue-pale rounded-full flex items-center justify-center text-nex-blue hover:bg-nex-blue hover:text-white transition-all">
                                <i data-lucide="music-2" class="w-5 h-5"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var projectType = document.getElementById('project_type');
    var budget = document.getElementById('budget');
    var prices = { habillage: '6 999 FCFA', partiel: '3 999 FCFA', design: '9 999 FCFA' };
    projectType.addEventListener('change', function() {
        budget.value = prices[this.value] || '';
    });
});
</script>

