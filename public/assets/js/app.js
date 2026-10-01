// NexSkin App JS

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Header scroll effect
    const header = document.getElementById('site-header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            if (currentScroll > 20) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            lastScroll = currentScroll;
        });
    }

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
            mobileMenuBtn.setAttribute('aria-expanded', String(!isExpanded));
            mobileMenuBtn.setAttribute('aria-label', isExpanded ? 'Ouvrir le menu' : 'Fermer le menu');
            mobileMenu.classList.toggle('hidden', isExpanded);
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                mobileMenuBtn.setAttribute('aria-label', 'Ouvrir le menu');
            });
        });
    }

    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.body.classList.add('has-scroll-reveal');
    document.querySelectorAll('.fade-in, [data-section-reveal]').forEach(el => {
        observer.observe(el);
    });

    // Homepage hero carousel
    document.querySelectorAll('[data-hero-carousel]').forEach(carousel => {
        const slides = Array.from(carousel.querySelectorAll('.home-hero-slide'));
        const section = carousel.closest('.home-hero');
        if (slides.length < 2 || !section) return;

        const controls = section.querySelector('.home-carousel-controls');
        const dots = controls ? Array.from(controls.querySelectorAll('[data-carousel-slide]')) : [];
        const previousButton = controls?.querySelector('[data-carousel-previous]');
        const nextButton = controls?.querySelector('[data-carousel-next]');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let activeIndex = 0;
        let timer = null;

        const showSlide = (nextIndex) => {
            activeIndex = (nextIndex + slides.length) % slides.length;
            slides.forEach((slide, index) => {
                const isActive = index === activeIndex;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', String(!isActive));
            });
            dots.forEach((dot, index) => {
                dot.setAttribute('aria-pressed', String(index === activeIndex));
            });
        };

        const stopTimer = () => {
            if (timer) window.clearInterval(timer);
            timer = null;
        };

        const startTimer = () => {
            stopTimer();
            if (reduceMotion || document.hidden || section.contains(document.activeElement)) return;
            timer = window.setInterval(() => showSlide(activeIndex + 1), 5000);
        };

        previousButton?.addEventListener('click', () => {
            showSlide(activeIndex - 1);
            startTimer();
        });
        nextButton?.addEventListener('click', () => {
            showSlide(activeIndex + 1);
            startTimer();
        });
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                startTimer();
            });
        });

        section.addEventListener('focusin', stopTimer);
        section.addEventListener('focusout', startTimer);
        document.addEventListener('visibilitychange', startTimer);
        startTimer();
    });

    const heroImageInput = document.getElementById('hero_images');
    const heroImageStatus = document.getElementById('hero-images-status');
    if (heroImageInput && heroImageStatus) {
        heroImageInput.addEventListener('change', () => {
            const count = heroImageInput.files?.length ?? 0;
            heroImageStatus.textContent = count === 1 ? '1 image sélectionnée.' : `${count} images sélectionnées.`;
        });
    }

    // Before/After Slider
    document.querySelectorAll('.before-after-container').forEach(container => {
        const slider = container.querySelector('.before-after-slider');
        const before = container.querySelector('.before-after-before');
        if (!slider || !before) return;

        let isDragging = false;

        const updateSlider = (x) => {
            const rect = container.getBoundingClientRect();
            let position = ((x - rect.left) / rect.width) * 100;
            position = Math.max(0, Math.min(100, position));
            container.style.setProperty('--before-after-position', position + '%');
            slider.style.left = position + '%';
            if (slider.getAttribute('role') === 'slider') {
                slider.setAttribute('aria-valuenow', String(Math.round(position)));
            }
        };

        slider.addEventListener('pointerdown', (e) => {
            isDragging = true;
            slider.setPointerCapture(e.pointerId);
            e.preventDefault();
        });

        slider.addEventListener('pointermove', (e) => {
            if (!isDragging) return;
            updateSlider(e.clientX);
        });

        const stopDragging = () => {
            isDragging = false;
        };

        slider.addEventListener('pointerup', stopDragging);
        slider.addEventListener('pointercancel', stopDragging);
        slider.addEventListener('keydown', (e) => {
            const currentPosition = Number.parseFloat(container.style.getPropertyValue('--before-after-position')) || 50;
            const step = e.shiftKey ? 10 : 5;
            let nextPosition = currentPosition;

            if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') nextPosition -= step;
            else if (e.key === 'ArrowRight' || e.key === 'ArrowUp') nextPosition += step;
            else if (e.key === 'Home') nextPosition = 0;
            else if (e.key === 'End') nextPosition = 100;
            else return;

            const rect = container.getBoundingClientRect();
            updateSlider(rect.left + (rect.width * nextPosition / 100));
            e.preventDefault();
        });

        // Click to move
        container.addEventListener('click', (e) => {
            updateSlider(e.clientX);
        });
    });

});
