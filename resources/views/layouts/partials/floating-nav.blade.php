<!-- Floating Quick Links Navigation Dock (Link Box) -->
<div id="floatingQuickNav" class="floating-quick-nav-wrapper">
    <!-- Main Capsule Container -->
    <div class="floating-quick-nav-capsule" id="quickNavCapsule">
        <!-- 1. Home Link -->
        <a href="#sec-home" class="quick-nav-item active" data-section="sec-home" aria-label="Home / ទំព័រដើម">
            <div class="quick-nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span class="nav-active-dot"></span>
            </div>
            <span class="quick-nav-tooltip">ទំព័រដើម</span>
        </a>

        <!-- 2. Location Link -->
        <a href="#sec-location" class="quick-nav-item" data-section="sec-location" aria-label="Location / ទីតាំង">
            <div class="quick-nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span class="nav-active-dot"></span>
            </div>
            <span class="quick-nav-tooltip">ទីតាំង</span>
        </a>

        <!-- 3. Calendar & Program Link -->
        <a href="#sec-calendar" class="quick-nav-item" data-section="sec-calendar" aria-label="Calendar / ប្រតិទិន">
            <div class="quick-nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="nav-active-dot"></span>
            </div>
            <span class="quick-nav-tooltip">ប្រតិទិន</span>
        </a>

        <!-- 4. Photo Gallery Link -->
        <a href="#sec-gallery" class="quick-nav-item" data-section="sec-gallery" aria-label="Gallery / រូបថត">
            <div class="quick-nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
                <span class="nav-active-dot"></span>
            </div>
            <span class="quick-nav-tooltip">រូបថត</span>
        </a>

        <!-- 5. Digital Gift / QR Link -->
        <a href="#sec-qr" class="quick-nav-item" data-section="sec-qr" aria-label="Digital Gift QR / ចំណងដៃ">
            <div class="quick-nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span class="nav-active-dot"></span>
            </div>
            <span class="quick-nav-tooltip">ចំណងដៃ</span>
        </a>

        <!-- 6. Guest Wishes Link -->
        <a href="#sec-wishes" class="quick-nav-item" data-section="sec-wishes" aria-label="Wishes / សារជូនពរ">
            <div class="quick-nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span class="nav-active-dot"></span>
            </div>
            <span class="quick-nav-tooltip">សារជូនពរ</span>
        </a>
    </div>

    <!-- Right Action Button (Scroll Down / Top Toggle) -->
    <button type="button" id="btnNavScrollToggle" class="quick-nav-scroll-btn" aria-label="Scroll Toggle">
        <span class="scroll-btn-ring"></span>
        <svg class="nav-scroll-arrow-svg" id="navScrollSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="7 7 12 12 17 7"></polyline>
            <polyline points="7 13 12 18 17 13"></polyline>
        </svg>
    </button>
</div>

<style>
    /* ==========================================================
       PREMIUM FLOATING QUICK LINK NAVIGATION BOX (NEW WOW STYLE)
       ========================================================== */
    :root {
        --nav-olive-accent: #606c38;
        --nav-olive-dark: #455026;
        --nav-gold-accent: #d4af37;
        --nav-bg: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(253, 251, 246, 0.95) 100%);
        --nav-shadow: 0 18px 45px rgba(0, 0, 0, 0.16), 0 0 20px rgba(212, 175, 55, 0.15);
        --nav-border: rgba(212, 175, 55, 0.35);
    }

    /* Floating Navigation Position Wrapper */
    .floating-quick-nav-wrapper {
        position: fixed;
        bottom: clamp(16px, 3.5vw, 28px);
        left: 50%;
        transform: translateX(-50%);
        z-index: 9995;
        display: flex;
        align-items: center;
        gap: clamp(8px, 2vw, 14px);
        transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1), transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 96vw;
    }

    /* Hide when Lightbox or Bootstrap modal is open */
    body.lightbox-open .floating-quick-nav-wrapper,
    body.modal-open .floating-quick-nav-wrapper {
        opacity: 0 !important;
        pointer-events: none !important;
        transform: translateX(-50%) translateY(25px) !important;
    }

    /* Capsule Container Pill - Ultra Elegant 3D Glass Pill */
    .floating-quick-nav-capsule {
        background: var(--nav-bg);
        border: 1.5px solid var(--nav-border);
        border-radius: 60px;
        box-shadow: var(--nav-shadow);
        padding: clamp(6px, 1.5vw, 9px) clamp(10px, 2vw, 18px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: clamp(6px, 1.5vw, 14px);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        position: relative;
    }

    /* Nav Item Link */
    .quick-nav-item {
        position: relative;
        text-decoration: none !important;
        outline: none;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2px;
    }

    /* Icon Inner Circle Container */
    .quick-nav-icon-box {
        position: relative;
        width: clamp(44px, 6.5vw, 54px);
        height: clamp(44px, 6.5vw, 54px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--nav-olive-accent);
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: transparent;
    }

    /* Icon SVG */
    .quick-nav-icon-box svg {
        display: block;
        width: clamp(24px, 3.8vw, 28px);
        height: clamp(24px, 3.8vw, 28px);
        stroke: currentColor;
        transition: transform 0.3s ease, stroke 0.3s ease;
    }

    /* Active Dot Badge Top Right - Glowing Pulse Dot */
    .nav-active-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: clamp(8px, 1.2vw, 10px);
        height: clamp(8px, 1.2vw, 10px);
        background-color: var(--nav-olive-accent);
        border: 2px solid #ffffff;
        border-radius: 50%;
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Hover State */
    .quick-nav-item:hover .quick-nav-icon-box {
        background: rgba(96, 108, 56, 0.12);
        transform: translateY(-3px) scale(1.1);
        color: var(--nav-olive-dark);
    }

    .quick-nav-item:hover .quick-nav-icon-box svg {
        transform: scale(1.08);
    }

    /* Active State (Solid Olive Gradient Circle - Wow Glow Effect) */
    .quick-nav-item.active .quick-nav-icon-box {
        background: linear-gradient(135deg, var(--nav-olive-accent) 0%, var(--nav-olive-dark) 100%);
        color: #ffffff !important;
        box-shadow: 0 8px 22px rgba(96, 108, 56, 0.48), 0 0 12px rgba(212, 175, 55, 0.35);
        transform: scale(1.08);
        animation: activePulse 2.5s ease-in-out infinite;
    }

    .quick-nav-item.active .quick-nav-icon-box svg {
        stroke: #ffffff;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .quick-nav-item.active .nav-active-dot {
        opacity: 1;
        transform: scale(1);
        background-color: #8fa04b;
        border-color: #ffffff;
        box-shadow: 0 0 8px rgba(143, 160, 75, 0.8);
    }

    @keyframes activePulse {
        0%, 100% {
            box-shadow: 0 8px 22px rgba(96, 108, 56, 0.48), 0 0 12px rgba(212, 175, 55, 0.35);
        }
        50% {
            box-shadow: 0 10px 28px rgba(96, 108, 56, 0.65), 0 0 18px rgba(212, 175, 55, 0.55);
        }
    }

    /* Hover Tooltip - Glossy Dark Pill */
    .quick-nav-tooltip {
        position: absolute;
        bottom: calc(100% + 14px);
        left: 50%;
        transform: translateX(-50%) translateY(8px);
        background: rgba(20, 20, 20, 0.94);
        border: 1px solid rgba(212, 175, 55, 0.5);
        color: #ffffff;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.3);
        font-family: 'Battambang', sans-serif;
    }

    .quick-nav-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: rgba(20, 20, 20, 0.94) transparent transparent transparent;
    }

    .quick-nav-item:hover .quick-nav-tooltip {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* Right Action Circle Scroll Button - Pulsing Outer Ring */
    .quick-nav-scroll-btn {
        position: relative;
        width: clamp(48px, 7vw, 58px);
        height: clamp(48px, 7vw, 58px);
        border-radius: 50%;
        background: linear-gradient(135deg, var(--nav-olive-accent) 0%, var(--nav-olive-dark) 100%);
        color: #ffffff;
        border: 2.5px solid #ffffff;
        box-shadow: 0 10px 28px rgba(96, 108, 56, 0.55), 0 0 15px rgba(212, 175, 55, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        outline: none;
        flex-shrink: 0;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .scroll-btn-ring {
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 50%;
        border: 1.5px solid rgba(212, 175, 55, 0.6);
        animation: ringPulse 2s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes ringPulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.8;
        }
        50% {
            transform: scale(1.12);
            opacity: 0.2;
        }
    }

    .quick-nav-scroll-btn:hover {
        transform: translateY(-3px) scale(1.12);
        box-shadow: 0 14px 35px rgba(96, 108, 56, 0.7), 0 0 22px rgba(212, 175, 55, 0.6);
    }

    .quick-nav-scroll-btn:active {
        transform: scale(0.92);
    }

    .nav-scroll-arrow-svg {
        display: block;
        width: clamp(24px, 3.8vw, 28px);
        height: clamp(24px, 3.8vw, 28px);
        stroke: #ffffff;
        transition: transform 0.45s ease;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
    }

    .quick-nav-scroll-btn.scrolled-down .nav-scroll-arrow-svg {
        transform: rotate(180deg);
    }

    /* Dark Mode Compatibility */
    body.dark-mode .floating-quick-nav-capsule {
        background: linear-gradient(135deg, rgba(32, 18, 34, 0.96) 0%, rgba(18, 10, 19, 0.94) 100%);
        border-color: rgba(212, 175, 55, 0.45);
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.75), 0 0 25px rgba(255, 42, 133, 0.2);
    }
    body.dark-mode .quick-nav-icon-box {
        color: var(--gold-light, #f7e8a4);
    }
    body.dark-mode .quick-nav-item.active .quick-nav-icon-box {
        background: linear-gradient(135deg, var(--pink-primary, #ff2a85) 0%, var(--gold-primary, #d4af37) 100%);
        color: #ffffff !important;
        box-shadow: 0 8px 25px rgba(255, 42, 133, 0.6), 0 0 15px rgba(212, 175, 55, 0.5);
    }

    /* PRESET THEME STYLES (Supports data-style attribute on wrapper) */
    /* 1. Style: Pure Gold Luxe */
    .floating-quick-nav-wrapper[data-style="gold"] .floating-quick-nav-capsule {
        background: linear-gradient(135deg, #fffdf7 0%, #fcf5e2 100%);
        border: 2px solid #d4af37;
        box-shadow: 0 18px 45px rgba(212, 175, 55, 0.35);
    }
    .floating-quick-nav-wrapper[data-style="gold"] .quick-nav-item.active .quick-nav-icon-box {
        background: linear-gradient(135deg, #d4af37 0%, #b38b12 100%);
        box-shadow: 0 8px 22px rgba(212, 175, 55, 0.6);
    }
    .floating-quick-nav-wrapper[data-style="gold"] .quick-nav-scroll-btn {
        background: linear-gradient(135deg, #d4af37 0%, #b38b12 100%);
    }

    /* 2. Style: Romantic Rose & Pink */
    .floating-quick-nav-wrapper[data-style="pink"] .floating-quick-nav-capsule {
        background: #ffffff;
        border: 2px solid #ff2a85;
        box-shadow: 0 18px 45px rgba(255, 42, 133, 0.3);
    }
    .floating-quick-nav-wrapper[data-style="pink"] .quick-nav-item.active .quick-nav-icon-box {
        background: linear-gradient(135deg, #ff2a85 0%, #d81167 100%);
        box-shadow: 0 8px 22px rgba(255, 42, 133, 0.6);
    }
    .floating-quick-nav-wrapper[data-style="pink"] .quick-nav-scroll-btn {
        background: linear-gradient(135deg, #ff2a85 0%, #d81167 100%);
    }

    /* Small Screen Responsive Adjustments */
    @media (max-width: 420px) {
        .floating-quick-nav-wrapper {
            bottom: 14px;
            gap: 6px;
        }
        .floating-quick-nav-capsule {
            padding: 5px 8px;
            gap: 4px;
        }
        .quick-nav-icon-box {
            width: 40px;
            height: 40px;
        }
        .quick-nav-icon-box svg {
            width: 22px;
            height: 22px;
        }
        .quick-nav-scroll-btn {
            width: 44px;
            height: 44px;
        }
        .nav-scroll-arrow-svg {
            width: 22px;
            height: 22px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.quick-nav-item');
    const scrollBtn = document.getElementById('btnNavScrollToggle');

    // Smooth Scroll on Click
    navItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetEl = document.querySelector(targetId);

            if (targetEl) {
                const headerOffset = 20;
                const elementPosition = targetEl.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Toggle Scroll (Down / Top) Button
    if (scrollBtn) {
        scrollBtn.addEventListener('click', function () {
            const totalScrollable = document.documentElement.scrollHeight - window.innerHeight;
            const currentScroll = window.scrollY || window.pageYOffset;

            if (currentScroll >= totalScrollable - 180) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                const nextTarget = currentScroll + (window.innerHeight * 0.75);
                window.scrollTo({ top: nextTarget, behavior: 'smooth' });
            }
        });
    }

    // Scroll Observer for updating scroll button icon and active section
    function onScrollUpdate() {
        const totalScrollable = document.documentElement.scrollHeight - window.innerHeight;
        const currentScroll = window.scrollY || window.pageYOffset;

        if (scrollBtn) {
            if (currentScroll >= totalScrollable - 180) {
                scrollBtn.classList.add('scrolled-down');
                scrollBtn.setAttribute('title', 'ត្រឡប់ទៅលើ (Scroll to Top)');
            } else {
                scrollBtn.classList.remove('scrolled-down');
                scrollBtn.setAttribute('title', 'រំកិលចុះក្រោម (Scroll Down)');
            }
        }
    }

    window.addEventListener('scroll', onScrollUpdate, { passive: true });

    // IntersectionObserver to auto-highlight active section icon in exact page order
    const sectionIds = ['sec-home', 'sec-location', 'sec-calendar', 'sec-gallery', 'sec-qr', 'sec-wishes'];
    const sectionElements = sectionIds.map(id => document.getElementById(id)).filter(Boolean);

    if ('IntersectionObserver' in window && sectionElements.length > 0) {
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -40% 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const activeId = entry.target.id;
                    navItems.forEach(item => {
                        if (item.getAttribute('data-section') === activeId) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                }
            });
        }, observerOptions);

        sectionElements.forEach(sec => observer.observe(sec));
    }
});
</script>
