<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Auto Abuja</title>
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

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
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
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOP BAR ===== */
        .admin-topbar {
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

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f4f6f9;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 8px 14px;
            flex: 1;
            max-width: 360px;
        }

        .search-box input {
            border: none;
            background: none;
            outline: none;
            font-size: 0.875rem;
            width: 100%;
            color: #333;
        }

        .search-box i {
            color: #bbb;
            font-size: 0.85rem;
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

        /* ===== CONTENT AREA ===== */
        .admin-content {
            padding: 28px;
            flex: 1;
        }

        /* ===== ALERTS ===== */
        .admin-alert {
            border-radius: 12px;
            border: none;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
        }

        /* ===== SHARED COMPONENTS ===== */
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid #f0f0f0;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.85rem;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1;
        }

        .admin-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
        }

        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid #f4f6f9;
        }

        .admin-table thead th {
            font-size: 0.72rem;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 12px 16px;
            background: #fafafa;
        }

        .admin-table tbody td {
            padding: 12px 16px;
            border: none;
            border-bottom: 1px solid #f4f6f9;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr:hover td {
            background: #fafbfc;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .cat-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #f4f6f9;
            color: #555;
        }

        .biz-avatar {
            width: 36px;
            height: 36px;
            background: #f4f6f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #555;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h4 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1a1a2e;
        }

        .page-header p {
            font-size: 0.875rem;
            color: #999;
            margin: 0;
        }

        /* ===== MOBILE ===== */
        @media (max-width: 991px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">

        <div class="sidebar-logo">
            <div class="brand">
                <div class="logo-icon">A</div>
                <div>
                    <div>Auto Abuja</div>
                    <div class="subtitle">Admin Panel</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> Dashboard
            </a>

            @if(in_array(auth()->user()->role, ['super_admin', 'admin']))
                <div class="nav-section-title">Management</div>
                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="fa fa-users"></i> Vendors & Users
                </a>
            @endif

            <div class="nav-section-title">Operations</div>
            <a href="{{ route('admin.businesses.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.businesses.index') ? 'active' : '' }}">
                <i class="fa fa-building"></i> Business Approvals
            </a>
            
            <a href="{{ route('admin.products.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                <i class="fa fa-shopping-bag"></i> Listings / Products
            </a>

            @if(in_array(auth()->user()->role, ['super_admin', 'admin', 'moderator']))
                <a href="{{ route('admin.categories.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                    <i class="fa fa-tags"></i> Categories
                </a>
            @endif

            <div class="nav-section-title">Security</div>
            @if(in_array(auth()->user()->role, ['super_admin', 'admin']))
                <a href="{{ route('admin.users.create') }}" 
                    class="sidebar-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                    <i class="fa fa-user-plus"></i> Add New User
                </a>
            @endif
            
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fa fa-external-link-alt"></i> Return to Site
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="email d-flex align-items-center gap-1">
                        {{ auth()->user()->email }}
                        <span class="badge bg-warning text-dark x-small py-0">{{ auth()->user()->role }}</span>
                    </div>
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
    <div class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <button class="notif-btn d-lg-none"
                onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                <i class="fa fa-bars"></i>
            </button>
            <!-- <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search...">
            </div> -->
            <div class="topbar-right">
                <a href="{{ route('home') }}"
                    class="btn btn-outline-secondary btn-sm rounded-pill px-3 me-2 border-0 fw-medium">
                    <i class="fa fa-external-link-alt me-1"></i> Return to Site
                </a>
                <button class="notif-btn">
                    <i class="fa fa-bell"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <main class="admin-content">
            @if(session('status'))
                <div class="admin-alert alert alert-success">
                    <i class="fa fa-check-circle text-success"></i> {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="admin-alert alert alert-danger">
                    <i class="fa fa-exclamation-circle text-danger"></i> {{ session('error') }}
                </div>
            @endif

            @yield('admin_content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>