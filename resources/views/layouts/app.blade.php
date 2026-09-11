<!DOCTYPE html>
<html lang="kh">
<head>
    <meta charset="UTF-8">
    <title>Wedding Invitation</title>
    <link rel="icon" href="{{ asset('assets/images/logo/wedding_logo.png') }}?v=1" type="image/png">

    <!-- Bootstrap 5 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <!-- Local Google Fonts for Calligraphy & Romantic Script -->
    <link href="{{ asset('assets/fonts/google/google_fonts.css') }}" rel="stylesheet">

    <!-- Local Fonts -->
    <link href="{{ asset('assets/fonts/fonts.css') }}" rel="stylesheet">

    @include('fonts')
    @stack('css')
    <style>
        body {
            background: #faf6f0;
            font-family: 'Battambang', sans-serif;
        }

        /* Adjacent Section Cards - Seamless & Tight Spacing Layout */
        .main-container > .card,
        .main-container > .floral-card,
        .main-container > .location-section-card,
        .main-container > .qr-section-card,
        .main-container > .gallery-section-card {
            margin-bottom: clamp(10px, 2.2vw, 14px) !important;
            border-radius: 28px !important;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease, border-color 0.35s ease !important;
        }

        .main-container > .card:hover,
        .main-container > .floral-card:hover,
        .main-container > .location-section-card:hover,
        .main-container > .qr-section-card:hover,
        .main-container > .gallery-section-card:hover {
            transform: translateY(-4px) scale(1.004) !important;
            box-shadow: 0 22px 50px rgba(212, 175, 55, 0.3), 0 8px 22px rgba(0, 0, 0, 0.12) !important;
            border-color: var(--gold-primary, #d4af37) !important;
        }

        .gallery-section-card {
            border-image: none !important;
            border: 3px solid var(--gold-primary, #d4af37) !important;
            border-radius: 28px !important;
        }

        /* Timeline Filter Action Buttons */
        .timeline-filter-btn {
            background: rgba(212, 175, 55, 0.12);
            color: #4a3b10;
            border: 1.5px solid rgba(212, 175, 55, 0.4);
            transition: all 0.3s ease;
        }
        .timeline-filter-btn.active,
        .timeline-filter-btn:hover {
            background: linear-gradient(135deg, var(--pink-primary, #ff2a85) 0%, var(--gold-primary, #d4af37) 100%);
            color: #ffffff !important;
            border-color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.4);
        }

        /* ==========================================================================
           UNIVERSAL DARK MIDNIGHT THEME TEXT & HIGH-CONTRAST COMPONENT OVERRIDES
           ========================================================================== */
        body.dark-mode {
            color: #fdf8f3 !important;
        }

        body.dark-mode .text-dark,
        body.dark-mode h1.text-dark,
        body.dark-mode h2.text-dark,
        body.dark-mode h3.text-dark,
        body.dark-mode h4.text-dark,
        body.dark-mode h5.text-dark,
        body.dark-mode h6.text-dark,
        body.dark-mode .muol.text-dark,
        body.dark-mode .muol,
        body.dark-mode .couple-name-title,
        body.dark-mode .invite-celebration-title,
        body.dark-mode .section-title,
        body.dark-mode .card-title,
        body.dark-mode .modal-title,
        body.dark-mode .timeline-content h4,
        body.dark-mode .wish-card strong {
            color: #fceabb !important;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .text-secondary,
        body.dark-mode .text-muted,
        body.dark-mode p.text-secondary,
        body.dark-mode p.text-muted,
        body.dark-mode .sub-title,
        body.dark-mode .qr-zoom-hint,
        body.dark-mode .timeline-content p,
        body.dark-mode .wish-card p {
            color: #e4d7c5 !important;
        }

        body.dark-mode .qr-section-card {
            background: linear-gradient(165deg, rgba(28, 14, 27, 0.98) 0%, rgba(18, 9, 17, 0.98) 100%) !important;
            border-color: #d4af37 !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.85), 0 0 30px rgba(212, 175, 55, 0.25) !important;
        }

        body.dark-mode .acc-number-pill {
            background: rgba(212, 175, 55, 0.18) !important;
            border-color: #d4af37 !important;
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.25) !important;
        }

        body.dark-mode .acc-num-text {
            color: #fff4d4 !important;
        }

        body.dark-mode .acc-bank-label {
            background: linear-gradient(135deg, #d4af37, #b8860b) !important;
            color: #1a0815 !important;
            font-weight: 800 !important;
        }

        body.dark-mode .btn-copy-acc {
            background: linear-gradient(135deg, #d4af37 0%, #f6e4b2 50%, #b8860b 100%) !important;
            color: #1a0815 !important;
        }

        body.dark-mode .btn-view-qr-full {
            background: linear-gradient(135deg, #8b0000 0%, #d40000 100%) !important;
            color: #ffe699 !important;
            border-color: #d4af37 !important;
        }

        /* Dark Midnight Form Controls */
        body.dark-mode .form-control,
        body.dark-mode input.form-control,
        body.dark-mode textarea.form-control {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(212, 175, 55, 0.45) !important;
            color: #fdf8f3 !important;
        }

        body.dark-mode .form-control::placeholder {
            color: rgba(253, 248, 243, 0.55) !important;
        }

        body.dark-mode .form-label {
            color: #fceabb !important;
        }

        /* Dark Midnight Modals */
        body.dark-mode .modal-content {
            background: #1c0e1b !important;
            color: #fdf8f3 !important;
            border: 2px solid #d4af37 !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.9) !important;
        }

        body.dark-mode .modal-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3) !important;
        }

        body.dark-mode .modal-header .modal-title,
        body.dark-mode .modal-body h4,
        body.dark-mode .modal-body h5 {
            color: #fceabb !important;
        }

        body.dark-mode .modal-body p {
            color: #e4d7c5 !important;
        }

        body.dark-mode .modal-body .bg-white {
            background-color: #291528 !important;
            border-color: #d4af37 !important;
        }

        /* Clean Custom Photo Lightbox Modal (Zero Bootstrap JS Conflicts) */
        .custom-photo-lightbox {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            height: 100dvh !important;
            background: rgba(0, 0, 0, 0.94) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            z-index: 2147483647 !important;
            display: none;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            opacity: 0;
            transition: opacity 0.25s ease !important;
            padding: 16px !important;
            box-sizing: border-box !important;
        }

        .custom-photo-lightbox.show {
            display: flex !important;
            opacity: 1 !important;
        }

        /* Hide floating theme toggle and music widget when lightbox or modal is active */
        body.lightbox-open .theme-toggle-btn,
        body.lightbox-open .music-widget,
        body.lightbox-open #actionToast,
        body.modal-open .theme-toggle-btn,
        body.modal-open .music-widget,
        body.modal-open #actionToast {
            display: none !important;
        }

        /* Particle & Floating Layer Z-Index Fixes */
        #flowerCanvas,
        .butterfly-particle,
        .flower-petal {
            z-index: 90 !important;
        }

        .music-widget,
        .theme-toggle-btn {
            z-index: 1020 !important;
        }

        /* Bootstrap Modal Layering */
        .modal {
            z-index: 1055 !important;
        }
        .modal-backdrop {
            z-index: 1050 !important;
        }

        /* QR Gift Modal Design & Mobile Layout Improvements */
        #qrGiftModal .modal-dialog {
            max-width: 420px !important;
            margin: 1rem auto !important;
            padding: 0 12px !important;
        }

        #qrGiftModal .modal-content {
            border-radius: 24px !important;
            border: 1.5px solid var(--gold-primary, #d4af37) !important;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35) !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        #qrGiftModal .modal-header {
            padding: 16px 20px !important;
            position: relative !important;
            z-index: 2 !important;
            background: linear-gradient(135deg, rgba(139, 0, 0, 0.08) 0%, rgba(212, 175, 55, 0.16) 100%) !important;
        }

        #qrGiftModal .btn-close {
            background-color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            opacity: 1 !important;
            border-radius: 50% !important;
            padding: 8px !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
        }

        #qrGiftModal .modal-body {
            padding: 18px 16px 22px 16px !important;
        }

        /* Luxury & Modern Digital Gift QR Code Box Style */
        .qr-section-card {
            background: linear-gradient(165deg, #ffffff 0%, #fffdf8 55%, #fff9ee 100%) !important;
            border: 3px solid var(--gold-primary, #d4af37) !important;
            outline: 1.5px dashed rgba(212, 175, 55, 0.6) !important;
            outline-offset: -8px !important;
            border-radius: clamp(24px, 5.5vw, 36px) !important;
            padding: clamp(28px, 5vw, 44px) clamp(16px, 3.5vw, 28px) !important;
            box-shadow: 0 20px 50px rgba(212, 175, 55, 0.22), 0 8px 24px rgba(0, 0, 0, 0.08) !important;
            margin-bottom: clamp(14px, 2.5vw, 20px) !important;
            position: relative !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease !important;
        }

        .qr-section-card:hover {
            transform: translateY(-4px) scale(1.004) !important;
            box-shadow: 0 28px 65px rgba(212, 175, 55, 0.35), 0 10px 30px rgba(0, 0, 0, 0.12) !important;
        }

        .qr-header-badge {
            background: linear-gradient(135deg, #8b0000 0%, #d4af37 100%) !important;
            color: #ffe699 !important;
            font-family: 'Cinzel', 'Battambang', serif !important;
            font-weight: 700 !important;
            font-size: clamp(13px, 3.2vw, 15px) !important;
            padding: 6px 22px !important;
            border-radius: 50px !important;
            margin-bottom: 18px !important;
            letter-spacing: 0.5px !important;
            border: 1.5px solid #ffffff !important;
            box-shadow: 0 6px 16px rgba(139, 0, 0, 0.3) !important;
        }

        .qr-img-wrapper {
            position: relative !important;
            display: inline-block !important;
            border-radius: 20px !important;
            overflow: hidden !important;
            padding: 8px !important;
            background: #ffffff !important;
            border: 2.5px solid var(--gold-primary, #d4af37) !important;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12) !important;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease !important;
        }

        .qr-img-wrapper:hover {
            transform: scale(1.03) !important;
            box-shadow: 0 18px 40px rgba(212, 175, 55, 0.4) !important;
        }

        .qr-standee-img {
            width: 100% !important;
            max-width: 280px !important;
            height: auto !important;
            border-radius: 14px !important;
            display: block !important;
        }

        .qr-zoom-hint {
            margin-top: 10px !important;
            font-size: clamp(12px, 3vw, 14px) !important;
            color: #64748b !important;
            font-weight: 600 !important;
            transition: color 0.2s ease !important;
        }

        .qr-img-wrapper:hover .qr-zoom-hint {
            color: var(--gold-primary, #d4af37) !important;
        }

        .acc-number-pill {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.14) 0%, rgba(212, 175, 55, 0.05) 100%) !important;
            border: 2px solid var(--gold-primary, #d4af37) !important;
            border-radius: 50px !important;
            padding: 9px 24px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 10px !important;
            box-shadow: 0 6px 18px rgba(212, 175, 55, 0.15) !important;
            transition: all 0.3s ease !important;
        }

        .acc-number-pill:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.25) 0%, rgba(212, 175, 55, 0.1) 100%) !important;
            transform: translateY(-2px) scale(1.02) !important;
            box-shadow: 0 10px 24px rgba(212, 175, 55, 0.35) !important;
        }

        .acc-num-text {
            font-family: monospace !important;
            font-weight: 700 !important;
            font-size: clamp(16px, 4vw, 20px) !important;
            color: #1e293b !important;
            letter-spacing: 1px !important;
        }

        .acc-bank-label {
            font-size: 12px !important;
            font-weight: 700 !important;
            background: linear-gradient(135deg, #005f73, #0a9396) !important;
            color: #ffffff !important;
            padding: 3px 10px !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 6px rgba(0, 95, 115, 0.3) !important;
        }

        .copy-icon {
            color: var(--gold-primary, #d4af37) !important;
            font-size: 16px !important;
        }

        .btn-copy-acc {
            border: 1.5px solid #ffffff !important;
            color: #2c1e05 !important;
            background: linear-gradient(135deg, #d4af37 0%, #f6e4b2 45%, #b8860b 100%) !important;
            border-radius: 50px !important;
            padding: 10px 24px !important;
            font-family: 'Battambang', sans-serif !important;
            font-weight: 700 !important;
            font-size: clamp(14px, 3.5vw, 16.5px) !important;
            box-shadow: 0 8px 22px rgba(212, 175, 55, 0.4) !important;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        .btn-copy-acc:hover,
        .btn-copy-acc:active {
            transform: translateY(-2px) scale(1.03) !important;
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.6) !important;
            background: linear-gradient(135deg, #e6c555 0%, #ffffff 45%, #c59b27 100%) !important;
        }

        .btn-view-qr-full {
            border: 1.5px solid var(--gold-primary, #d4af37) !important;
            color: #ffe699 !important;
            background: linear-gradient(135deg, #8b0000 0%, #b31b1b 100%) !important;
            border-radius: 50px !important;
            padding: 10px 24px !important;
            font-family: 'Battambang', sans-serif !important;
            font-weight: 700 !important;
            font-size: clamp(14px, 3.5vw, 16.5px) !important;
            box-shadow: 0 8px 22px rgba(139, 0, 0, 0.35) !important;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        .btn-view-qr-full:hover,
        .btn-view-qr-full:active {
            transform: translateY(-2px) scale(1.03) !important;
            box-shadow: 0 12px 30px rgba(139, 0, 0, 0.55) !important;
            background: linear-gradient(135deg, #a30000 0%, #d40000 100%) !important;
        }

        .custom-photo-lightbox-content {
            position: relative !important;
            max-width: 95vw !important;
            max-height: 85vh !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            z-index: 2147483647 !important;
        }

        .custom-photo-lightbox-img {
            max-width: 96vw !important;
            max-height: 86vh !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            border-radius: 14px !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.95) !important;
            transition: opacity 0.15s ease !important;
        }

        .custom-photo-close-btn {
            position: fixed !important;
            top: clamp(16px, 4vw, 24px) !important;
            right: clamp(16px, 4vw, 24px) !important;
            z-index: 2147483647 !important;
            padding: 10px 24px !important;
            height: 48px !important;
            min-width: 96px !important;
            border-radius: 50px !important;
            background: linear-gradient(135deg, #ff3b30 0%, #d70015 100%) !important;
            border: 2.5px solid #ffffff !important;
            color: #ffffff !important;
            font-size: 16.5px !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            box-shadow: 0 8px 25px rgba(215, 0, 21, 0.55), 0 0 15px rgba(255, 255, 255, 0.3) !important;
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease !important;
        }
        .custom-photo-close-btn:hover {
            transform: scale(1.05) !important;
            background: linear-gradient(135deg, #ff453a 0%, #e0001a 100%) !important;
            box-shadow: 0 12px 30px rgba(215, 0, 21, 0.7), 0 0 20px rgba(255, 255, 255, 0.5) !important;
        }
        .custom-photo-close-btn:active {
            transform: scale(0.93) !important;
            background: #b30012 !important;
        }


        .custom-photo-nav-btn {
            position: fixed !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 2147483647 !important;
            width: 52px !important;
            height: 52px !important;
            border-radius: 50% !important;
            background: rgba(0, 0, 0, 0.75) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 2px solid rgba(255, 255, 255, 0.9) !important;
            color: #ffffff !important;
            font-size: 22px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.85), 0 0 12px rgba(255, 255, 255, 0.2) !important;
            transition: all 0.2s ease !important;
        }
        .custom-photo-nav-btn:hover {
            background: rgba(220, 53, 69, 0.95) !important;
            border-color: #ffd700 !important;
            transform: translateY(-50%) scale(1.1) !important;
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.6) !important;
        }
        .custom-photo-nav-btn:active {
            transform: translateY(-50%) scale(0.9) !important;
        }
        .custom-photo-nav-prev { left: clamp(12px, 3vw, 24px) !important; }
        .custom-photo-nav-next { right: clamp(12px, 3vw, 24px) !important; }

        @media (min-width: 768px) {
            .custom-photo-nav-prev { left: 28px !important; }
            .custom-photo-nav-next { right: 28px !important; }
            .custom-photo-lightbox-img { max-height: 82vh !important; }
        }

        /* Universal Button Clickability & Touch Fixes */
        button,
        .btn,
        a.btn,
        input[type="submit"],
        .timeline-filter-btn,
        .theme-toggle-btn,
        .music-btn,
        .quick-nav-item,
        .quick-nav-scroll-btn {
            cursor: pointer !important;
            touch-action: manipulation !important;
            -webkit-tap-highlight-color: transparent !important;
            user-select: none !important;
            -webkit-user-select: none !important;
        }

        button *,
        a.btn *,
        .btn * {
            pointer-events: none !important;
        }

        /* Grand Royal Gold & Silk Pearl Opening Overlay Style (Zero Image Dependencies) */
        #envelopeOverlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            height: 100dvh !important;
            background: radial-gradient(circle at 50% 42%, #ffffff 0%, #fdf8ed 50%, #f5e4c3 100%) !important;
            z-index: 20000 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: clamp(16px, 4vw, 32px) !important;
            overflow-y: auto !important;
            transition: opacity 0.4s ease, transform 0.4s ease, visibility 0.4s ease !important;
        }

        #envelopeOverlay.hide-overlay {
            opacity: 0 !important;
            pointer-events: none !important;
            transform: scale(1.05) !important;
            visibility: hidden !important;
            display: none !important;
        }

        #envelopeOverlay .envelope-card,
        .envelope-card {
            background: linear-gradient(160deg, #ffffff 0%, #fffdf8 55%, #fff9ee 100%) !important;
            border: 3.5px solid #d4af37 !important;
            outline: 2px dashed rgba(212, 175, 55, 0.75) !important;
            outline-offset: -10px !important;
            border-radius: clamp(28px, 6vw, 42px) !important;
            padding: clamp(38px, 7.5vw, 56px) clamp(22px, 5.5vw, 42px) !important;
            max-width: 530px !important;
            width: clamp(330px, 92vw, 530px) !important;
            box-shadow: 0 35px 85px rgba(0, 0, 0, 0.24), 0 0 50px rgba(212, 175, 55, 0.35) !important;
            text-align: center !important;
            position: relative !important;
            margin: auto !important;
            animation: floatEnvelope 5s ease-in-out infinite !important;
        }

        /* Gold Corner Filigrees */
        .khmer-corner {
            position: absolute !important;
            width: 32px !important;
            height: 32px !important;
            pointer-events: none !important;
            z-index: 5 !important;
        }
        .khmer-corner::before,
        .khmer-corner::after {
            content: '' !important;
            position: absolute !important;
            background: linear-gradient(135deg, #d4af37, #aa771c) !important;
        }
        .khmer-corner.corner-tl { top: 14px; left: 14px; }
        .khmer-corner.corner-tl::before { top: 0; left: 0; width: 24px; height: 3.5px; border-radius: 2px; }
        .khmer-corner.corner-tl::after { top: 0; left: 0; width: 3.5px; height: 24px; border-radius: 2px; }

        .khmer-corner.corner-tr { top: 14px; right: 14px; }
        .khmer-corner.corner-tr::before { top: 0; right: 0; width: 24px; height: 3.5px; border-radius: 2px; }
        .khmer-corner.corner-tr::after { top: 0; right: 0; width: 3.5px; height: 24px; border-radius: 2px; }

        .khmer-corner.corner-bl { bottom: 14px; left: 14px; }
        .khmer-corner.corner-bl::before { bottom: 0; left: 0; width: 24px; height: 3.5px; border-radius: 2px; }
        .khmer-corner.corner-bl::after { bottom: 0; left: 0; width: 3.5px; height: 24px; border-radius: 2px; }

        .khmer-corner.corner-br { bottom: 14px; right: 14px; }
        .khmer-corner.corner-br::before { bottom: 0; right: 0; width: 24px; height: 3.5px; border-radius: 2px; }
        .khmer-corner.corner-br::after { bottom: 0; right: 0; width: 3.5px; height: 24px; border-radius: 2px; }

        /* Royal Metallic Gold Crest Header Banner */
        .royal-crest-badge {
            display: inline-block !important;
            background: linear-gradient(135deg, #d4af37 0%, #f6e4b2 50%, #b8860b 100%) !important;
            color: #2b1f07 !important;
            padding: 6px 22px !important;
            border-radius: 50px !important;
            font-size: clamp(13px, 3.4vw, 16px) !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            border: 1.5px solid #ffffff !important;
            box-shadow: 0 6px 16px rgba(212, 175, 55, 0.4) !important;
            margin-bottom: 14px !important;
        }

        /* 3D Sunburst Gold Wax Seal */
        #envelopeOverlay .envelope-wax-seal,
        .envelope-wax-seal {
            width: clamp(66px, 16vw, 84px) !important;
            height: clamp(66px, 16vw, 84px) !important;
            background: radial-gradient(circle at 35% 35%, #ffd700 0%, #d4af37 60%, #996515 100%) !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: clamp(30px, 7.5vw, 40px) !important;
            margin: 0 auto clamp(12px, 3vw, 18px) !important;
            box-shadow: 0 12px 28px rgba(212, 175, 55, 0.5), 0 0 0 3px #ffffff, inset 0 2px 6px rgba(255, 255, 255, 0.8) !important;
            border: 2px solid #d4af37 !important;
            animation: goldWaxPulse 3s infinite ease-in-out !important;
        }

        @keyframes goldWaxPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 12px 28px rgba(212, 175, 55, 0.5), 0 0 0 3px #ffffff, inset 0 2px 6px rgba(255, 255, 255, 0.8); }
            50% { transform: scale(1.06); box-shadow: 0 16px 36px rgba(212, 175, 55, 0.75), 0 0 0 4px #ffe699, inset 0 2px 8px rgba(255, 255, 255, 0.95); }
        }

        /* Logo Image */
        #envelopeOverlay img {
            width: clamp(170px, 52vw, 235px) !important;
            max-width: 235px !important;
            height: auto !important;
            margin: 6px auto clamp(10px, 2.5vw, 16px) !important;
            filter: drop-shadow(0 10px 22px rgba(212, 175, 55, 0.25)) !important;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        /* Main Royal Gold Khmer Title */
        #envelopeOverlay h2.royal-title,
        #envelopeOverlay h2.muol,
        .envelope-card h2.muol {
            font-size: clamp(24px, 6.2vw, 33px) !important;
            background: linear-gradient(135deg, #b8860b 0%, #d4af37 50%, #aa771c 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            line-height: 1.4 !important;
            margin-bottom: 2px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            filter: drop-shadow(0 2px 4px rgba(212, 175, 55, 0.3)) !important;
        }

        #envelopeOverlay p.royal-subtitle,
        #envelopeOverlay p.text-muted,
        .envelope-card p.text-muted {
            font-size: clamp(14px, 3.8vw, 18px) !important;
            color: #7a664e !important;
            font-style: italic !important;
            letter-spacing: 1px !important;
            margin-bottom: 14px !important;
        }

        /* Guest Name Gold Pill Badge */
        .guest-name-pill {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.16) 0%, rgba(212, 175, 55, 0.06) 100%) !important;
            border: 2px solid #d4af37 !important;
            border-radius: 50px !important;
            padding: 8px 24px !important;
            display: inline-block !important;
            margin-top: 6px !important;
            margin-bottom: 0 !important;
            box-shadow: 0 6px 18px rgba(212, 175, 55, 0.18) !important;
        }
        .guest-name-pill .guest-label {
            font-size: clamp(14px, 3.6vw, 17px) !important;
            color: #8b6914 !important;
        }
        .guest-name-pill .guest-name,
        #envelopeOverlay p.muol {
            font-size: clamp(19px, 4.8vw, 24px) !important;
            color: #1a1a1a !important;
            font-weight: 700 !important;
        }

        /* Metallic Gold Button */
        #envelopeOverlay .btn-royal-crimson,
        #envelopeOverlay .btn-action-gold,
        .envelope-card .btn-action-gold {
            width: 100% !important;
            max-width: 320px !important;
            font-size: clamp(18px, 4.8vw, 22px) !important;
            padding: clamp(15px, 4vw, 19px) clamp(28px, 6vw, 42px) !important;
            margin-top: clamp(20px, 5vw, 30px) !important;
            border-radius: 50px !important;
            background: linear-gradient(135deg, #d4af37 0%, #f6e4b2 45%, #b8860b 100%) !important;
            color: #2c1e05 !important;
            font-weight: bold !important;
            border: 2px solid #ffffff !important;
            box-shadow: 0 12px 32px rgba(212, 175, 55, 0.45) !important;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            cursor: pointer !important;
            position: relative !important;
            overflow: hidden !important;
        }

        #envelopeOverlay .btn-royal-crimson:hover,
        #envelopeOverlay .btn-royal-crimson:active,
        #envelopeOverlay .btn-action-gold:hover,
        #envelopeOverlay .btn-action-gold:active,
        .envelope-card .btn-action-gold:hover,
        .envelope-card .btn-action-gold:active {
            transform: translateY(-3px) scale(1.03) !important;
            box-shadow: 0 18px 45px rgba(212, 175, 55, 0.65) !important;
            background: linear-gradient(135deg, #e6c555 0%, #ffffff 45%, #c59b27 100%) !important;
            color: #1a1000 !important;
        }

        .caret-0::after, .dropdown-toggle.caret-0::after, .dropdown-toggle.no-caret::after {
            display: none !important;
            content: none !important;
        }
    </style>
</head>
<body>
    <div class="content">
        @yield('content')
    </div>

    @include('layouts.partials.floating-nav')

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
    function filterTimelineDay(day, btn) {
        const parentBlock = btn.closest('.card');
        if (!parentBlock) return;
        const dayBlocks = parentBlock.querySelectorAll('.day-schedule-block');
        if (dayBlocks.length < 2) return;

        const day1Block = dayBlocks[0];
        const day2Block = dayBlocks[1];

        const filterBtns = parentBlock.querySelectorAll('.timeline-filter-btn');
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        if (day === 'all') {
            if (day1Block) day1Block.style.display = 'block';
            if (day2Block) day2Block.style.display = 'block';
        } else if (day === 'day1') {
            if (day1Block) day1Block.style.display = 'block';
            if (day2Block) day2Block.style.display = 'none';
        } else if (day === 'day2') {
            if (day1Block) day1Block.style.display = 'none';
            if (day2Block) day2Block.style.display = 'block';
        }
    }
    </script>
    @stack('script')
</body>
</html>
