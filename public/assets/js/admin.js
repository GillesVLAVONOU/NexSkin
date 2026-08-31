// NexSkin Admin JS

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            sidebarOverlay?.classList.toggle('hidden');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            sidebar?.classList.remove('open');
            sidebarOverlay.classList.add('hidden');
        });
    }

    // File upload preview
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const previewId = this.dataset.preview;
            const preview = document.getElementById(previewId);
            if (!preview || !this.files[0]) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        });
    });

    // Multi-file upload preview
    const multiUpload = document.getElementById('gallery-upload');
    const galleryPreview = document.getElementById('gallery-preview');

    if (multiUpload && galleryPreview) {
        multiUpload.addEventListener('change', function() {
            galleryPreview.innerHTML = '';
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <span class="remove-btn" onclick="this.parentElement.remove()">✕</span>
                    `;
                    galleryPreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // Auto-hide flash messages
    document.querySelectorAll('[data-auto-hide]').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }, 5000);
    });

    // Confirm delete actions
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm || 'Êtes-vous sûr ?')) {
                e.preventDefault();
            }
        });
    });

    // Slug generation from title
    const titleInput = document.getElementById('title-input');
    const slugInput = document.getElementById('slug-input');

    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            slugInput.value = this.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        });
    }

    // Character counter
    document.querySelectorAll('[data-maxlength]').forEach(el => {
        const max = parseInt(el.dataset.maxlength);
        const counter = document.getElementById(el.dataset.counter);
        if (!counter) return;

        const update = () => {
            const remaining = max - el.value.length;
            counter.textContent = remaining + ' caractères restants';
            counter.className = remaining < 0 ? 'text-red-500 text-xs' : 'text-gray-400 text-xs';
        };

        el.addEventListener('input', update);
        update();
    });
});
