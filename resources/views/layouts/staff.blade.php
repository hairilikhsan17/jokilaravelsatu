<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Apotek Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --sidebar-width: 280px;
            --primary-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --secondary-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
            --accent-gradient: linear-gradient(135deg, #0ba360 0%, #3cba92 100%);
            --sidebar-bg: linear-gradient(180deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            --sidebar-hover: rgba(56, 239, 125, 0.1);
            --sidebar-active: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #e0f7e9 0%, #d4f1f4 100%);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            padding: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(56, 239, 125, 0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(56, 239, 125, 0.5);
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(56, 239, 125, 0.15) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .sidebar-header h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .sidebar-header h4 i {
            font-size: 2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Sidebar Menu */
        .sidebar-menu {
            list-style: none;
            padding: 1.5rem 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0.5rem 0;
            padding: 0 1rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            font-weight: 500;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-gradient);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-menu a::after {
            content: '';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%) translateX(10px);
            opacity: 0;
            transition: all 0.3s ease;
            font-family: 'bootstrap-icons';
            content: '\F285';
            color: #38ef7d;
            font-size: 1rem;
        }

        .sidebar-menu a:hover {
            background: var(--sidebar-hover);
            color: #fff;
            transform: translateX(5px);
            padding-right: 2.5rem;
        }

        .sidebar-menu a:hover::before {
            transform: scaleY(1);
        }

        .sidebar-menu a:hover::after {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        .sidebar-menu a.active {
            background: var(--sidebar-active);
            color: #fff;
            box-shadow: 0 8px 20px rgba(56, 239, 125, 0.3);
        }

        .sidebar-menu a.active::before {
            transform: scaleY(1);
        }

        .sidebar-menu a i {
            margin-right: 1rem;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .sidebar-menu a.active i {
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        /* Sidebar Footer */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(56, 239, 125, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid rgba(56, 239, 125, 0.2);
        }

        .sidebar-footer .user-info:hover {
            background: rgba(56, 239, 125, 0.15);
            border-color: rgba(56, 239, 125, 0.4);
            transform: translateY(-2px);
        }

        .sidebar-footer .user-info i {
            margin-right: 0.75rem;
            font-size: 1.75rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .sidebar-footer .user-info img {
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .sidebar-footer .user-info span {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar-footer .logout-btn {
            width: 100%;
            background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
            border: none;
            color: #fff;
            padding: 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(235, 51, 73, 0.3);
            position: relative;
            overflow: hidden;
        }

        .sidebar-footer .logout-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .sidebar-footer .logout-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .sidebar-footer .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(235, 51, 73, 0.4);
        }

        .sidebar-footer .logout-btn:active {
            transform: translateY(0);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Top Navbar */
        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.25rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .top-navbar h5 {
            margin: 0;
            font-weight: 700;
            color: #0f2027;
            font-size: 1.5rem;
            position: relative;
        }

        .top-navbar h5::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        .top-navbar .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            background: var(--secondary-gradient);
            box-shadow: 0 4px 10px rgba(86, 171, 47, 0.3);
            animation: pulse-badge 2s ease-in-out infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .sidebar-toggle {
            display: none;
            background: var(--primary-gradient);
            border: none;
            font-size: 1.5rem;
            color: #fff;
            cursor: pointer;
            padding: 0.5rem 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
        }

        .sidebar-toggle:hover {
            transform: scale(1.05) rotate(90deg);
            box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 2.5rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
            color: #155724;
        }

        .alert-success::before {
            background: linear-gradient(180deg, #11998e 0%, #38ef7d 100%);
        }

        .alert-danger {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #721c24;
        }

        .alert-danger::before {
            background: linear-gradient(180deg, #eb3349 0%, #f45c43 100%);
        }

        .alert i {
            font-size: 1.25rem;
            vertical-align: middle;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .content-wrapper {
                padding: 1.5rem;
            }

            .top-navbar {
                padding: 1rem 1.5rem;
            }

            .top-navbar h5 {
                font-size: 1.25rem;
            }
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 999;
            transition: opacity 0.3s ease;
        }

        .overlay.show {
            display: block;
            animation: fadeInOverlay 0.3s ease;
        }

        @keyframes fadeInOverlay {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Custom Scrollbar for Main Content */
        .content-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .content-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .content-wrapper::-webkit-scrollbar-thumb {
            background: rgba(56, 239, 125, 0.3);
            border-radius: 10px;
        }

        .content-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(56, 239, 125, 0.5);
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-capsule"></i> Apotek Stok</h4>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard.staff') }}" class="{{ request()->routeIs('dashboard.staff') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.obat.index') }}" class="{{ request()->routeIs('staff.obat.*') ? 'active' : '' }}">
                    <i class="bi bi-capsule-pill"></i>
                    <span>Data Obat / Alkes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.laporan.index') }}" class="{{ request()->routeIs('staff.laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Laporan Stok / Aktivitas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.riwayat.index') }}" class="{{ request()->routeIs('staff.riwayat.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat Aktivitas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.profil.index') }}" class="{{ request()->routeIs('staff.profil.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Staff</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-info">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/photos/' . auth()->user()->photo) }}" 
                         alt="{{ auth()->user()->name }}" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 0.75rem; border: 2px solid #38ef7d;">
                @else
                    <i class="bi bi-person-circle"></i>
                @endif
                <span>{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="sidebar-toggle me-3" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
                </div>
                <div>
                    <span class="badge bg-success">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('overlay');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // Close sidebar when clicking on a link (mobile)
        const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add ripple effect to menu items
        document.querySelectorAll('.sidebar-menu a').forEach(item => {
            item.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                let x = e.clientX - e.target.offsetLeft;
                let y = e.clientY - e.target.offsetTop;
                
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>