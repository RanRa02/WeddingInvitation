<!DOCTYPE html>
<html lang="kh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAN RA System - ធៀបការឌីជីថល & ប្រព័ន្ធគ្រប់គ្រងអាពាហ៍ពិពាហ៍</title>
    <link rel="icon" href="{{ asset('assets/images/logo/wedding_logo.png') }}?v=1" type="image/png">
    
    <!-- Bootstrap 5 & FontAwesome (Local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    
    @include('fonts')

    <style>
        :root {
            --primary-rose: #d63384;
            --primary-gold: #d4af37;
            --dark-navy: #0f172a;
            --gradient-hero: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #31103f 100%);
            --gradient-gold: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            --gradient-rose: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%);
        }
        body {
            font-family: 'Kantumruy Pro', 'Battambang', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            overflow-x: hidden;
        }
        .navbar-custom {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .hero-section {
            background: var(--gradient-hero);
            color: #fff;
            padding: 100px 0 140px;
            position: relative;
        }
        .hero-title {
            font-family: 'Moul', cursive;
            color: var(--primary-gold);
            line-height: 1.6;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 30px;
        }
        .feature-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 35px 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(214, 51, 132, 0.15);
            border-color: #fbcfe8;
        }
        .icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 28px;
        }
        .plan-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: relative;
            border: 2px solid #f1f5f9;
            transition: all 0.3s ease;
        }
        .plan-card.featured {
            border-color: var(--primary-rose);
            box-shadow: 0 20px 40px rgba(214, 51, 132, 0.2);
            transform: scale(1.03);
        }
        .badge-popular {
            position: absolute;
            top: -15px;
            right: 30px;
            background: var(--gradient-rose);
            color: #fff;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .btn-gradient-rose {
            background: var(--gradient-rose);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 14px 36px;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(255, 117, 140, 0.4);
            transition: all 0.3s ease;
        }
        .btn-gradient-rose:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255, 117, 140, 0.6);
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo/wedding_logo.png') }}" alt="Logo" width="40" class="rounded-circle">
                <span class="fw-bold fs-4 text-warning">RAN RA System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3 fs-6">
                    <li class="nav-item"><a class="nav-link active" href="#features">លក្ខណៈពិសេស</a></li>
                    <li class="nav-item"><a class="nav-link" href="#templates">ទម្រង់ធៀបការ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">តម្លៃកញ្ចប់សេវា</a></li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="btn btn-outline-warning rounded-pill px-4" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i> Admin Dashboard</a></li>
                        @else
                            <li class="nav-item"><a class="btn btn-warning rounded-pill px-4" href="{{ route('customer.dashboard') }}"><i class="fa-solid fa-user me-1"></i> Customer Dashboard</a></li>
                        @endif
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket me-1"></i> ចូលប្រព័ន្ធ</a></li>
                        <li class="nav-item"><a class="btn btn-gradient-rose" href="{{ route('register') }}"><i class="fa-solid fa-heart me-1"></i> បង្កើតគណនីឥឡូវនេះ</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6 mb-3"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> ប្រព័ន្ធធៀបការឌីជីថលជំនាន់ថ្មី #1 នៅកម្ពុជា</span>
                    <h1 class="hero-title display-4 mb-4">បង្កើតធៀបការឌីជីថលដ៏ស្រស់ស្អាត & គ្រប់គ្រងភ្ញៀវដោយទំនើបកម្ម</h1>
                    <p class="lead text-light mb-5 fs-5">
                        ចែករំលែកសំបុត្រអញ្ជើញអាពាហ៍ពិពាហ៍តាមរយៈ Telegram, WhatsApp, QR Code ជាមួយប្រព័ន្ធកត់ត្រាវឌ្ឍនភាព RSVP និងគ្រប់គ្រងតុអាហារបានយ៉ាងងាយស្រួល!
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-gradient-rose btn-lg px-5"><i class="fa-solid fa-rocket me-2"></i> ចាប់ផ្តើមបង្កើតធៀបការសាកល្បង</a>
                        <a href="#templates" class="btn btn-outline-light btn-lg rounded-pill px-4"><i class="fa-solid fa-eye me-2"></i> មើលទម្រង់គំរូ (Demo)</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- System Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="text-danger fw-bold text-uppercase">FEATURES</span>
                <h2 class="fw-bold font-moul fs-3 text-dark mt-2">ហេតុអ្វីត្រូវជ្រើសរើស RAN RA System?</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="icon-wrapper bg-danger-subtle text-danger mx-auto">
                            <i class="fa-solid fa-palette"></i>
                        </div>
                        <h4 class="fw-bold mb-3 fs-5">Template ស្រស់ស្អាត & ខ្មែរ</h4>
                        <p class="text-muted fs-6">រចនាម៉ូដយ៉ាងផ្ចិតផ្ចង់ មានច្រើនជម្រើស (Married Classic, Sapphire Theme, Ruby Modern) និងគាំទ្រអក្សរខ្មែរគ្រប់ Font។</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="icon-wrapper bg-warning-subtle text-warning mx-auto">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <h4 class="fw-bold mb-3 fs-5">ផ្ញើសំបុត្រតាម Telegram & QR</h4>
                        <p class="text-muted fs-6">បង្កើត Link សំបុត្រអញ្ជើញផ្ទាល់ខ្លួនសម្រាប់ភ្ញៀវម្នាក់ៗ រួមទាំង QR Code ងាយស្រួលក្នុងការផ្ញើ និងចែករំលែក។</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="icon-wrapper bg-info-subtle text-info mx-auto">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h4 class="fw-bold mb-3 fs-5">របាយការណ៍ RSVP & តុអាហារ</h4>
                        <p class="text-muted fs-6">ដឹងពីចំនួនភ្ញៀវអញ្ជើញរួមមាន ភ្ញៀវមកដល់ ភ្ញៀវមិនបានមក ចំនួនតុ និងរៀបចំចំណងដៃបានយ៉ាងរហ័ស។</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Subscription Pricing Section -->
    <section id="pricing" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="text-danger fw-bold text-uppercase">PRICING PLANS</span>
                <h2 class="fw-bold font-moul fs-3 text-dark mt-2">កញ្ចប់តម្លៃសេវាកម្មស័ក្តិសមសម្រាប់អ្នក</h2>
            </div>

            <div class="row g-4 justify-content-center align-items-stretch">
                @foreach($plans as $plan)
                    <div class="col-lg-3 col-md-6">
                        <div class="plan-card h-100 d-flex flex-column {{ $plan->slug == 'silver' ? 'featured' : '' }}">
                            @if($plan->slug == 'silver')
                                <div class="badge-popular">ពេញនិយមបំផុត</div>
                            @endif
                            <h3 class="fw-bold fs-4 text-dark mb-2">{{ $plan->name }}</h3>
                            <p class="text-muted small mb-4">{{ $plan->description }}</p>
                            
                            <div class="my-3">
                                <span class="display-5 fw-bold text-dark">${{ number_format($plan->price, 0) }}</span>
                                <span class="text-muted">/ {{ $plan->duration_days }} ថ្ងៃ</span>
                            </div>

                            <ul class="list-unstyled my-4 flex-grow-1">
                                <li class="mb-3"><i class="fa-solid fa-check-circle text-success me-2"></i> ចំនួនភ្ញៀវ: <strong>{{ number_format($plan->guest_limit) }} នាក់</strong></li>
                                @if(is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                        <li class="mb-2 text-muted"><i class="fa-solid fa-check text-primary me-2"></i> {{ $feature }}</li>
                                    @endforeach
                                @endif
                            </ul>

                            <a href="{{ route('register') }}" class="btn {{ $plan->slug == 'silver' ? 'btn-gradient-rose' : 'btn-outline-dark rounded-pill' }} w-100 py-3 mt-auto">
                                ជ្រើសរើសកញ្ចប់នេះ
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 text-center border-top border-secondary">
        <div class="container">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} <strong>RAN RA Wedding System</strong>. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
