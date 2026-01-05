<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>Wedding Invitation</title>
    <link rel="icon" href="{{ asset('assets/images/logo/wedding_logo.png') }}?v=1" type="image/png">

    <!-- Bootstrap 5 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.1.0/css/all.min.css" integrity="sha512-+qYpW9R8Z7Zr1d5lqYpP1pPp6bU3M9W8QyZ0uFq7L1N9sR5YwE6t8n0R8lE7Z1q3U6Nw2pYk5L3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Google Fonts -->
    <link href="{{ asset('assets/fonts/fonts.css') }}" rel="stylesheet">

    @include('fonts')
    @stack('css')
    <style>
        body {
            background: #f1f5f9;
            font-family: 'Battambang', sans-serif;
        }
    </style>
</head>
<body>
    <div class="content">
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @stack('script')
</body>
</html>
