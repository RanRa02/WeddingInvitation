<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Dashboard')) - RAN RA System</title>
    <link rel="icon" href="{{ asset('assets/images/logo/wedding_logo.png') }}?v=1" type="image/png">

    <!-- Bootstrap 5 CSS (Local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS (Local) -->
    <link href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <!-- FontAwesome 6 Icons (Local) -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <!-- Chart.js (Local) -->
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>

    <!-- Google Fonts -->
    @include('fonts')

    <style>
        :root {
            --theme-primary: {{ config('app.theme.primary_color', '#cda365') }};
            --theme-primary-hover: {{ config('app.theme.primary_hover', '#b88f52') }};
            --theme-primary-gradient: {{ config('app.theme.primary_gradient', 'linear-gradient(135deg, #cda365 0%, #b58949 100%)') }};
            --theme-primary-tint: {{ config('app.theme.primary_tint', '#fbf7f0') }};
            --theme-navbar-bg: {{ config('app.theme.navbar_bg', 'linear-gradient(135deg, #cda365 0%, #b58949 100%)') }};
            --theme-sidebar-header-bg: {{ config('app.theme.sidebar_header_bg', 'linear-gradient(135deg, #cda365 0%, #b58949 100%)') }};
            --theme-table-header-bg: {{ config('app.theme.table_header_bg', '#cda365') }};
            --theme-table-even-bg: {{ config('app.theme.table_even_bg', '#fdfbf7') }};
            --theme-table-hover-bg: {{ config('app.theme.table_hover_bg', '#f7f1e5') }};
            --theme-badge-bg: {{ config('app.theme.badge_bg', '#fbf7f0') }};
            --theme-badge-color: {{ config('app.theme.badge_color', '#cda365') }};
            --theme-badge-border: {{ config('app.theme.badge_border', '#e8d8bd') }};
            --theme-body-bg: {{ config('app.theme.body_bg', '#f8f9fa') }};

            --dreams-orange: #ff9f43;
            --dreams-navy: #1b2559;
            --dreams-teal: #00cfe8;
            --dreams-green: #28c76f;
            --dreams-red: #ea5455;
            --dreams-bg: var(--theme-body-bg);
            --font-main: 'Kantumruy Pro', 'Koh Santepheap', 'Battambang', 'Segoe UI', sans-serif;
        }

        /* Device-Adaptive Responsive Base Font System (Matching Image Compact Scale) */
        html {
            font-size: 13px;
        }
        @media (max-width: 1400px) { html { font-size: 12.5px; } }
        @media (max-width: 992px)  { html { font-size: 12px; } }
        @media (max-width: 768px)  { html { font-size: 11.5px; } }
        @media (max-width: 576px)  { html { font-size: 11px; } }

        body {
            font-family: var(--font-main);
            background-color: var(--dreams-bg);
            color: #2c3e50;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            line-height: 1.45;
            -webkit-font-smoothing: antialiased;
        }

        /* Responsive Compact Headings (Matching User Screenshot) */
        h1, .h1 { font-size: clamp(1.2rem, 1.6vw, 1.5rem) !important; font-weight: 800; }
        h2, .h2 { font-size: clamp(1.1rem, 1.4vw, 1.3rem) !important; font-weight: 700; }
        h3, .h3 { font-size: clamp(1.0rem, 1.2vw, 1.15rem) !important; font-weight: 700; }
        h4, .h4 { font-size: clamp(0.92rem, 1.05vw, 1.05rem) !important; font-weight: 700; }
        h5, .h5 { font-size: clamp(0.85rem, 0.95vw, 0.95rem) !important; font-weight: 600; }
        h6, .h6 { font-size: clamp(0.80rem, 0.88vw, 0.88rem) !important; font-weight: 600; }

        /* Form Labels & Form Controls (Compact 11.5px - 12.5px font matching image) */
        .form-label {
            font-size: clamp(11.5px, 0.85vw, 12.5px) !important;
            font-weight: 600 !important;
            color: #495057 !important;
            margin-bottom: 0.25rem !important;
            line-height: 1.35 !important;
        }

        .form-control, .form-select, .input-group-text {
            font-size: clamp(11.5px, 0.88vw, 12.5px) !important;
            padding: 0.35rem 0.65rem !important;
            border-radius: 4px !important;
            font-family: var(--font-main) !important;
            color: #2c3e50 !important;
        }

        .form-control::placeholder {
            font-size: clamp(11px, 0.82vw, 12px) !important;
            color: #a0aec0 !important;
        }

        /* Section Card Headers */
        .card-header span, .card-header .fs-6 {
            font-size: clamp(12.5px, 0.95vw, 14px) !important;
            font-weight: 700 !important;
            line-height: 1.35 !important;
        }

        /* Table & Lists (11.5px - 12px font size matching image) */
        .table th {
            font-size: clamp(11px, 0.82vw, 12px) !important;
            font-weight: 700 !important;
            padding: 7px 8px !important;
        }
        .table td {
            font-size: clamp(11px, 0.82vw, 12px) !important;
            padding: 6px 8px !important;
        }

        /* Sidebar Navigation & Text Links */
        .sidebar-menu-title {
            font-size: clamp(10px, 0.75vw, 11px) !important;
            font-weight: 700 !important;
        }
        .sidebar-link, .dreams-menu-link {
            font-size: clamp(11.5px, 0.85vw, 12.5px) !important;
            line-height: 1.35 !important;
            padding: 7px 12px !important;
        }

        .submenu-item-link {
            font-size: clamp(11px, 0.82vw, 12px) !important;
            padding: 6px 10px !important;
        }

        /* Buttons Responsive Scaling */
        .btn {
            font-size: clamp(11.5px, 0.85vw, 12.5px) !important;
            font-weight: 600 !important;
            padding: 0.35rem 0.85rem !important;
        }
        .btn-sm {
            font-size: clamp(10.5px, 0.78vw, 11.5px) !important;
            padding: 0.25rem 0.5rem !important;
        }

        /* Gold Hamburger Sidebar Toggle Icon Button (Matching User Screenshot) */
        .sidebar-gold-toggle {
            background: #1877f2 !important;
            border: none !important;
            color: #ffffff !important;
            width: 44px;
            height: 38px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(24, 119, 242, 0.4);
            transition: all 0.2s ease;
        }

        .sidebar-gold-toggle:hover {
            background: #0866ff !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        /* Sidebar Collapsed Action States */
        body.sidebar-collapsed .dreams-sidebar {
            left: -260px !important;
        }

        body.sidebar-collapsed .dreams-navbar {
            left: 0 !important;
        }

        body.sidebar-collapsed .dreams-main-wrapper {
            margin-left: 0 !important;
        }

        /* Dreams POS Header Navbar */
        .dreams-navbar {
            background: var(--theme-navbar-bg) !important;
            height: 65px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.25);
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            z-index: 999;
            transition: left 0.3s ease;
            color: #ffffff;
        }

        .dreams-navbar .sidebar-gold-toggle {
            background: rgba(255, 255, 255, 0.18) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }

        .dreams-navbar .sidebar-gold-toggle:hover {
            background: #ffffff !important;
            color: var(--theme-primary) !important;
        }

        .dreams-navbar .header-action-icon {
            color: #ffffff !important;
        }

        .dreams-navbar .header-action-icon:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }

        .dreams-navbar .flag-lang-btn {
            background: rgba(255, 255, 255, 0.18) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #ffffff !important;
        }

        .dreams-navbar .notification-badge {
            background: #ea5455 !important;
            color: #ffffff !important;
            border: 2px solid var(--theme-primary) !important;
        }

        /* Sidebar Logo Area */
        .dreams-sidebar-logo {
            height: 65px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f1f1f1;
        }

        .brand-dreams-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-icon-bag {
            width: 36px;
            height: 36px;
            background: var(--theme-primary);
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
        }

        .brand-text-dreams {
            font-size: 22px;
            font-weight: 900;
            color: #1b2559;
            letter-spacing: -0.5px;
            margin: 0;
            line-height: 1;
        }

        .brand-text-dreams span {
            color: var(--theme-primary);
            font-size: 11px;
            display: block;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .sidebar-toggle-target {
            background: transparent;
            border: none;
            color: #6e6b7b;
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
        }

        /* Sidebar Main Layout */
        .dreams-sidebar {
            width: 260px;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .dreams-menu-list {
            padding: 16px 12px;
            list-style: none;
            margin: 0;
            overflow-y: auto;
            flex: 1;
        }

        .dreams-menu-item {
            margin-bottom: 6px;
        }

        .dreams-menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            color: #5e5873;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .dreams-menu-link:hover {
            color: var(--theme-primary);
            background: var(--theme-primary-tint);
        }

        .dreams-menu-link.active {
            background: var(--theme-primary) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(24, 119, 242, 0.3);
        }

        .dreams-menu-link.active i {
            color: #ffffff !important;
        }

        .dreams-menu-link i.menu-icon {
            font-size: 16px;
            width: 24px;
            color: #6e6b7b;
        }

        .dreams-menu-link i.chevron-right {
            font-size: 11px;
            color: #b9b9c3;
            transition: transform 0.2s ease;
        }

        /* Role & Menu Setting Collapsible Dropdown (Matching User Screenshot) */
        .dreams-menu-link.parent-dropdown {
            background: var(--theme-primary-tint) !important;
            color: var(--theme-primary) !important;
            font-weight: 600;
            border-radius: 10px;
        }

        .dreams-menu-link.parent-dropdown i {
            color: var(--theme-primary) !important;
        }

        .dreams-menu-link.parent-dropdown[aria-expanded="true"] i.chevron-right {
            transform: rotate(180deg);
        }

        .dreams-submenu-container {
            background: #ffffff;
            border-radius: 0 0 10px 10px;
            padding: 8px 12px 10px 24px;
        }

        .submenu-item-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            color: #1b2559;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .submenu-item-link:hover {
            background: var(--theme-primary-tint);
            color: var(--theme-primary);
        }

        .submenu-item-link.active-sub {
            background: var(--theme-primary-tint);
            color: var(--theme-primary);
            font-weight: 700;
        }

        .submenu-item-link i {
            font-size: 16px;
            color: #1b2559;
            width: 20px;
            text-align: center;
        }

        /* Dreams Header Action Items */
        .header-action-icon {
            color: #6e6b7b;
            font-size: 18px;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            text-decoration: none;
            position: relative;
        }

        .header-action-icon:hover {
            background: #f8f9fa;
            color: var(--theme-primary);
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: var(--theme-primary);
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
        }

        /* Flag Language Dropdown */
        .flag-lang-btn {
            background: #f8f9fa;
            border: 1px solid #ededed;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 13.5px;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        /* Main Content Body */
        .dreams-main-wrapper {
            margin-left: 260px;
            padding-top: 65px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dreams-content-container {
            padding: 24px 28px;
            flex: 1;
        }

        /* Dreams POS Minimal White Stat Card */
        .dreams-minimal-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            padding: 20px 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .minimal-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        /* Dreams POS Solid Color Block Cards */
        .dreams-block-card {
            border-radius: 12px;
            padding: 24px;
            color: #ffffff;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.2s ease;
        }

        .dreams-block-card:hover {
            transform: translateY(-3px);
        }

        .dreams-block-orange { background: var(--theme-primary) !important; }
        .dreams-block-cyan { background: #00cfe8 !important; }
        .dreams-block-navy { background: #1b2559 !important; }
        .dreams-block-green { background: #28c76f !important; }

        .block-card-number {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .block-card-title {
            font-size: 14.5px;
            font-weight: 600;
            opacity: 0.95;
            margin: 0;
        }

        .block-card-icon-right {
            position: absolute;
            right: 24px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 38px;
            opacity: 0.85;
        }

        /* Dreams POS Cards */
        .dreams-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
            padding: 24px;
            margin-bottom: 24px;
        }

        .dreams-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .dreams-card-title {
            font-size: 18px;
            font-weight: 700;
            color: #1b2559;
            margin: 0;
        }

        /* Gold/Facebook Blue Header Table Styling */
        .table-gold-header {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table-gold-header thead tr:first-child th {
            background: var(--theme-table-header-bg) !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 11.5px;
            padding: 7px 8px;
            border: none;
            white-space: nowrap;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        }

        .table-gold-header thead tr.filter-row th {
            background: #f4f7fa !important;
            padding: 5px 4px;
            border-bottom: 2px solid #cbd5e1;
        }

        .table-gold-header thead tr.filter-row input,
        .table-gold-header thead tr.filter-row select {
            font-size: 11px;
            padding: 3px 5px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            width: 100%;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
        }

        .table-gold-header tbody tr {
            transition: background 0.15s ease;
        }

        .table-gold-header tbody tr:nth-child(even) {
            background-color: var(--theme-table-even-bg);
        }

        .table-gold-header tbody tr:hover {
            background-color: var(--theme-table-hover-bg) !important;
        }

        .table-gold-header td {
            padding: 6px 8px;
            font-size: 11.5px;
            vertical-align: middle;
        }

        /* DataTables Custom Styling for Gold Header Tables */
        .dataTables_wrapper {
            padding: 10px 12px;
        }
        .dataTables_wrapper .dataTables_length select {
            padding: 0.2rem 1.8rem 0.2rem 0.6rem !important;
            border-radius: 16px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            background-color: #ffffff !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 16px !important;
            padding: 0.25rem 0.85rem !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 11.5px !important;
            outline: none !important;
            background-color: #ffffff !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--theme-primary) !important;
            box-shadow: 0 0 0 3px rgba(205, 163, 101, 0.2) !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 11.5px !important;
            color: #64748b !important;
            padding-top: 0.5rem !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 0.4rem !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 16px !important;
            margin: 0 2px !important;
            border: none !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--theme-primary) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 2px 6px rgba(24, 119, 242, 0.25) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--theme-primary-hover) !important;
            color: #ffffff !important;
            border: none !important;
        }
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            margin: 0 !important;
            white-space: nowrap !important;
            justify-content: flex-end !important;
        }
        .table-responsive, .dataTables_wrapper {
            overflow: visible !important;
        }
        .dropdown-menu {
            z-index: 1060 !important;
        }
        .caret-0::after, .dropdown-toggle.caret-0::after, .dropdown-toggle.no-caret::after {
            display: none !important;
            content: none !important;
        }
    </style>
</head>
<body>

    <!-- RAN RA System Sidebar -->
    <aside class="dreams-sidebar" id="dreamsSidebar">
        <!-- RAN RA Logo Area -->
        <div class="px-3 border-bottom d-flex align-items-center" style="height: 65px; background: var(--theme-sidebar-header-bg) !important; border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                <img src="{{ asset('images/ran_ra_logo.png') }}" class="rounded-3 shadow-sm bg-white p-1" style="width: 40px; height: 40px; object-fit: cover;" alt="RAN RA Logo">
                <div>
                    <h5 class="fw-black mb-0 text-white" style="font-weight: 900; font-size: 17px; letter-spacing: -0.5px;">RAN RA <span style="font-size: 11px; font-weight: 700; background: rgba(255, 255, 255, 0.2); color: #ffffff !important; padding: 2px 6px; border-radius: 4px; border: 1px solid rgba(255, 255, 255, 0.35);">SYSTEM</span></h5>
                    <span class="text-white opacity-75" style="font-size: 10.5px; font-weight: 600; display: block; line-height: 1.1;">SYSTEM MANAGEMENT</span>
                </div>
            </a>
        </div>

        <!-- Menu Navigation List -->
        <ul class="dreams-menu-list px-2 py-3">
            @if(auth()->check() && auth()->user()->isAdmin())
                <li class="px-3 mb-2 text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Admin Management</li>
                
                <li class="dreams-menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="dreams-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-th-large menu-icon me-2"></i>
                            <span>{{ __('Dashboard') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('admin.guests.index') }}" class="dreams-menu-link {{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-folder-open menu-icon me-2"></i>
                            <span>{{ __('Guest List / Projects') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('admin.plans.index') }}" class="dreams-menu-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-tags text-warning menu-icon me-2"></i>
                            <span>{{ __('Subscription Plans Management') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>

                <!-- Collapsible Role and Menu Setting Accordion Dropdown (Super Admin Only) -->
                @php
                    $isSettingActive = request()->routeIs('admin.menu-settings.*', 'admin.roles.*', 'admin.users.*');
                @endphp
                <li class="dreams-menu-item mb-2">
                    <a href="#roleMenuDropdown" 
                       class="dreams-menu-link parent-dropdown d-flex align-items-center justify-content-between text-decoration-none" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ $isSettingActive ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cog menu-icon me-2" style="font-size: 16px;"></i>
                            <span class="fw-bold">{{ __('Role and Menu Setting') }}</span>
                        </div>
                        <i class="fas fa-chevron-down chevron-right"></i>
                    </a>

                    <div class="collapse {{ $isSettingActive ? 'show' : '' }}" id="roleMenuDropdown">
                        <ul class="dreams-submenu-container list-unstyled mb-0 pt-2 pb-2">
                            <li class="mb-1">
                                <a href="{{ route('admin.menu-settings.modules.index') }}" 
                                   class="submenu-item-link {{ request()->routeIs('admin.menu-settings.modules.*') ? 'active-sub' : '' }}">
                                    <i class="fas fa-folder-plus text-primary"></i>
                                    <span>{{ __('Modules Setup') }}</span>
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('admin.menu-settings.pages.index') }}" 
                                   class="submenu-item-link {{ request()->routeIs('admin.menu-settings.pages.*') ? 'active-sub' : '' }}">
                                    <i class="fas fa-file-contract text-primary"></i>
                                    <span>{{ __('Pages Setup') }}</span>
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('admin.menu-settings.roles.index') }}" 
                                   class="submenu-item-link {{ request()->routeIs('admin.menu-settings.roles.*') ? 'active-sub' : '' }}">
                                    <i class="fas fa-user-shield text-primary"></i>
                                    <span>{{ __('Roles Setup') }}</span>
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('admin.users.index') }}" 
                                   class="submenu-item-link {{ request()->routeIs('admin.users.*') ? 'active-sub' : '' }}">
                                    <i class="fas fa-user text-primary"></i>
                                    <span>{{ __('Users Setup') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Customer System & Wedding Builder Section for Admin -->
                <li class="px-3 mt-3 mb-2 text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Customer System & Builder</li>
                
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.dashboard') }}" class="dreams-menu-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-heart text-danger menu-icon me-2"></i>
                            <span>{{ __('Customer Portal') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.wedding.create') }}" class="dreams-menu-link {{ request()->routeIs('customer.wedding.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-magic text-warning menu-icon me-2"></i>
                            <span>{{ __('Wedding Builder & Templates') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.subscriptions.plans') }}" class="dreams-menu-link {{ request()->routeIs('customer.subscriptions.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-credit-card text-info menu-icon me-2"></i>
                            <span>{{ __('Subscription Plans') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
            @else
                <!-- Customer Menu Functions (Exact Same Admin Layout, Different Functions) -->
                <li class="px-3 mb-2 text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Customer Menu</li>

                <li class="dreams-menu-item">
                    <a href="{{ route('customer.dashboard') }}" class="dreams-menu-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-tachometer-alt menu-icon me-2 text-warning"></i>
                            <span>{{ __('Dashboard (ផ្ទាំងដើម)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.subscriptions.plans') }}" class="dreams-menu-link {{ request()->routeIs('customer.subscriptions.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-credit-card menu-icon me-2 text-info"></i>
                            <span>{{ __('Subscription Plans (កញ្ចប់សេវា)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.wedding.create') }}" class="dreams-menu-link {{ request()->routeIs('customer.wedding.create') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-heart menu-icon me-2 text-danger"></i>
                            <span>{{ __('Wedding Details (ព័ត៌មានអាពាហ៍ពិពាហ៍)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.wedding.template') }}" class="dreams-menu-link {{ request()->routeIs('customer.wedding.template') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-paint-brush menu-icon me-2 text-success"></i>
                            <span>{{ __('Select Template (ជ្រើសរើសទម្រង់)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.guests.index') }}" class="dreams-menu-link {{ request()->routeIs('customer.guests.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-users menu-icon me-2 text-primary"></i>
                            <span>{{ __('Guest List (បញ្ជីភ្ញៀវ)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.invitations.send') }}" class="dreams-menu-link {{ request()->routeIs('customer.invitations.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-paper-plane menu-icon me-2 text-warning"></i>
                            <span>{{ __('Send Invitations (ផ្ញើសំបុត្រ)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
                <li class="dreams-menu-item">
                    <a href="{{ route('customer.reports.index') }}" class="dreams-menu-link {{ request()->routeIs('customer.reports.*') ? 'active' : '' }}">
                        <div>
                            <i class="fas fa-chart-line menu-icon me-2 text-info"></i>
                            <span>{{ __('RSVP Reports (របាយការណ៍)') }}</span>
                        </div>
                        <i class="fas fa-chevron-right chevron-right"></i>
                    </a>
                </li>
            @endif

            <hr class="my-3 border-secondary opacity-10">
            <li class="dreams-menu-item">
                <a href="{{ route('home') }}" target="_blank" class="dreams-menu-link text-muted">
                    <div>
                        <i class="fas fa-external-link-alt menu-icon me-2"></i>
                        <span>{{ __('Public Landing Site') }}</span>
                    </div>
                    <i class="fas fa-chevron-right chevron-right"></i>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Wrapper -->
    <div class="dreams-main-wrapper">
        <!-- Top Navbar Header -->
        <header class="dreams-navbar">
            <div class="d-flex align-items-center gap-3">
                <!-- Gold Hamburger Toggle Icon Button (Matching User Screenshot) -->
                <button class="sidebar-gold-toggle" id="sidebarGoldToggle" type="button" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-none d-md-flex align-items-center gap-2 text-white small ms-2 opacity-75">
                    <i class="fas fa-search fs-6"></i>
                    <span>{{ __('Search') }}...</span>
                </div>
            </div>

            <!-- Header Actions & Language Switcher -->
            <div class="d-flex align-items-center gap-3">

                <!-- Language Switcher Dropdown (Khmer 🇰🇭 / English 🇺🇸) -->
                <div class="dropdown">
                    <button class="flag-lang-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(app()->getLocale() === 'en')
                            <span style="font-size: 16px;">🇺🇸</span> <span>English</span>
                        @else
                            <span style="font-size: 16px;">🇰🇭</span> <span>ភាសាខ្មែរ</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2 {{ app()->getLocale() === 'kh' ? 'fw-bold bg-light text-primary' : '' }}" href="{{ route('admin.lang', 'kh') }}">
                                <span style="font-size: 18px;">🇰🇭</span> <span>ភាសាខ្មែរ (Khmer)</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2 {{ app()->getLocale() === 'en' ? 'fw-bold bg-light text-primary' : '' }}" href="{{ route('admin.lang', 'en') }}">
                                <span style="font-size: 18px;">🇺🇸</span> <span>English (US)</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Notifications Bell -->
                <a href="#" class="header-action-icon" title="Notifications">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge">4</span>
                </a>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn p-0 border-0 d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; font-size: 16px; background: #ffffff !important; color: #1877f2 !important;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="fw-bold text-white d-none d-md-inline" style="font-size: 14px;">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-3 shadow border-0 mt-2">
                        <li><span class="dropdown-item-text text-muted small">អ៊ីមែល: {{ auth()->user()->email ?? '' }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">
                                    <i class="fas fa-power-off me-2"></i> {{ __('Logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </header>

        <!-- Inner Content Area -->
        <main class="dreams-content-container">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- jQuery, Bootstrap 5 & DataTables JS (Local) -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        document.querySelectorAll('#sidebarGoldToggle, #sidebarToggle').forEach(btn => {
            btn?.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-collapsed');
                document.getElementById('dreamsSidebar')?.classList.toggle('show');
            });
        });

        // Set DataTables error mode to throw to avoid alert dialogs
        if (window.jQuery && $.fn && $.fn.dataTable) {
            $.fn.dataTable.ext.errMode = 'none';
        }

        // Initialize DataTables automatically for static list tables ONLY (.table-gold-header, .datatable)
        $(document).ready(function() {
            $('.table-gold-header, .datatable').each(function() {
                var table = $(this);
                var id = (table.attr('id') || '').toLowerCase();
                
                // Skip Yajra DataTables (which have their own script initialization) and already initialized tables
                if (table.hasClass('yajra-datatable') || id.indexOf('datatable') !== -1 || $.fn.DataTable.isDataTable(table) || table.parents('.dataTables_wrapper').length) {
                    return;
                }
                
                var dt = table.DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    order: [], // Preserve original server sort order
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>',
                            next: '<i class="fas fa-angle-right"></i>'
                        }
                    },
                    initComplete: function() {
                        var api = this.api();
                        table.find('thead .column-filter').on('keyup change clear', function() {
                            var colIdx = $(this).data('col');
                            if (colIdx !== undefined && api.column(colIdx)) {
                                api.column(colIdx).search(this.value).draw();
                            }
                        });
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
