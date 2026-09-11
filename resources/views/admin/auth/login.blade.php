<!DOCTYPE html>
<html lang="kh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purple Admin Login</title>
    <link rel="icon" href="{{ asset('assets/images/logo/wedding_logo.png') }}?v=1" type="image/png">
    <!-- Bootstrap 5 & FontAwesome (Local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    @include('fonts')

    <style>
        body {
            font-family: 'Battambang', sans-serif;
            background-color: #f2edf3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 16px;
        }

        .purple-login-card {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 40px rgba(182, 109, 255, 0.15);
            max-width: 420px;
            width: 100%;
            padding: 40px 32px;
        }

        .brand-logo-icon-login {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #da8cff 0%, #9a55ff 100%);
            color: #ffffff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
            box-shadow: 0 8px 20px rgba(182, 109, 255, 0.4);
        }

        .login-brand-title {
            font-weight: 800;
            font-size: 28px;
            text-align: center;
            background: linear-gradient(135deg, #da8cff 0%, #9a55ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 4px;
        }

        .btn-purple-gradient-login {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 12px !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            box-shadow: 0 4px 15px rgba(182, 109, 255, 0.4) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .btn-purple-gradient-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(182, 109, 255, 0.6) !important;
        }
    </style>
</head>
<body>

    <div class="purple-login-card fade-in">
        <div class="brand-logo-icon-login">
            <i class="fas fa-cubes"></i>
        </div>
        <h2 class="login-brand-title">Purple Admin</h2>
        <p class="text-center text-muted mb-4 small">ចូលប្រើប្រាស់ប្រព័ន្ធគ្រប់គ្រង (Sign in to continue)</p>

        @if(session('error'))
            <div class="alert alert-danger rounded-3 py-2 px-3 small text-center mb-3">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success rounded-3 py-2 px-3 small text-center mb-3">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-bold text-dark mb-1">អ៊ីមែល (Email)</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" placeholder="admin@wedding.com" value="{{ old('email') }}" required autofocus style="font-size: 15px;">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold text-dark mb-1">ពាក្យសម្ងាត់ (Password)</label>
                <input type="password" name="password" id="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" placeholder="••••••••" required style="font-size: 15px;">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-secondary small" for="remember">
                    ចងចាំការចូលប្រព័ន្ធ (Keep me signed in)
                </label>
            </div>

            <button type="submit" class="btn btn-purple-gradient-login w-100 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i> ចូលប្រព័ន្ធ (SIGN IN)
            </button>
        </form>

        <div class="text-center mt-3 pt-2 border-top">
            <p class="small text-muted mb-2">មិនទាន់មានគណនី? (Don't have an account?)</p>
            <a href="{{ route('admin.register') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 text-purple fw-bold">
                <i class="fas fa-user-plus me-1"></i> ចុះឈ្មោះ (Register Account)
            </a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted small">
                <i class="fas fa-arrow-left me-1"></i> ត្រឡប់ទៅកាន់ទំព័រដើម (Back to Home)
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Local) -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
