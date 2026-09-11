@extends('layouts.app')

@push('css')
<style>
    :root {
        --sapphire-primary: #0f2b48;
        --sapphire-dark: #071728;
        --sapphire-accent: #1e4d7b;
        --gold-primary: #d4af37;
        --gold-light: #f9ecc2;
        --gold-accent: #e5c158;
        --cream-bg: #f5f8fc;
        --card-bg: rgba(255, 255, 255, 0.97);
        --card-shadow: 0 25px 65px rgba(15, 43, 72, 0.18), 0 10px 30px rgba(212, 175, 55, 0.22);
        --text-dark: #101c28;
    }

    /* Dark Starlight Sapphire Theme Mode */
    body.dark-mode {
        --cream-bg: #040c17;
        --card-bg: rgba(8, 22, 38, 0.96);
        --card-shadow: 0 28px 65px rgba(0, 0, 0, 0.85), 0 0 35px rgba(212, 175, 55, 0.25);
        --text-dark: #f0f6fc;
        background: radial-gradient(ellipse at 50% 0%, #0d253f 0%, #051424 60%, #020912 100%) !important;
        color: #f0f6fc !important;
    }
    body.dark-mode .text-dark,
    body.dark-mode h1.text-dark,
    body.dark-mode h2.text-dark,
    body.dark-mode h3.text-dark,
    body.dark-mode h4.text-dark,
    body.dark-mode .muol.text-dark {
        color: #fceabb !important;
    }
    body.dark-mode .text-secondary,
    body.dark-mode .text-muted,
    body.dark-mode p.text-secondary {
        color: #e4d7c5 !important;
    }
    body.dark-mode .floral-card,
    body.dark-mode .qr-section-card,
    body.dark-mode .location-section-card {
        background-color: rgba(8, 22, 38, 0.96) !important;
    }
    body.dark-mode .date-box-num {
        color: #e5c158 !important;
    }
    body.dark-mode .timeline-content,
    body.dark-mode .wish-card,
    body.dark-mode .calendar-table,
    body.dark-mode .calendar-table td {
        background: #0b1e33 !important;
        color: #f0f6fc !important;
        border-color: rgba(212, 175, 55, 0.5) !important;
    }

    body {
        background: radial-gradient(ellipse at 50% 0%, #f7f9fd 0%, #e8f0f8 50%, #d5e3f2 100%);
        color: var(--text-dark);
        font-family: 'Battambang', sans-serif;
        overflow-x: hidden;
        position: relative;
    }

    /* Ambient Flying Particles Canvas */
    .floating-particles-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 90;
        overflow: hidden;
    }

    .butterfly-particle {
        position: absolute;
        font-size: 26px;
        z-index: 90;
        pointer-events: none;
        animation: butterflyFly 25s linear infinite;
        filter: drop-shadow(0 4px 10px rgba(30, 77, 123, 0.5));
    }

    .butterfly-wings {
        display: inline-block;
        animation: wingFlap 0.7s ease-in-out infinite alternate;
    }

    @keyframes wingFlap {
        0% { transform: scaleX(1) rotate(0deg); }
        100% { transform: scaleX(0.3) rotate(-15deg); }
    }

    @keyframes butterflyFly {
        0% { transform: translate(-10vw, 100vh) rotate(15deg); opacity: 0; }
        10% { opacity: 0.95; }
        25% { transform: translate(25vw, 75vh) rotate(-10deg); }
        50% { transform: translate(60vw, 40vh) rotate(20deg); }
        75% { transform: translate(30vw, 20vh) rotate(-15deg); }
        90% { opacity: 0.95; }
        100% { transform: translate(110vw, -10vh) rotate(25deg); opacity: 0; }
    }

    .flower-petal {
        position: absolute;
        font-size: 20px;
        z-index: 90;
        pointer-events: none;
        animation: petalFall 20s linear infinite;
        filter: drop-shadow(0 2px 6px rgba(212, 175, 55, 0.4));
    }

    @keyframes petalFall {
        0% { transform: translateY(-50px) rotate(0deg) translateX(0); opacity: 1; }
        50% { transform: translateY(50vh) rotate(180deg) translateX(45px); opacity: 0.85; }
        100% { transform: translateY(105vh) rotate(360deg) translateX(-35px); opacity: 0; }
    }

    /* Main Container */
    .main-container {
        position: relative;
        z-index: 1;
        max-width: min(94vw, 960px);
        margin: 0 auto;
        padding-bottom: 60px;
    }

    /* Sapphire Floral Card Frame */
    .floral-card {
        background: var(--card-bg);
        border-radius: 26px;
        box-shadow: var(--card-shadow);
        position: relative;
        padding: clamp(24px, 5vw, 48px) clamp(16px, 4vw, 36px);
        margin-bottom: clamp(20px, 4vw, 38px);
        overflow: hidden;
        border: 2px solid rgba(212, 175, 55, 0.45);
        transition: all 0.4s ease;
    }

    /* Inner Dual Golden Rectangle Frame */
    .gold-inner-frame {
        border: 2px solid var(--gold-primary);
        outline: 1px dashed rgba(212, 175, 55, 0.7);
        outline-offset: -8px;
        border-radius: 18px;
        padding: clamp(20px, 4vw, 38px) clamp(14px, 3vw, 28px);
        position: relative;
        z-index: 2;
    }

    /* Corner Floral Decoration Accents */
    .corner-floral-top-right {
        position: absolute;
        top: -15px;
        right: -15px;
        font-size: clamp(38px, 6vw, 68px);
        line-height: 1;
        pointer-events: none;
        z-index: 1;
        filter: drop-shadow(0 6px 16px rgba(212, 175, 55, 0.4));
    }

    .corner-floral-bottom-left {
        position: absolute;
        bottom: -15px;
        left: -15px;
        font-size: clamp(38px, 6vw, 68px);
        line-height: 1;
        pointer-events: none;
        z-index: 1;
        filter: drop-shadow(0 6px 16px rgba(212, 175, 55, 0.4));
    }

    /* Top Left Badge */
    .ido-badge {
        position: absolute;
        top: clamp(12px, 3vw, 25px);
        left: clamp(14px, 3vw, 30px);
        font-family: 'Great Vibes', cursive;
        font-size: clamp(28px, 5vw, 44px);
        color: var(--gold-primary);
        line-height: 1;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 6px;
        text-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
    }

    /* Crest Doves Wrapper */
    .kissing-doves-wrapper {
        margin: 15px 0 10px;
        font-size: clamp(36px, 6vw, 52px);
        filter: drop-shadow(0 4px 12px rgba(212, 175, 55, 0.4));
    }

    /* Couple Name Showcase Styling */
    .couple-name-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 4px 10px;
    }

    .couple-label {
        font-family: 'muol', 'Battambang', sans-serif;
        font-size: clamp(16px, 3.5vw, 20px);
        color: #666;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
        display: block;
        font-weight: bold;
    }
    body.dark-mode .couple-label {
        color: #a4bccc;
    }

    .couple-name-title {
        font-family: 'muol', 'Battambang', serif, sans-serif;
        font-size: clamp(32px, 7vw, 48px);
        font-weight: bold;
        line-height: 1.45;
        color: var(--sapphire-primary);
        text-shadow: 0 3px 10px rgba(15, 43, 72, 0.15);
        padding: 2px 0;
    }
    body.dark-mode .couple-name-title {
        color: var(--gold-accent);
        text-shadow: 0 3px 10px rgba(212, 175, 55, 0.3);
    }

    .couple-ampersand {
        font-family: 'muol', 'Battambang', serif, sans-serif;
        font-size: clamp(26px, 5.5vw, 40px);
        color: var(--gold-primary);
        margin: 18px 8px 0;
        text-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
        align-self: center;
    }

    /* Invitation Header Text */
    .invite-celebration-title {
        font-family: 'Playfair Display', serif;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-size: clamp(15px, 3.2vw, 19px);
        font-weight: 700;
        color: #4a5c6d;
        margin: 18px 0 14px;
    }
    body.dark-mode .invite-celebration-title {
        color: #b0c6db;
    }

    /* Center Graphics */
    .graphic-flank-icon {
        font-size: clamp(24px, 4vw, 38px);
        filter: drop-shadow(0 4px 8px rgba(212, 175, 55, 0.4));
    }

    /* Date Grid Layout */
    .date-card-flex {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: clamp(10px, 3vw, 25px);
        margin: 22px 0;
    }

    .date-side-col {
        flex: 1;
        max-width: 180px;
        text-align: center;
    }

    .date-side-col span {
        font-family: 'Playfair Display', serif;
        font-size: clamp(15px, 3.2vw, 20px);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #2b3d4f;
        display: block;
        padding: 6px 0;
        border-top: 1.5px solid var(--gold-primary);
        border-bottom: 1.5px solid var(--gold-primary);
    }
    body.dark-mode .date-side-col span {
        color: #d8e5f2;
    }

    .date-center-box {
        text-align: center;
    }

    .date-month-label {
        font-family: 'Playfair Display', serif;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-size: clamp(15px, 3vw, 18px);
        color: #4a5d70;
        font-weight: 600;
    }
    body.dark-mode .date-month-label {
        color: #a4bccc;
    }

    .date-box-num {
        font-family: 'Playfair Display', serif;
        font-size: clamp(56px, 10vw, 84px);
        font-weight: bold;
        color: var(--sapphire-primary);
        line-height: 0.9;
        margin: 4px 0;
    }

    .date-year-label {
        font-family: 'Playfair Display', serif;
        letter-spacing: 2px;
        font-size: clamp(16px, 3.2vw, 19px);
        color: #3d5063;
        font-weight: 600;
    }
    body.dark-mode .date-year-label {
        color: #9cb5cb;
    }

    /* Reception Script */
    .reception-script {
        font-family: 'Great Vibes', cursive;
        font-size: clamp(32px, 6vw, 46px);
        color: var(--gold-primary);
        margin-top: 22px;
        text-shadow: 0 2px 8px rgba(212, 175, 55, 0.2);
    }

    /* Theme Switcher Toggle Pill */
    .theme-toggle-btn {
        position: fixed;
        top: clamp(12px, 2.5vw, 25px);
        right: clamp(12px, 2.5vw, 25px);
        z-index: 99999;
        background: linear-gradient(135deg, var(--sapphire-primary), var(--gold-primary));
        color: #fff;
        border: 2px solid var(--gold-light);
        border-radius: 50px;
        padding: clamp(6px, 1.5vw, 9px) clamp(14px, 2vw, 20px);
        font-size: clamp(12px, 1.8vw, 14px);
        font-weight: bold;
        box-shadow: 0 8px 22px rgba(0,0,0,0.35);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.35s ease;
    }
    .theme-toggle-btn:hover {
        transform: translateY(-2px) scale(1.04);
    }

    /* Action Toast Banner */
    #actionToast {
        position: fixed;
        top: clamp(12px, 2.5vw, 25px);
        left: 50%;
        transform: translateX(-50%) translateY(-100px);
        z-index: 100000;
        background: linear-gradient(135deg, #0f2b48, #071728);
        color: var(--gold-light);
        border: 2px solid var(--gold-primary);
        box-shadow: 0 12px 35px rgba(0,0,0,0.5);
        border-radius: 50px;
        padding: clamp(10px, 2vw, 14px) clamp(20px, 3vw, 34px);
        font-size: clamp(13px, 2vw, 15px);
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        max-width: min(90vw, 480px);
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    #actionToast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    /* Envelope Opening Startup Screen Overlay */
    #envelopeOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        height: 100dvh;
        background: radial-gradient(circle at center, #f4f8fd 0%, #d8e5f2 100%);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        overflow-y: auto;
        transition: opacity 0.9s cubic-bezier(0.4, 0, 0.2, 1), transform 0.9s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .envelope-card {
        background: #ffffff;
        border: 3px solid var(--gold-primary);
        outline: 1px dashed rgba(212, 175, 55, 0.7);
        outline-offset: -7px;
        border-radius: 32px;
        padding: clamp(28px, 6vw, 48px) clamp(20px, 4vw, 38px);
        max-width: 500px;
        width: min(92vw, 500px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.25), 0 0 25px rgba(255, 42, 133, 0.15);
        text-align: center;
        position: relative;
        animation: floatEnvelope 5s ease-in-out infinite;
    }

    #envelopeOverlay img {
        width: clamp(120px, 34vw, 160px);
        max-width: 160px;
        height: auto;
        margin: 6px auto 12px !important;
        filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.12));
        transition: transform 0.3s ease;
    }

    @keyframes floatEnvelope {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-7px); }
    }

    .envelope-wax-seal {
        width: clamp(52px, 8vw, 68px);
        height: clamp(52px, 8vw, 68px);
        background: linear-gradient(135deg, #0f2b48, #d4af37);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(22px, 4vw, 30px);
        margin: 0 auto 15px;
        box-shadow: 0 8px 20px rgba(15, 43, 72, 0.4), inset 0 2px 4px rgba(255,255,255,0.6);
        border: 2px solid #fff;
    }

    /* Music Player Widget */
    .music-widget {
        position: fixed;
        bottom: clamp(14px, 3vw, 30px);
        right: clamp(14px, 3vw, 30px);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(12px);
        padding: 5px 14px 5px 5px;
        border-radius: 50px;
        border: 2px solid var(--gold-primary);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }

    .music-btn {
        width: clamp(40px, 6vw, 50px);
        height: clamp(40px, 6vw, 50px);
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sapphire-primary), var(--gold-primary));
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(16px, 3vw, 22px);
        cursor: pointer;
    }

    .equalizer-bars {
        display: flex;
        align-items: flex-end;
        gap: 3px;
        height: 18px;
    }

    .equalizer-bar {
        width: 3px;
        background: var(--gold-primary);
        border-radius: 2px;
        height: 5px;
    }

    .music-widget.playing .equalizer-bar:nth-child(1) { animation: eqBar 1.2s infinite ease-in-out; }
    .music-widget.playing .equalizer-bar:nth-child(2) { animation: eqBar 0.8s infinite ease-in-out 0.2s; }
    .music-widget.playing .equalizer-bar:nth-child(3) { animation: eqBar 1.4s infinite ease-in-out 0.4s; }
    .music-widget.playing .equalizer-bar:nth-child(4) { animation: eqBar 1.0s infinite ease-in-out 0.1s; }

    @keyframes eqBar { 0%, 100% { height: 4px; } 50% { height: 18px; } }

    /* Guest Frame Wrapper */
    .guest-frame-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 490px;
        margin: 16px 0;
    }

    .guest-frame-img { width: 100%; height: auto; }
    .guest-frame-text {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        font-size: clamp(22px, 5.5vw, 32px);
        font-weight: bold;
        color: #2b2518;
        white-space: nowrap;
    }

    /* Action Sapphire & Gold Button */
    .btn-action-gold {
        background: linear-gradient(135deg, var(--sapphire-primary) 0%, var(--gold-primary) 100%);
        color: #fff !important;
        font-size: clamp(15px, 3.2vw, 19px);
        padding: clamp(12px, 2.5vw, 15px) clamp(24px, 5vw, 42px);
        border-radius: 50px;
        border: 2px solid var(--gold-light);
        box-shadow: 0 10px 25px rgba(15, 43, 72, 0.35);
        cursor: pointer;
        transition: all 0.35s ease;
        animation: pulseBtn 2.5s infinite;
    }
    .btn-action-gold:hover { transform: scale(1.05) translateY(-3px); }

    @keyframes pulseBtn {
        0%, 100% { box-shadow: 0 10px 25px rgba(15, 43, 72, 0.35); }
        50% { box-shadow: 0 14px 32px rgba(212, 175, 55, 0.55); transform: scale(1.02); }
    }

    /* Standalone Location Card */
    .location-section-card {
        background: var(--card-bg);
        border-radius: 26px;
        box-shadow: var(--card-shadow);
        border: 2px solid var(--gold-primary);
        padding: clamp(26px, 5vw, 42px) clamp(16px, 4vw, 30px);
        margin-bottom: clamp(20px, 4vw, 38px);
        position: relative;
    }

    .location-preview-img {
        max-width: 340px;
        width: 100%;
        border-radius: 22px;
        border: 4px solid var(--gold-primary);
        box-shadow: 0 14px 30px rgba(0,0,0,0.18);
        cursor: pointer;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .location-preview-img:hover {
        transform: scale(1.04) rotate(1deg);
        box-shadow: 0 20px 42px rgba(212, 175, 55, 0.4);
    }

    /* Digital Gift ABA Bank KHQR Card */
    .qr-section-card {
        background: var(--card-bg, #ffffff);
        border-radius: 28px;
        box-shadow: var(--card-shadow, 0 15px 35px rgba(0,0,0,0.08));
        border: 2px solid var(--gold-primary, #d4af37);
        padding: clamp(24px, 4vw, 40px) clamp(14px, 3vw, 24px);
        margin-bottom: clamp(20px, 4vw, 38px);
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .qr-header-badge {
        background: linear-gradient(135deg, var(--sapphire-primary, #1e3c72) 0%, #005f73 100%);
        color: #ffffff;
        font-family: 'Cinzel', serif;
        font-weight: 700;
        font-size: 14px;
        padding: 6px 18px;
        border-radius: 20px;
        margin-bottom: 16px;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(30, 60, 114, 0.25);
    }

    .qr-img-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .qr-img-wrapper:hover {
        transform: scale(1.02);
    }

    .qr-standee-img {
        width: 100%;
        max-width: 280px;
        height: auto;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border: 1px solid #e2e8f0;
        display: block;
    }

    .qr-zoom-hint {
        margin-top: 8px;
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .qr-img-wrapper:hover .qr-zoom-hint {
        color: var(--gold-primary, #d4af37);
    }

    .acc-number-pill {
        background: #f8fafc;
        border: 1.5px dashed var(--gold-primary, #d4af37);
        border-radius: 50px;
        padding: 8px 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .acc-number-pill:hover {
        background: #fffdf5;
        border-style: solid;
        box-shadow: 0 4px 14px rgba(212, 175, 55, 0.2);
    }
    .acc-num-text {
        font-family: monospace;
        font-weight: 700;
        font-size: 18px;
        color: #1e293b;
        letter-spacing: 1px;
    }
    .acc-bank-label {
        font-size: 12px;
        font-weight: 700;
        background: #e2e8f0;
        color: #334155;
        padding: 2px 8px;
        border-radius: 10px;
    }
    .copy-icon {
        color: var(--gold-primary, #d4af37);
        font-size: 15px;
    }

    .btn-copy-acc {
        border: 2px solid var(--gold-primary, #d4af37) !important;
        color: #1e293b !important;
        background: #ffffff !important;
        border-radius: 50px !important;
        padding: 10px 24px !important;
        font-family: 'Battambang', sans-serif !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
    }
    .btn-copy-acc:hover {
        background: var(--gold-primary, #d4af37) !important;
        color: #ffffff !important;
        box-shadow: 0 6px 18px rgba(212, 175, 55, 0.4) !important;
    }

    .btn-view-qr-full {
        background: linear-gradient(135deg, var(--sapphire-primary, #1e3c72) 0%, #2a5298 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 10px 24px !important;
        font-family: 'Battambang', sans-serif !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        box-shadow: 0 6px 20px rgba(30, 60, 114, 0.3) !important;
        transition: all 0.3s ease !important;
    }
    .btn-view-qr-full:hover {
        transform: scale(1.04) translateY(-2px) !important;
        box-shadow: 0 10px 25px rgba(30, 60, 114, 0.45) !important;
    }

    .btn-view-qr-full {
        background: linear-gradient(135deg, var(--sapphire-primary) 0%, var(--gold-primary) 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 12px 30px !important;
        font-family: 'muol', sans-serif !important;
        font-size: 14px !important;
        box-shadow: 0 8px 22px rgba(15, 43, 72, 0.35) !important;
        transition: all 0.3s ease !important;
    }
    .btn-view-qr-full:hover {
        transform: scale(1.05) translateY(-2px) !important;
        box-shadow: 0 12px 28px rgba(212, 175, 55, 0.5) !important;
    }

    /* Custom Gold Foil Gallery Container & Wallpaper Layout */
    .gallery-section-card {
        background: #ffffff;
        border: 3px solid var(--gold-primary, #d4af37);
        border-radius: 28px;
        padding: clamp(14px, 3vw, 26px) clamp(10px, 2vw, 20px);
        margin-bottom: clamp(10px, 2.2vw, 14px);
        box-shadow: 0 25px 60px rgba(212, 175, 55, 0.28), 0 10px 30px rgba(0, 0, 0, 0.12);
        position: relative;
        overflow: hidden;
    }

    .gallery-bg-pattern {
        background-color: #faf8f5;
        background-image: 
            radial-gradient(#e5d7bc 0.8px, transparent 0.8px), 
            radial-gradient(#e5d7bc 0.8px, #faf8f5 0.8px);
        background-size: 26px 26px;
        background-position: 0 0, 13px 13px;
        border-radius: 24px;
        padding: clamp(10px, 2vw, 18px);
        border: 1px solid rgba(212, 175, 55, 0.35);
    }

    .custom-wedding-gallery {
        margin-top: 15px;
    }

    .gallery-card {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15), 0 0 16px rgba(212, 175, 55, 0.35);
        cursor: pointer;
        background: #ffffff;
        border: 3px solid var(--gold-primary, #d4af37);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        height: auto !important;
    }

    .gallery-card:hover, .gallery-card:active {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25), 0 0 25px rgba(212, 175, 55, 0.6);
        border-color: #ffd700;
    }

    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease, filter 0.5s ease;
    }


    .portrait-card {
        aspect-ratio: 2 / 3;
        width: 100%;
        border-radius: 18px;
    }

    .landscape-hero-card {
        aspect-ratio: 3 / 2;
        width: 100%;
        border-radius: 18px;
    }

    /* Countdown Grid */
    .countdown-grid {
        display: flex;
        justify-content: center;
        gap: clamp(8px, 2.5vw, 18px);
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .countdown-box {
        background: #ffffff;
        border: 2px solid var(--gold-primary);
        border-radius: 20px;
        padding: clamp(12px, 2.5vw, 18px) clamp(14px, 3vw, 24px);
        min-width: clamp(72px, 18vw, 105px);
        box-shadow: 0 12px 24px rgba(212, 175, 55, 0.25);
        text-align: center;
        flex: 1;
        max-width: 130px;
    }

    .countdown-value { font-size: clamp(24px, 5vw, 38px); font-weight: 800; color: var(--sapphire-primary); }
    body.dark-mode .countdown-value { color: var(--gold-accent); }

    /* Timeline & Calendar */
    .timeline-badge {
        width: clamp(44px, 6vw, 54px); height: clamp(44px, 6vw, 54px); border-radius: 50%;
        background: #ffffff; border: 3px solid var(--gold-primary); color: var(--sapphire-primary);
        display: flex; align-items: center; justify-content: center; margin: 0 auto;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15); font-size: clamp(18px, 3vw, 22px);
    }

    .timeline-content {
        background: #ffffff; border-radius: 18px; padding: clamp(16px, 3vw, 22px) clamp(18px, 3.5vw, 28px);
        border: 1px solid rgba(212, 175, 55, 0.4); border-left: 5px solid var(--sapphire-primary);
    }

    .calendar-table {
        width: 100%; table-layout: fixed; border-collapse: separate; border-spacing: 4px;
        background: #ffffff; border-radius: 20px; padding: clamp(10px, 2vw, 16px);
    }
    .calendar-table th { background: var(--sapphire-primary); color: #fff; padding: clamp(8px, 1.5vw, 14px) 4px; border-radius: 10px; font-size: clamp(11px, 2vw, 14px); }
    .calendar-table td { padding: clamp(8px, 1.5vw, 14px) 4px; border-radius: 10px; text-align: center; background: #fafafa; cursor: pointer; font-size: clamp(12px, 2vw, 15px); }
    .calendar-table td.wedding-day { background: var(--gold-primary) !important; color: #fff !important; font-weight: bold; font-size: clamp(15px, 2.5vw, 20px); }

    /* Guest Wishes Wall */
    .wish-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 24px;
        border: 1px solid rgba(212, 175, 55, 0.35);
        border-left: 4px solid var(--gold-primary);
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .like-btn {
        background: none;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    /* Scroll Animations */
    .fade-in-up { opacity: 0; transform: translateY(35px); transition: all 0.9s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .fade-in-up.visible { opacity: 1; transform: translateY(0); }

    /* Phone Screen Responsive Optimization (Mobile Viewports <= 576px) */
    @media (max-width: 576px) {
        body { font-size: 18px !important; line-height: 1.75 !important; }
        .main-container { padding-left: 4px; padding-right: 4px; }
        .floral-card, .qr-section-card, .location-section-card { padding: 26px 14px; border-radius: 20px; }
        .gold-inner-frame { padding: 24px 12px; border-radius: 16px; }
        
        .gold-inner-frame h1.muol { font-size: 30px !important; line-height: 1.45 !important; }
        .invite-celebration-title { font-size: 17px !important; letter-spacing: 1px !important; margin: 16px 0 12px !important; font-weight: 700 !important; }
        
        .couple-name-title { font-size: 42px !important; line-height: 1.35 !important; font-weight: bold !important; }
        .couple-label { font-size: 18px !important; margin-bottom: 6px !important; font-weight: bold !important; }
        .couple-ampersand { font-size: 34px !important; margin: 14px 4px 0 !important; }

        .ido-badge { font-size: 34px !important; top: 12px !important; left: 14px !important; }
        .corner-floral-top-right, .corner-floral-bottom-left { font-size: 48px !important; }

        .date-card-flex { flex-direction: row; justify-content: space-around; gap: 8px !important; margin: 20px 0 !important; }
        .date-side-col { max-width: 125px !important; }
        .date-side-col span { font-size: 16px !important; padding: 6px 0 !important; font-weight: 600 !important; }
        .date-side-col small { font-size: 15px !important; }
        .date-month-label { font-size: 16.5px !important; font-weight: 600 !important; }
        .date-box-num { font-size: 72px !important; font-weight: bold !important; }
        .date-year-label { font-size: 17px !important; font-weight: 600 !important; }
        .reception-script { font-size: 38px !important; margin-top: 20px !important; }

        .gold-inner-frame h5.muol { font-size: 21px !important; line-height: 1.5 !important; }
        .gold-inner-frame p.text-muted { font-size: 17.5px !important; line-height: 1.75 !important; }
        .guest-frame-wrapper { margin: 16px 0 !important; }
        .guest-frame-text { font-size: 26px !important; font-weight: bold !important; }
        .gold-inner-frame h3.muol { font-size: 25px !important; }

        h2.muol, h3.muol, h4.muol { font-size: 25px !important; line-height: 1.5 !important; }
        .location-section-card p.text-secondary { font-size: 17.5px !important; line-height: 1.8 !important; }

        .countdown-grid { gap: 8px !important; }
        .countdown-box { min-width: 76px !important; padding: 12px 6px !important; border-radius: 16px !important; }
        .countdown-value { font-size: 34px !important; font-weight: bold !important; }
        .countdown-label { font-size: 15px !important; font-weight: bold !important; }

        .timeline-content { padding: 18px 20px !important; }
        .timeline-content h4 { font-size: 20px !important; font-weight: bold !important; }
        .timeline-content p { font-size: 16.5px !important; line-height: 1.65 !important; }
        .timeline-badge { width: 48px !important; height: 48px !important; font-size: 20px !important; }
        .timeline-item .fw-bold { font-size: 17.5px !important; }

        .calendar-table th { font-size: 15px !important; padding: 10px 2px !important; }
        .calendar-table td { font-size: 16px !important; padding: 10px 2px !important; }
        .calendar-table td.wedding-day { font-size: 22px !important; font-weight: bold !important; }

        .qr-section-card h4.muol { font-size: 23px !important; }
        .qr-section-card p.text-secondary { font-size: 17px !important; }

        .wish-card strong { font-size: 18px !important; }
        .wish-card p { font-size: 16.5px !important; }
        #wishName, #wishMessage { font-size: 17px !important; }

    }
</style>
@endpush

@section('content')

<!-- Ambient Floating Particles Canvas -->
<div class="floating-particles-canvas" id="heartsContainer"></div>

<!-- Theme Switcher Toggle Pill -->
<button class="theme-toggle-btn" id="themeToggleBtn">
    <i class="fas fa-gem" id="themeIcon"></i>
    <span id="themeText">Royal Sapphire</span>
</button>

<!-- Action Toast Banner -->
<div id="actionToast">
    <i class="fas fa-check-circle fs-4 text-warning"></i>
    <span id="actionToastMsg">សូមអរគុណចំពោះការឆ្លើយតបរបស់អ្នក!</span>
</div>

<!-- Interactive Envelope Opening Overlay Startup Screen (Grand Royal Gold & Pearl Silk Style) -->
<div id="envelopeOverlay">
    <div class="envelope-card text-center position-relative">


        <!-- Khmer Royal Decorative Corners -->
        <div class="khmer-corner corner-tl"></div>
        <div class="khmer-corner corner-tr"></div>
        <div class="khmer-corner corner-bl"></div>
        <div class="khmer-corner corner-br"></div>

        <!-- Header Royal Banner Badge -->
        <div class="royal-crest-badge">
            <span class="muol">⚜️ សិរីមង្គលអាពាហ៍ពិពាហ៍ ⚜️</span>
        </div>

        <!-- Sunburst Wax Seal -->
        <div class="envelope-wax-seal">
            <span>💎</span>
        </div>

        <!-- Couple Art / Logo -->
        <img src="{{ asset('assets/images/logo/wedding_logo.png') }}" class="img-fluid" alt="Wedding Logo">

        <!-- Main Khmer Royal Title -->
        <h2 class="muol royal-title">លិខិតអញ្ជើញអាពាហ៍ពិពាហ៍</h2>
        <p class="royal-subtitle">Royal Sapphire Wedding</p>

        <!-- Guest Name Pill Badge -->
        <div class="guest-name-pill">
            <span class="guest-label me-1">សូមគោរពអញ្ជើញ៖</span>
            <span class="muol guest-name">{{ $guestName }}</span>
        </div>

        <!-- Big Royal Crimson & Gold Action Button -->
        <button class="btn-royal-crimson muol" id="btnOpenEnvelope">
            <i class="fas fa-envelope-open-text me-2"></i>បើកលិខិតអញ្ជើញ
        </button>
    </div>
</div>

<!-- Music Player Widget -->
<div class="music-widget" id="musicWidget">
    <button class="music-btn" id="musicToggleBtn" title="Play/Pause Background Music">
        <i class="fas fa-music" id="musicIcon"></i>
    </button>
    <div class="equalizer-bars">
        <div class="equalizer-bar"></div>
        <div class="equalizer-bar"></div>
        <div class="equalizer-bar"></div>
        <div class="equalizer-bar"></div>
    </div>
</div>
<audio id="weddingAudio" loop preload="none">
    <source src="{{ asset('assets/audio/wedding-march.mp3') }}" type="audio/mpeg">
</audio>

<div class="container px-2 px-md-4 my-3 main-container">

    <!-- 1. Royal Sapphire & Gold Card Frame -->
    <div class="floral-card text-center" id="sec-home">
        <!-- Corner Floral Arrangement -->
        <div class="corner-floral-top-right">🌸 🌺 🌹 🌿</div>
        <div class="corner-floral-bottom-left">🌸 🌺 🌹 🌿</div>

        <!-- Inner Dual Gold Rectangular Border Frame -->
        <div class="gold-inner-frame">
            <!-- Top Left Script Badge -->
            <div class="ido-badge">
                I Do 💍
            </div>

            <!-- Kissing White Doves Header Illustration -->
            <div class="kissing-doves-wrapper fade-in-up">
                🕊️ 💕 🕊️
            </div>

            <!-- Header Title -->
            <div class="fade-in-up">
                <h1 class="muol text-dark fs-3 mb-1" style="font-size: clamp(26px, 6vw, 36px);">សិរីមង្គលអាពាហ៍ពិពាហ៍</h1>
                <p class="text-uppercase font-weight-bold mb-3" style="letter-spacing: 2px; color: var(--gold-primary); font-size: clamp(15px, 3.5vw, 20px);">Royal Wedding Celebration</p>
            </div>

            <!-- Groom & Bride Names Showcase -->
            <div class="fade-in-up my-3 py-1">
                <div class="d-flex justify-content-center align-items-center gap-2 gap-md-4 flex-wrap">
                    <div class="couple-name-box text-center">
                        <span class="couple-label">កូនប្រុស (Groom)</span>
                        <div class="couple-name-title">{{ isset($wedding) && $wedding->groom_name ? $wedding->groom_name : 'រ៉ាន់ រ៉ា' }}</div>
                    </div>
                    <div class="couple-ampersand">&</div>
                    <div class="couple-name-box text-center">
                        <span class="couple-label">កូនស្រី (Bride)</span>
                        <div class="couple-name-title">{{ isset($wedding) && $wedding->bride_name ? $wedding->bride_name : 'ខុម ស្រីណេត' }}</div>
                    </div>
                </div>
            </div>

            <!-- Invitation Text Title -->
            <div class="fade-in-up invite-celebration-title">
                CORDIONALLY INVITES YOU TO CELEBRATE THEIR MARRIAGE
            </div>

            <!-- Flanking Graphics Row -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-md-4 my-3 fade-in-up">
                <div class="graphic-flank-icon">⚜️</div>
                <img src="{{ asset('assets/images/logo/wedding_logo.png') }}" style="max-width: clamp(75px, 12vw, 105px);" class="img-fluid">
                <div class="graphic-flank-icon">⚜️</div>
            </div>

            <!-- Date Card Grid Layout -->
            <div class="date-card-flex fade-in-up">
                <div class="date-side-col">
                    <span>SUNDAY<br><small class="muol" style="font-size: clamp(14px, 3vw, 17px);">ថ្ងៃអាទិត្យ</small></span>
                </div>
                <div class="date-center-box">
                    <div class="date-month-label">APRIL / ខែមេសា</div>
                    <div class="date-box-num">{{ isset($wedding) && $wedding->event_date ? $wedding->event_date->format('d') : '11' }}</div>
                    <div class="date-year-label">{{ isset($wedding) && $wedding->event_date ? $wedding->event_date->format('Y') : '2027' }}</div>
                </div>
                <div class="date-side-col">
                    <span>AT {{ isset($wedding) && $wedding->morning_time ? $wedding->morning_time : '9:00 AM' }}<br><small class="muol" style="font-size: clamp(14px, 3vw, 17px);">{{ isset($wedding) && $wedding->morning_time ? $wedding->morning_time : 'ម៉ោង ៩៖០០ ព្រឹក' }}</small></span>
                </div>
            </div>

            <!-- Traditional Khmer Date Subtitle -->
            <div class="fade-in-up my-3">
                <h5 class="muol" style="color: var(--gold-primary); font-size: clamp(19px, 4vw, 24px);">{{ isset($wedding) && $wedding->lunar_date ? $wedding->lunar_date : 'ថ្ងៃអាទិត្យ ៥កើត ខែចេត្រ ឆ្នាំមមី អដ្ឋស័ក ពុទ្ធសករាជ ២៥៧០' }}</h5>
                <p class="text-muted font-weight-bold" style="font-size: clamp(16px, 3.2vw, 19px);">ត្រូវនឹងថ្ងៃទី{{ isset($wedding) && $wedding->event_date ? $wedding->event_date->format('d') : '១១' }} ខែ{{ isset($wedding) && $wedding->event_date ? $wedding->event_date->format('m') : 'មេសា' }} ឆ្នាំ{{ isset($wedding) && $wedding->event_date ? $wedding->event_date->format('Y') : '២០២៧' }}</p>
            </div>

            <!-- Guest Invitation Badge -->
            <div class="fade-in-up mt-4 pt-3 border-top border-warning border-opacity-50">
                <h3 class="muol text-dark" style="font-size: clamp(24px, 5vw, 30px);">សូមគោរពអញ្ជើញ</h3>
                <div class="guest-frame-wrapper">
                    <img src="{{ asset('assets/images/name-frame-kbach.png') }}" class="guest-frame-img" alt="Frame">
                    <div class="guest-frame-text muol">{{ $guestName }}</div>
                </div>
                <p class="text-muted mt-2 px-1 px-md-5" style="line-height: 1.85; font-size: clamp(16px, 3.5vw, 20px);">
                    ដើម្បីចូលរួមជាអធិបតី និងប្រសិទ្ធពរជ័យ សិរីសួស្ដី មង្គលវិបុលសុខ ក្នុងពិធីអាពាហ៍ពិពាហ៍កូនប្រុស កូនស្រី របស់យើងខ្ញុំ
                </p>
            </div>

            <!-- Bottom Cursive Script -->
            <div class="reception-script fade-in-up">
                Reception to follow • សូមអញ្ជើញពិសាភោជនអាហារ
            </div>
        </div>
    </div>

    <!-- 2. Dedicated Standalone Location Map Card -->
    <div class="card location-section-card text-center fade-in-up" id="sec-location">
        <div class="mb-1" style="font-size: 28px;">🌿 💎 🌿</div>
        <h3 class="muol text-dark mb-3" style="font-size: clamp(24px, 5vw, 32px);"><i class="fas fa-map-marker-alt me-2" style="color: var(--gold-primary);"></i>ទីតាំងប្រារព្ធកម្មវិធី (Event Location)</h3>
        <p class="text-secondary mb-4" style="line-height: 1.8; font-size: clamp(17px, 3.5vw, 21px);">
            ស្ថិតនៅគេហដ្ឋានខាងស្រី ភូមិព្រៃខ្លាទី១ ឃុំព្រៃខ្លា ស្រុកស្វាយអន្ទរ ខេត្តព្រៃវែង
        </p>

        <div class="my-3">
            <img src="{{ asset('assets/images/Location.png') }}" class="location-preview-img img-fluid" alt="Map Location Preview" onclick="window.open('https://maps.app.goo.gl/mB65Fwu3L9natdqr6', '_blank')">
        </div>

        <div class="mt-4">
            <a href="https://maps.app.goo.gl/mB65Fwu3L9natdqr6" target="_blank" class="btn btn-action-gold text-decoration-none">
                <i class="fas fa-directions me-2"></i>មើលទីតាំងលើ Google Maps
            </a>
        </div>
    </div>

    <!-- 3. Attendance / RSVP Interactive Action Card -->
    <div class="card floral-card p-4 fade-in-up text-center">
        <h4 class="muol mb-3" style="color: var(--sapphire-primary); font-size: clamp(23px, 4.8vw, 30px);"><i class="fas fa-user-check me-2"></i>ការឆ្លើយតបការចូលរួម (RSVP)</h4>
        <div class="d-flex justify-content-center gap-2 gap-md-3 flex-wrap">
            <button class="btn btn-outline-primary rounded-pill px-3 px-md-4 py-2 fw-bold" id="btnRsvpYes" style="font-size: clamp(16.5px, 3.2vw, 19.5px); color: var(--sapphire-primary); border-color: var(--sapphire-primary);">
                <i class="fas fa-check-circle me-1"></i>នឹងចូលរួម (Attending)
            </button>
            <button class="btn btn-outline-danger rounded-pill px-3 px-md-4 py-2 fw-bold" id="btnRsvpNo" style="font-size: clamp(16.5px, 3.2vw, 19.5px);">
                <i class="fas fa-times-circle me-1"></i>មិនបានចូលរួម (Decline)
            </button>
        </div>
    </div>

    <!-- 4. Live Countdown Timer Card -->
    <div class="card floral-card p-3 p-md-5 fade-in-up text-center" id="sec-calendar">
        <h3 class="muol text-dark mb-3" style="font-size: clamp(23px, 4.8vw, 30px);">រាប់ថយក្រោយដល់ថ្ងៃសិរីមង្គល</h3>
        <div class="countdown-grid">
            <div class="countdown-box">
                <div class="countdown-value" id="cd-days">00</div>
                <div class="countdown-label muol">ថ្ងៃ</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="cd-hours">00</div>
                <div class="countdown-label muol">ម៉ោង</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="cd-minutes">00</div>
                <div class="countdown-label muol">នាទី</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="cd-seconds">00</div>
                <div class="countdown-label muol">វិនាទី</div>
            </div>
        </div>
    </div>

    <!-- 5. Wedding Program Schedule Timeline -->
    <div class="card floral-card p-3 p-md-5">
        <h2 class="text-center muol text-dark mb-3" style="font-size: clamp(24px, 5vw, 32px);"><i class="fas fa-glass-cheers me-2" style="color: var(--gold-primary);"></i>របៀបវារៈកម្មវិធី</h2>

        <!-- Timeline Day Action Filter Bar -->
        <div class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
            <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold timeline-filter-btn active" onclick="filterTimelineDay('all', this)">
                <i class="fas fa-list-ul me-1"></i>កម្មវិធីទាំងអស់ (All)
            </button>
            <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold timeline-filter-btn" onclick="filterTimelineDay('day1', this)">
                <i class="far fa-calendar-alt me-1"></i>ថ្ងៃទី០១ (Day 1)
            </button>
            <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold timeline-filter-btn" onclick="filterTimelineDay('day2', this)">
                <i class="far fa-calendar-check me-1"></i>ថ្ងៃទី០២ (Day 2)
            </button>
        </div>

        <!-- Day 1 Schedule Block -->
        <div class="day-schedule-block mb-5">
            <div class="day-schedule-header text-center mb-4">
                <div class="d-inline-flex align-items-center gap-2 px-3 px-md-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, var(--sapphire-primary, #0f4c81) 0%, var(--gold-primary, #d4af37) 100%); color: #ffffff;">
                    <i class="far fa-calendar-alt fs-5"></i>
                    <span class="muol" style="font-size: clamp(16px, 3.5vw, 20px);">កម្មវិធីថ្ងៃទី០១ — ថ្ងៃសៅរ៍ ទី១០ ខែធ្នូ ឆ្នាំ២០២៥</span>
                </div>
            </div>

            <div class="timeline">
                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">02:00 PM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-fire-alt"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីសែនក្រុងពាលី</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">រៀបចំពិធីសែនក្រុងពាលីសុំម្ចាស់ទឹកម្ចាស់ដី និងសិរីសួស្ដី</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">03:00 PM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-pray"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីសូត្រមន្តចំរើនព្រះបរិត្ត</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">និមន្តព្រះសង្ឃសូត្រមន្តចំរើនព្រះបរិត្តលើករាសី ប្រសិទ្ធពរជ័យ</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">05:00 PM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-utensils"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">អញ្ជើញភ្ញៀវកិត្តិយសពិសាអាហារពេលល្ងាច</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ពិសាអាហារពេលល្ងាច ជួបជុំសាច់ញាតិ មិត្តភក្តិ និងភ្ញៀវកិត្តិយស</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Day 2 Schedule Block -->
        <div class="day-schedule-block">
            <div class="day-schedule-header text-center mb-4">
                <div class="d-inline-flex align-items-center gap-2 px-3 px-md-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, var(--sapphire-primary, #0f4c81) 0%, var(--gold-primary, #d4af37) 100%); color: #ffffff;">
                    <i class="far fa-calendar-check fs-5"></i>
                    <span class="muol" style="font-size: clamp(16px, 3.5vw, 20px);">កម្មវិធីថ្ងៃទី០២ — ថ្ងៃអាទិត្យ ទី១១ ខែធ្នូ ឆ្នាំ២០២៥</span>
                </div>
            </div>

            <div class="timeline">
                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">06:30 AM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ជួបជុំភ្ញៀវកិត្តិយសរៀបចំហែជំនូន</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ជួបជុំភ្ញៀវកិត្តិយស ញាតិមិត្តជិតឆ្ងាយ រៀបចំក្បួនហែជំនូន</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">07:00 AM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-walking"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីហែជំនូន (កំណត់)</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ក្បួនហែជំនូនចូលដល់គេហដ្ឋានខាងស្រី តាមពេលវេលាកំណត់</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">07:30 AM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-comments"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីហៅចៅមហានិយាយជើងការ</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ពិធីសន្ទនារវាងចៅមហា និងលោកមេបា តាមប្រពៃណីខ្មែរ</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">08:30 AM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-ring"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីបំពាក់ចិញ្ចៀន</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">កូនប្រុស កូនស្រី ផ្លាស់ប្តូរ និងបំពាក់ចិញ្ចៀនអាពាហ៍ពិពាហ៍</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">09:15 AM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-cut"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីកាត់សក់បង្កក់សិរី</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ពិធីកាត់សក់បង្កក់សិរីសួស្ដី ជម្រះឧបទ្រពចង្រៃ ទទួលសិរីមង្គល</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">11:00 AM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-ribbon"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ពិធីបង្វិលពពិល សំពះផ្ទឹម សែនចងដៃ ព្រះថោងនាងនាគ</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ពិធីបង្វិលពពិល ផ្ទឹមសំពះចងដៃ និងតោងស្បៃព្រះថោងតោងស្បៃនាងនាគ</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up mb-3">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">12:00 PM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-sun"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">អញ្ជើញភ្ញៀវកិត្តិយសពិសាអាហារថ្ងៃត្រង់</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ពិសាអាហារថ្ងៃត្រង់អបអរសាទរពិធីមង្គលជ័យ</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center timeline-item fade-in-up">
                    <div class="col-3 col-md-2 text-center text-md-end fw-bold" style="color: var(--sapphire-primary, #0f4c81); font-size: clamp(16px, 3.2vw, 19.5px);">05:00 PM</div>
                    <div class="col-2 col-md-1 text-center">
                        <div class="timeline-badge"><i class="fas fa-glass-cheers"></i></div>
                    </div>
                    <div class="col-7 col-md-9">
                        <div class="timeline-content">
                            <h4 class="muol mb-1 text-dark" style="font-size: clamp(17.5px, 3.5vw, 21.5px);">ទទួលបដិសណ្ឋារកិច្ច និងអញ្ជើញភ្ញៀវកិត្តិយសពិសាភោជនាហារ</h4>
                            <p class="text-muted mb-0" style="font-size: clamp(15px, 3vw, 18px);">ទទួលបដិសណ្ឋារកិច្ចយ៉ាងកក់ក្តៅ និងពិសាភោជនាហារ រាំកម្សាន្ត</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Khmer Calendar Section -->
    <div class="card floral-card p-3 p-md-5 text-center fade-in-up">
        <h3 class="muol text-dark mb-3" style="font-size: clamp(24px, 5vw, 32px);"><i class="far fa-calendar-alt me-2" style="color: var(--gold-primary);"></i>ប្រតិទិនថ្ងៃរៀបចំកម្មវិធី</h3>
        @php
            use Carbon\Carbon;
            $weddingDateObj = Carbon::create(2027, 4, 11);
            $monthTitle = $weddingDateObj->locale('km')->isoFormat('MMMM YYYY');
            $startOfMonth = $weddingDateObj->copy()->startOfMonth();
            $totalDays = $weddingDateObj->daysInMonth;
            $firstDayWeek = $startOfMonth->dayOfWeek;
        @endphp

        <h4 class="muol text-muted mb-3" style="font-size: clamp(18px, 3.8vw, 22px);">{{ $monthTitle }}</h4>
        <div class="table-responsive">
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th class="muol">អាទិត្យ</th>
                        <th class="muol">ចន្ទ</th>
                        <th class="muol">អង្គារ</th>
                        <th class="muol">ពុធ</th>
                        <th class="muol">ព្រហស្បតិ៍</th>
                        <th class="muol">សុក្រ</th>
                        <th class="muol">សៅរ៍</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currDay = 1; @endphp
                    @for($r = 0; $r < 6; $r++)
                        <tr>
                            @for($c = 0; $c < 7; $c++)
                                @if($r === 0 && $c < $firstDayWeek)
                                    <td></td>
                                @elseif($currDay > $totalDays)
                                    <td></td>
                                @else
                                    <td class="{{ $weddingDateObj->day == $currDay ? 'wedding-day' : '' }}" onclick="selectCalendarDate(this, {{ $currDay }})">
                                        {{ $currDay }}
                                    </td>
                                    @php $currDay++; @endphp
                                @endif
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- 7. Photo Gallery Section Grid -->
    <div class="card gallery-section-card p-2 p-md-4 fade-in-up text-center" id="sec-gallery">
        <div class="gallery-bg-pattern">
            <div class="mb-1" style="font-size: 28px;">🌸 💎 🏵️</div>
            <h2 class="muol text-dark mb-2" style="font-size: clamp(24px, 5vw, 32px);"><i class="fas fa-camera-retro me-2" style="color: var(--gold-primary);"></i>រូបថតអនុស្សាវរីយ៍</h2>
            <p class="text-muted mb-3 mb-md-4" style="font-size: clamp(16px, 3.2vw, 19px);">រូបថតមុនអាពាហ៍ពិពាហ៍របស់កូនប្រុស កូនស្រី</p>
            
            <div class="custom-wedding-gallery">
                <!-- Row 1: 2 Side-by-Side Vertical Portrait Photos -->
                <div class="row g-2 g-md-3 mb-2 mb-md-3">
                    <div class="col-6">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage1.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage1.jpg') }}" alt="Pre-wedding Photo 1">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage2.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage2.jpg') }}" alt="Pre-wedding Photo 2">
                        </div>
                    </div>
                </div>

                <!-- Row 2: 3 Side-by-Side Vertical Portrait Photos -->
                <div class="row g-2 g-md-3 mb-2 mb-md-3">
                    <div class="col-4">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage3.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage3.jpg') }}" alt="Pre-wedding Photo 3">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage4.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage4.jpg') }}" alt="Pre-wedding Photo 4">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage5.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage5.jpg') }}" alt="Pre-wedding Photo 5">
                        </div>
                    </div>
                </div>

                <!-- Row 3: 2 Side-by-Side Vertical Portrait Photos -->
                <div class="row g-2 g-md-3 mb-2 mb-md-3">
                    <div class="col-6">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage6.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage6.jpg') }}" alt="Pre-wedding Photo 6">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="gallery-card portrait-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage7.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage7.jpg') }}" alt="Pre-wedding Photo 7">
                        </div>
                    </div>
                </div>

                <!-- Row 4: 1 Full-Width Horizontal Landscape Banner Photo -->
                <div class="row g-2 g-md-3">
                    <div class="col-12">
                        <div class="gallery-card landscape-hero-card" onclick="openPhotoModal('{{ asset('assets/images/gallery/myimage8.jpg') }}')">
                            <img src="{{ asset('assets/images/gallery/myimage8.jpg') }}" alt="Pre-wedding Photo 8">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 8. Digital Gift Section Card -->
    <div class="card qr-section-card text-center fade-in-up" id="sec-qr">
        <div class="khmer-corner corner-tl"></div>
        <div class="khmer-corner corner-tr"></div>
        <div class="khmer-corner corner-bl"></div>
        <div class="khmer-corner corner-br"></div>

        <h2 class="muol text-dark mb-2" style="font-size: clamp(22px, 4.8vw, 30px);">ចំណងដៃអាពាហ៍ពិពាហ៍ (Digital Gift)</h2>
        <p class="text-secondary mb-3" style="font-size: clamp(15px, 3vw, 18px);">សម្រាប់លោកអ្នកដែលមានបំណងផ្ញើពរជ័យ និងចំណងដៃតាមរយៈ: KHQR ABA Bank</p>

        <div class="qr-header-badge mb-3">
            <i class="fas fa-university me-1"></i> ABA Bank KHQR
        </div>

        <div class="qr-img-wrapper mb-3" onclick="openQrModal(event);" style="cursor: pointer;" title="ចុចដើម្បីមើល QR ពេញអេក្រង់">
            <img src="{{ isset($wedding) && $wedding->bank_qr_image ? asset($wedding->bank_qr_image) : asset('assets/images/QR.jpg') }}" class="qr-standee-img img-fluid" alt="ABA Bank KHQR Code">
            <div class="qr-zoom-hint">
                <i class="fas fa-search-plus me-1"></i> ចុចលើរូបដើម្បីពង្រីក
            </div>
        </div>

        <h4 class="muol text-dark mt-2 mb-1" style="font-size: clamp(20px, 4vw, 24px);">រ៉ាន់ រ៉ា & ខុម ស្រីណេត</h4>

        <div class="acc-number-pill my-3" id="mainAccPill" style="cursor: pointer;" title="ចុចដើម្បីចម្លង">
            <span class="acc-num-text">000 123 456</span>
            <span class="acc-bank-label">ABA Bank</span>
            <i class="far fa-copy copy-icon ms-1"></i>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mt-1">
            <button class="btn btn-copy-acc shadow-sm" id="btnCopyAccNum" type="button">
                <i class="far fa-copy me-1"></i> ចម្លងលេខគណនី
            </button>
            <button class="btn btn-view-qr-full" onclick="openQrModal(event);" type="button">
                <i class="fas fa-expand me-1"></i> មើល QR ពេញអេក្រង់
            </button>
        </div>
    </div>

    <!-- KHQR Gift Modal -->
    <div class="modal fade" id="qrGiftModal" tabindex="-1" aria-labelledby="qrGiftModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header border-0 pb-0 justify-content-between align-items-center p-3 p-md-4" style="background: linear-gradient(135deg, rgba(30,60,114,0.12) 0%, rgba(212,175,55,0.1) 100%);">
                    <h5 class="modal-title muol fs-4 text-dark mb-0" id="qrGiftModalLabel">
                        <i class="fas fa-qrcode me-2" style="color: var(--sapphire-primary);"></i>ចំណងដៃអាពាហ៍ពិពាហ៍
                    </h5>
                    <button type="button" class="btn-close rounded-circle p-2 bg-light shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-3 p-md-4">
                    <img src="{{ asset('assets/images/logo/wedding_logo.png') }}" style="max-width: 80px;" class="mb-2">
                    <h4 class="muol text-dark mb-1" style="font-size: clamp(20px, 4vw, 24px);">រ៉ាន់ រ៉ា & ខុម ស្រីណេត</h4>
                    <p class="text-muted mb-3" style="font-size: clamp(15px, 3vw, 17.5px);">សូមអរគុណយ៉ាងជ្រាលជ្រៅចំពោះទឹកចិត្ត និងពរជ័យដ៏ប្រពៃ!</p>
                    
                    <div class="p-3 bg-white rounded-4 d-inline-block border border-primary border-opacity-50 shadow-sm mb-3" onclick="copyAccNum(event);" style="max-width: 320px; cursor: pointer;" title="ចុចដើម្បីចម្លងលេខគណនី">
                        <img src="{{ asset('assets/images/QR.jpg') }}" id="modalQrImg" style="max-width: 100%; border-radius: 14px;" class="img-fluid" alt="ABA Bank KHQR Code">
                    </div>

                    <div class="bg-light p-3 rounded-4 border mb-3 text-center shadow-sm">
                        <small class="text-muted d-block mb-1" style="font-size: 13px;">ឈ្មោះគណនី (Account Name)</small>
                        <strong class="muol text-dark d-block mb-2" style="font-size: clamp(17px, 3.5vw, 20px); color: var(--sapphire-primary) !important;">RAN RA & KHOM SREYNET</strong>
                        <small class="text-muted d-block mb-1" style="font-size: 13px;">លេខគណនី (ABA Bank Account Number)</small>
                        <div class="d-inline-flex align-items-center gap-2 bg-white px-3 py-1.5 rounded-pill border shadow-xs">
                            <strong class="font-monospace fs-5 text-dark mb-0" style="letter-spacing: 1px;">000 123 456</strong>
                            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;">ABA Bank</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <button class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm" id="btnCopyAccModal" style="background-color: var(--sapphire-primary); border: none;">
                            <i class="far fa-copy me-1.5"></i>ចម្លងលេខគណនី
                        </button>
                        <a href="{{ asset('assets/images/QR.jpg') }}" id="modalQrDownloadBtn" download="wedding_qr.jpg" class="btn btn-outline-dark rounded-pill px-4 py-2.5 fw-bold text-decoration-none shadow-sm">
                            <i class="fas fa-download me-1.5"></i>ទាញយក QR Code
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Lightbox Modal -->
    <div class="custom-photo-lightbox" id="photoModal" onclick="closePhotoModal();">
        <button type="button" class="custom-photo-close-btn" onclick="closePhotoModal();" aria-label="Close">
            <i class="fas fa-times"></i><span>បិទ</span>
        </button>
        <div class="custom-photo-lightbox-content" onclick="event.stopPropagation();">
            <button class="custom-photo-nav-btn custom-photo-nav-prev" id="btnPrevPhoto" onclick="navigatePhoto(-1); event.stopPropagation();">
                <i class="fas fa-chevron-left"></i>
            </button>

            <img src="" id="photoModalImg" class="custom-photo-lightbox-img" alt="Enlarged Photo">

            <button class="custom-photo-nav-btn custom-photo-nav-next" id="btnNextPhoto" onclick="navigatePhoto(1); event.stopPropagation();">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- 9. Guest Wishes / Best Wishes Section -->
    <div class="card floral-card p-3 p-md-5 fade-in-up" id="sec-wishes">
        <h3 class="text-center muol text-dark mb-3" style="font-size: clamp(24px, 5vw, 32px);"><i class="fas fa-heart me-2" style="color: var(--sapphire-primary);"></i>សារជូនពរជ័យ</h3>
        <p class="text-center text-muted mb-4" style="font-size: clamp(16px, 3.2vw, 19px);">សូមបញ្ជូនសារជូនពរ និងពាក្យពេចន៍ល្អៗជូនដល់គូស្វាមីភរិយាថ្មី</p>

        <form id="wishForm" class="mb-4">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" id="wishName" class="form-control form-control-lg border-primary shadow-sm rounded-3" placeholder="ឈ្មោះរបស់អ្នក (Your Name)" value="{{ $guestName !== 'សម្លាញ់ ធាសុធី' ? $guestName : '' }}" required style="font-size: clamp(17px, 3.5vw, 20px);">
                </div>
                <div class="col-md-7">
                    <input type="text" id="wishMessage" class="form-control form-control-lg border-primary shadow-sm rounded-3" placeholder="សារជូនពរ (Your Wish)" required style="font-size: clamp(17px, 3.5vw, 20px);">
                </div>
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn-action-gold">
                        <i class="fas fa-paper-plane me-2"></i>ផ្ញើសារជូនពរ
                    </button>
                </div>
            </div>
        </form>

        <div id="wishesList" class="mt-4">
            <div class="wish-card">
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="muol text-dark" style="font-size: clamp(17.5px, 3.5vw, 21px);"><i class="fas fa-user-circle me-2" style="color: var(--sapphire-primary);"></i>សម្លាញ់ ធាសុធី</strong>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-muted"><i class="far fa-clock me-1"></i>ទើបតែផ្ញើ</small>
                        <button class="like-btn" onclick="toggleLike(this)"><i class="fas fa-heart me-1" style="color: var(--sapphire-primary);"></i><span class="like-count">24</span></button>
                    </div>
                </div>
                <p class="text-secondary mb-0 mt-2" style="font-size: clamp(16.5px, 3.2vw, 19.5px);">សូមជូនពរមិត្តទាំងពីរជួបតែសេចក្ដីសុខ សុភមង្គល និងស្រឡាញ់គ្នារហូតដល់ចាស់កោងខ្នង!</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-4 mb-3">
        <p class="text-muted font-monospace">&copy; {{ date('Y') }} Ran Ra. All Rights Reserved.</p>
    </div>

</div>
@endsection

@push('script')
<script>
function showToast(msg) {
    const toast = document.getElementById('actionToast');
    const toastMsg = document.getElementById('actionToastMsg');
    if (toast && toastMsg) {
        toastMsg.innerText = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3500);
    }
}

function selectCalendarDate(td, day) {
    if (day === 11) {
        showToast('✨ ថ្ងៃទី១១ ខែមេសា ឆ្នាំ២០២៧ ជាថ្ងៃសិរីមង្គលអាពាហ៍ពិពាហ៍!');
    } else {
        showToast(`📅 លោកអ្នកបានចុចលើថ្ងៃទី${day} ខែមេសា ឆ្នាំ២០២៧`);
    }
}

function toggleLike(btn) {
    const countSpan = btn.querySelector('.like-count');
    let count = parseInt(countSpan.innerText) || 0;
    if (btn.classList.contains('liked')) {
        btn.classList.remove('liked');
        count--;
    } else {
        btn.classList.add('liked');
        count++;
        btn.style.transform = 'scale(1.25)';
        setTimeout(() => btn.style.transform = 'scale(1)', 200);
    }
    countSpan.innerText = count;
}

const galleryImagesList = [
    "{{ asset('assets/images/gallery/myimage1.jpg') }}",
    "{{ asset('assets/images/gallery/myimage2.jpg') }}",
    "{{ asset('assets/images/gallery/myimage3.jpg') }}",
    "{{ asset('assets/images/gallery/myimage4.jpg') }}",
    "{{ asset('assets/images/gallery/myimage5.jpg') }}",
    "{{ asset('assets/images/gallery/myimage6.jpg') }}",
    "{{ asset('assets/images/gallery/myimage7.jpg') }}",
    "{{ asset('assets/images/gallery/myimage8.jpg') }}"
];
let currentPhotoIndex = 0;

function openPhotoModal(src) {
    try {
        if (!src) return;
        const index = galleryImagesList.indexOf(src);
        const photoModalImg = document.getElementById('photoModalImg');
        const modalEl = document.getElementById('photoModal');
        const btnPrev = document.getElementById('btnPrevPhoto');
        const btnNext = document.getElementById('btnNextPhoto');

        if (index !== -1) {
            currentPhotoIndex = index;
            if (btnPrev) btnPrev.style.display = 'flex';
            if (btnNext) btnNext.style.display = 'flex';
        } else {
            currentPhotoIndex = -1;
            if (btnPrev) btnPrev.style.display = 'none';
            if (btnNext) btnNext.style.display = 'none';
        }

        if (photoModalImg) {
            photoModalImg.src = src;
        }

        if (modalEl) {
            modalEl.classList.add('show');
            document.body.classList.add('lightbox-open');
            document.body.style.overflow = 'hidden';
        }
    } catch (err) {
        console.error('Photo Modal Error:', err);
    }
}

function closePhotoModal() {
    try {
        const modalEl = document.getElementById('photoModal');
        if (modalEl) {
            modalEl.classList.remove('show');
            document.body.classList.remove('lightbox-open');
            document.body.style.overflow = '';
        }
    } catch (err) {
        console.error('Close Modal Error:', err);
    }
}

function navigatePhoto(direction) {
    if (galleryImagesList.length === 0 || currentPhotoIndex === -1) return;
    currentPhotoIndex = (currentPhotoIndex + direction + galleryImagesList.length) % galleryImagesList.length;
    const photoModalImg = document.getElementById('photoModalImg');
    if (photoModalImg) {
        photoModalImg.style.opacity = '0.3';
        setTimeout(() => {
            photoModalImg.src = galleryImagesList[currentPhotoIndex];
            photoModalImg.style.opacity = '1';
        }, 120);
    }
}

document.addEventListener('keydown', function (e) {
    const modalEl = document.getElementById('photoModal');
    if (modalEl && (modalEl.classList.contains('show') || modalEl.style.display === 'block')) {
        if (e.key === 'ArrowLeft') {
            navigatePhoto(-1);
        } else if (e.key === 'ArrowRight') {
            navigatePhoto(1);
        } else if (e.key === 'Escape') {
            closePhotoModal();
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {

    // Ambient Floating Particles
    const heartsContainer = document.getElementById('heartsContainer');
    if (heartsContainer) {
        // Butterflies
        const butterflyEmojis = ['🦋', '✨', '🦋', '✨'];
        for (let i = 0; i < 7; i++) {
            const b = document.createElement('div');
            b.className = 'butterfly-particle';
            b.innerHTML = `<span class="butterfly-wings">${butterflyEmojis[i % butterflyEmojis.length]}</span>`;
            b.style.left = (Math.random() * 75) + 'vw';
            b.style.animationDuration = (22 + Math.random() * 14) + 's';
            b.style.animationDelay = (i * 3.5) + 's';
            b.style.fontSize = (22 + Math.random() * 14) + 'px';
            heartsContainer.appendChild(b);
        }

        // Falling Flower Petals & Gold Stars
        const flowerEmojis = ['🌸', '🌺', '🏵️', '✨', '💎', '💐'];
        for (let i = 0; i < 16; i++) {
            const f = document.createElement('div');
            f.className = 'flower-petal';
            f.innerText = flowerEmojis[i % flowerEmojis.length];
            f.style.left = Math.random() * 100 + 'vw';
            f.style.animationDuration = (18 + Math.random() * 12) + 's';
            f.style.animationDelay = (Math.random() * 8) + 's';
            f.style.fontSize = (14 + Math.random() * 14) + 'px';
            heartsContainer.appendChild(f);
        }
    }

    // Copy ABA Account Number
    function copyAccNum(e) {
        if (e && e.preventDefault) e.preventDefault();
        const accNum = '000 123 456';
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(accNum).then(() => {
                showToast('📋 បានចម្លងលេខគណនី ABA Bank: ' + accNum);
            }).catch(() => fallbackCopyAcc(accNum));
        } else {
            fallbackCopyAcc(accNum);
        }
    }
    window.copyAccNum = copyAccNum;

    function fallbackCopyAcc(text) {
        try {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.top = '0';
            textArea.style.left = '0';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showToast('📋 បានចម្លងលេខគណនី ABA Bank: ' + text);
        } catch (err) {
            showToast('📋 លេខគណនី ABA Bank: ' + text);
        }
    }
    window.fallbackCopyAcc = fallbackCopyAcc;

    // Open KHQR image using custom photo lightbox (same as gallery photo popup)
    function openQrModal(e, customSrc) {
        if (e && e.preventDefault) e.preventDefault();
        if (e && e.stopPropagation) e.stopPropagation();
        try {
            let imgSrc = customSrc;
            if (!imgSrc && e && e.currentTarget) {
                const target = e.currentTarget;
                const imgEl = target.tagName === 'IMG' ? target : 
                              (target.querySelector('img') || 
                              (target.closest('#sec-qr') ? target.closest('#sec-qr').querySelector('.qr-standee-img') : null));
                if (imgEl && imgEl.src) imgSrc = imgEl.src;
            }
            if (!imgSrc) {
                imgSrc = "{{ asset('assets/images/QR.jpg') }}";
            }
            if (typeof openPhotoModal === 'function') {
                openPhotoModal(imgSrc);
            }
        } catch (err) {
            console.error('QR Lightbox error:', err);
        }
    }
    window.openQrModal = openQrModal;
    window.openPhotoModal = openPhotoModal;
    window.closePhotoModal = closePhotoModal;

    const btnCopyAccNum = document.getElementById('btnCopyAccNum');
    const btnCopyAccModal = document.getElementById('btnCopyAccModal');
    const mainAccPill = document.getElementById('mainAccPill');
    if (btnCopyAccNum) btnCopyAccNum.addEventListener('click', copyAccNum);
    if (btnCopyAccModal) btnCopyAccModal.addEventListener('click', copyAccNum);
    if (mainAccPill) mainAccPill.addEventListener('click', copyAccNum);

    // Theme Switcher Mode (Royal Sapphire vs Dark Starlight Sapphire)
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    let isDark = false;
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function () {
            isDark = !isDark;
            if (isDark) {
                document.body.classList.add('dark-mode');
                showToast('🌙 ផ្លាស់ប្ដូរទៅជា Dark Starlight Sapphire Theme!');
            } else {
                document.body.classList.remove('dark-mode');
                showToast('💎 ផ្លាស់ប្ដូរទៅជា Royal Sapphire Gold Theme!');
            }
        });
    }

    // RSVP Actions
    const btnRsvpYes = document.getElementById('btnRsvpYes');
    const btnRsvpNo = document.getElementById('btnRsvpNo');
    if (btnRsvpYes) {
        btnRsvpYes.addEventListener('click', function () {
            showToast('🎉 សូមអរគុណចំពោះការឆ្លើយតបចូលរួម!');
        });
    }
    if (btnRsvpNo) {
        btnRsvpNo.addEventListener('click', function () {
            showToast('សូមអរគុណចំពោះការជម្រាបជូន!');
        });
    }

    // Audio & Envelope
    const audio = document.getElementById('weddingAudio');
    const musicWidget = document.getElementById('musicWidget');
    const musicBtn = document.getElementById('musicToggleBtn');
    const musicIcon = document.getElementById('musicIcon');
    const envelopeOverlay = document.getElementById('envelopeOverlay');
    const btnOpenEnvelope = document.getElementById('btnOpenEnvelope');
    let isPlaying = false;

    function playAudio() {
        if (audio) {
            audio.play().then(() => {
                isPlaying = true;
                if (musicWidget) musicWidget.classList.add('playing');
                if (musicIcon) musicIcon.className = 'fas fa-pause';
            }).catch(err => console.log('Audio error:', err));
        }
    }

    function handleOpenEnvelope() {
        if (!envelopeOverlay) return;
        envelopeOverlay.style.pointerEvents = 'none';
        envelopeOverlay.style.opacity = '0';
        envelopeOverlay.style.transform = 'scale(1.05)';
        envelopeOverlay.classList.add('hide-overlay');
        setTimeout(() => {
            envelopeOverlay.style.display = 'none';
        }, 400);
        playAudio();
        if (typeof showToast === 'function') {
            showToast('💎 សូមស្វាគមន៍មកកាន់លិខិតអញ្ជើញ!');
        }
    }

    if (btnOpenEnvelope) {
        btnOpenEnvelope.addEventListener('click', handleOpenEnvelope);
    }

    if (musicBtn && audio) {
        musicBtn.addEventListener('click', function () {
            if (isPlaying) {
                audio.pause();
                if (musicWidget) musicWidget.classList.remove('playing');
                if (musicIcon) musicIcon.className = 'fas fa-music';
            } else {
                playAudio();
            }
            isPlaying = !isPlaying;
        });
    }

    // Live Countdown Timer
    const weddingTargetDate = new Date("April 11, 2027 09:00:00").getTime();
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = weddingTargetDate - now;

        if (distance <= 0) {
            document.getElementById('cd-days').innerText = "00";
            document.getElementById('cd-hours').innerText = "00";
            document.getElementById('cd-minutes').innerText = "00";
            document.getElementById('cd-seconds').innerText = "00";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('cd-days').innerText = String(days).padStart(2, '0');
        document.getElementById('cd-hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('cd-minutes').innerText = String(minutes).padStart(2, '0');
        document.getElementById('cd-seconds').innerText = String(seconds).padStart(2, '0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Scroll Animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

    // Wishes Form
    const wishForm = document.getElementById('wishForm');
    const wishesList = document.getElementById('wishesList');

    if (wishForm) {
        wishForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const name = document.getElementById('wishName').value.trim();
            const msg = document.getElementById('wishMessage').value.trim();
            if (!name || !msg) return;

            const card = document.createElement('div');
            card.className = 'wish-card fade-in-up visible';
            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="muol text-dark" style="font-size: clamp(14px, 2.5vw, 16px);"><i class="fas fa-user-circle me-2" style="color: var(--sapphire-primary);"></i>${name}</strong>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-muted"><i class="far fa-clock me-1"></i>ទើបតែផ្ញើ</small>
                        <button class="like-btn" onclick="toggleLike(this)"><i class="fas fa-heart me-1" style="color: var(--sapphire-primary);"></i><span class="like-count">1</span></button>
                    </div>
                </div>
                <p class="text-secondary mb-0 mt-2" style="font-size: clamp(13px, 2.2vw, 15px);">${msg}</p>
            `;
            wishesList.prepend(card);
            document.getElementById('wishMessage').value = '';
            showToast('💌 សារជូនពររបស់អ្នកត្រូវបានបញ្ជូន!');
        });
    }
});
</script>
@endpush
