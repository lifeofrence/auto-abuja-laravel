<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard | Auto Abuja</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
        }

        /* ===== SIDEBAR (Mirrored from Admin) ===== */
        .vendor-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 240px;
            background: #1a1a2e;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-logo .brand {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo .brand .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #F68B1E, #ff6b35);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 1rem;
        }

        .sidebar-logo .subtitle {
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 12px;
        }

        .nav-section-title {
            font-size: 0.65rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 14px 12px 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
        }

        .sidebar-link.active {
            background: #F68B1E;
            color: #fff;
            box-shadow: 0 4px 12px rgba(246, 139, 30, 0.35);
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-user .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #F68B1E, #ff6b35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .sidebar-user .user-info .name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #fff;
        }

        .sidebar-user .user-info .email {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .logout-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.4);
            margin-left: auto;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .logout-btn:hover {
            color: #ff6b6b;
        }

        /* ===== MAIN CONTENT ===== */
        .vendor-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOP BAR ===== */
        .vendor-topbar {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 28px;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        .notif-btn {
            width: 38px;
            height: 38px;
            background: #f4f6f9;
            border: 1px solid #eee;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #666;
            transition: all 0.2s;
        }

        .notif-btn:hover {
            background: #F68B1E;
            color: #fff;
            border-color: #F68B1E;
        }

        .return-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .return-btn:hover {
            background: #fff;
            color: #1a1a2e;
            border-color: var(--primary-color, #F68B1E);
        }

        /* ===== CONTENT AREA ===== */
        .vendor-content {
            padding: 28px;
            flex: 1;
        }

        /* ===== ALERTS ===== */
        .vendor-alert {
            border-radius: 12px;
            border: none;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
        }

        /* ===== MOBILE ===== */
        @media (max-width: 991px) {
            .vendor-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .vendor-sidebar.open {
                transform: translateX(0);
            }

            .vendor-main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="vendor-sidebar" id="vendorSidebar">

        <div class="sidebar-logo">
            <div class="brand">
                <div class="logo-icon">V</div>
                <div>
                    <div>Vendor Hub</div>
                    <div class="subtitle">Auto Abuja Marketplace</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">


            <div class="nav-section-title">Overview</div>
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('vendor.profile') }}"
                class="sidebar-link {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
                <i class="fa fa-store"></i> Public Profile
            </a>

            <div class="nav-section-title">Management</div>
            <a href="{{ route('vendor.business.index') }}"
                class="sidebar-link {{ request()->routeIs('vendor.business.index') ? 'active' : '' }}">
                <i class="fa fa-building"></i> Business Setup
            </a>
            <a href="{{ route('vendor.gallery.index') }}"
                class="sidebar-link {{ request()->routeIs('vendor.gallery.index') ? 'active' : '' }}">
                <i class="fa fa-images"></i> Photo Gallery
            </a>

            <div class="nav-section-title">Listings</div>
            <a href="{{ route('vendor.products.index') }}"
                class="sidebar-link {{ request()->routeIs('vendor.products.index') ? 'active' : '' }}">
                <i class="fa fa-list"></i> My Products/Services
            </a>
            <a href="{{ route('vendor.products.create') }}"
                class="sidebar-link {{ request()->routeIs('vendor.products.create') ? 'active' : '' }}">
                <i class="fa fa-plus-circle"></i> Post New Item
            </a>

            <div class="nav-section-title">Account</div>
            <a href="{{ route('profile.edit') }}"
                class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fa fa-cog"></i> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="email text-truncate" style="max-width: 120px;">{{ auth()->user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="fa fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Area -->
    <div class="vendor-main">
        <!-- Topbar -->
        <header class="vendor-topbar">
            <button class="notif-btn d-lg-none"
                onclick="document.getElementById('vendorSidebar').classList.toggle('open')">
                <i class="fa fa-bars"></i>
            </button>
            <a href="{{ route('home') }}" class="return-btn d-none d-md-flex">
                <i class="fa fa-arrow-left"></i> Return to Site
            </a>
            <div class="topbar-right">
                <button class="notif-btn">
                    <i class="fa fa-bell"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <main class="vendor-content">
            @if(session('status'))
                <div class="vendor-alert alert alert-success">
                    <i class="fa fa-check-circle text-success"></i> {{ session('status') }}
                </div>
            @endif

            @if(strtolower(auth()->user()->license_status) === 'expired')
                <div class="vendor-alert alert alert-danger border-start border-danger border-5">
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    <div>
                        <h6 class="fw-bold mb-0">License Expired</h6>
                        <small>Your trade license has ended. Renew to keep products visible.</small>
                    </div>
                </div>
            @endif

            @yield('vendor_content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>