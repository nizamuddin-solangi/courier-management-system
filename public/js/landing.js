/* ==========================================
   Rapid Route – Landing Page Logic (landing.js)
   ========================================== */

document.addEventListener('DOMContentLoaded', () => {
    // ---- Achievement Counters Animation ----
    const achNumbers = document.querySelectorAll('.ach-number');
    const animateAchievements = () => {
        achNumbers.forEach(el => {
            const target = parseInt(el.getAttribute('data-target'));
            if (!el.classList.contains('animated')) {
                el.classList.add('animated');
                // Use the animateCount helper from main.js if available, else local implementation
                if (typeof animateCount === 'function') {
                    animateCount(el, target, 2000);
                } else {
                    let start = 0;
                    const duration = 2000;
                    const startTime = performance.now();
                    const update = (now) => {
                        const progress = Math.min((now - startTime) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.floor(eased * target).toLocaleString();
                        if (progress < 1) requestAnimationFrame(update);
                    };
                    requestAnimationFrame(update);
                }
            }
        });
    };

    // ---- Intersection Observer for animations ----
    const observerOptions = {
        threshold: 0.2
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('achievement-banner')) {
                    animateAchievements();
                }
                entry.target.classList.add('in-view');
            }
        });
    }, observerOptions);

    // Observe work cards and achievement banner
    document.querySelectorAll('.work-card, .achievement-banner, .feature-card, .step-card').forEach(el => {
        sectionObserver.observe(el);
    });

    // ---- Particle Field (if not already handled) ----
    const particleField = document.getElementById('particleField');
    if (particleField) {
        for (let i = 0; i < 50; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.animationDelay = Math.random() * 5 + 's';
            p.style.opacity = Math.random() * 0.5;
            particleField.appendChild(p);
        }
    }
});

// Helper for hero tracking
window.trackFromHero = function() {
    const input = document.getElementById('heroTrackInput');
    const trackingId = (input?.value || "").trim();
    
    if (!trackingId) {
        if (typeof showToast === 'function') showToast('Please enter a tracking number', 'error');
        return;
    }

    // Check if user is logged in (variable defined in Blade)
    if (typeof IS_LOGGED_IN !== 'undefined' && !IS_LOGGED_IN) {
        if (typeof showLoginRequired === 'function') {
            showLoginRequired();
        } else {
            // Fallback: redirect to track page which will show the modal
            window.location.href = `/user/track?id=${encodeURIComponent(trackingId)}`;
        }
        return;
    }

    // If logged in, proceed to track page
    window.location.href = `/user/track?id=${encodeURIComponent(trackingId)}`;
};
