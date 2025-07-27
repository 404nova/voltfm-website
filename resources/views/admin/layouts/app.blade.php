<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - VoltFM</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin Styles -->
    <style>
        :root {
            --primary-color: #c3f135;
            --secondary-color: #222;
            --light-bg: #f8f9fa;
            --dark-text: #333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
        }

        .sidebar {
            background-color: #fff;
            border-right: 1px solid rgba(0,0,0,.1);
            min-height: 100vh;
            position: fixed;
            width: 250px;
            box-shadow: 0 0 20px rgba(0,0,0,.05);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(0,0,0,.1);
            flex-shrink: 0;
        }

        .sidebar-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: var(--dark-text);
        }

        .sidebar-logo span {
            color: var(--primary-color);
        }

        .nav-wrapper {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .nav-item {
            border-bottom: 1px solid rgba(0,0,0,.05);
        }

        .nav-link {
            color: var(--dark-text);
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(195, 241, 53, 0.1);
            color: var(--dark-text);
            border-left: 3px solid var(--primary-color);
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .content-header {
            padding: 15px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,.1);
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            margin-bottom: 0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--dark-text);
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #b3e129;
            border-color: #b3e129;
            color: var(--dark-text);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,.05);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,.1);
            font-weight: 600;
            padding: 15px 20px;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            border-top: none;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 15px 20px 10px 20px;
            border-top: 1px solid rgba(0,0,0,.1);
            background-color: rgba(195, 241, 53, 0.1);
        }

        .user-actions {
            margin-top: 10px;
            border-top: 1px solid rgba(0,0,0,.05);
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 0;
        }

        .form-control:focus, .btn:focus {
            box-shadow: 0 0 0 0.25rem rgba(195, 241, 53, 0.25);
            border-color: var(--primary-color);
        }

        .alert {
            border-radius: 8px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-logo">VOLT<span>DJ</span></h3>
            </div>
            <div class="nav-wrapper">
                <ul class="nav flex-column">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    
                    @if(Auth::user()->hasRole('dj') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
                    <!-- DJ PLANNING - Accessible to DJs and Admins -->
                    <li class="nav-item">
                        <hr class="dropdown-divider mx-3 my-2">
                        <div class="px-3 mb-1"><small class="text-muted">DJ PLANNING</small></div>
                    </li>

                    <!-- DJ Schedule Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/schedule') ? 'active' : '' }}" href="{{ route('admin.schedule.index') }}">
                            <i class="fas fa-calendar-alt"></i> Planning Overzicht
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/schedule/availability*') ? 'active' : '' }}" 
                           href="{{ route('admin.schedule.availability', Auth::user()->hasRole('dj') && !(Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer')) ? ['user_id' => Auth::id()] : []) }}">
                            <i class="fas fa-clock"></i> Beschikbaarheid
                        </a>
                    </li>
                    
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
                    <!-- Admin Only: Assignment Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/schedule/assignments*') ? 'active' : '' }}" href="{{ route('admin.schedule.assignments') }}">
                            <i class="fas fa-user-clock"></i> DJ Toewijzingen
                        </a>
                    </li>
                    @endif
                    @endif
                    
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
                    <!-- Divider -->
                    <li class="nav-item">
                        <hr class="dropdown-divider mx-3 my-2">
                        <div class="px-3 mb-1"><small class="text-muted">PROGRAMMA'S</small></div>
                    </li>
                    
                    <!-- Content Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/programs*') ? 'active' : '' }}" href="{{ route('admin.programs.index') }}">
                            <i class="fas fa-broadcast-tower"></i> Programma's
                        </a>
                    </li>
                    @endif
                    
                    @if(Auth::user()->hasRole('redactie') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
                    <!-- Divider -->
                    <li class="nav-item">
                        <hr class="dropdown-divider mx-3 my-2">
                        <div class="px-3 mb-1"><small class="text-muted">NIEUWS</small></div>
                    </li>
                    
                    <!-- News Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/news*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                            <i class="fas fa-newspaper"></i> Nieuws
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-folder"></i> Nieuwscategorieën
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/tags*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                            <i class="fas fa-tags"></i> Nieuwstags
                        </a>
                    </li>
                    
                    <!-- Divider -->
                    <li class="nav-item">
                        <hr class="dropdown-divider mx-3 my-2">
                        <div class="px-3 mb-1"><small class="text-muted">INTERACTIE</small></div>
                    </li>
                    
                    <!-- User-generated Content -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/comments*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                            <i class="fas fa-comments"></i> Reacties
                        </a>
                    </li>
                    @endif
					@if(Auth::user()->hasRole('dj') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/song-requests*') ? 'active' : '' }}" href="{{ route('admin.song-requests.index') }}">
                            <i class="fas fa-music"></i> Verzoeknummers
                        </a>
                    </li>
					@endif
                    @if(Auth::user()->hasRole('dj') || Auth::user()->hasRole('redactie') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
					<li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/top40*') ? 'active' : '' }}" href="{{ route('admin.top40.index') }}">
                            <i class="fas fa-radio"></i> Top40
                        </a>
                    </li>
					@endif
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('beheer'))
                    <li class="nav-item">
                        <hr class="dropdown-divider mx-3 my-2">
                        <div class="px-3 mb-1"><small class="text-muted">SOLLICITATIES</small></div>
                    </li>       
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/vacatures*') ? 'active' : '' }}" href="{{ route('admin.vacancies.index') }}">
                            <i class="fas fa-plug-circle-plus"></i> Vacatures
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/sollicitaties*') ? 'active' : '' }}" href="{{ route('admin.sollicitaties.index') }}">
                            <i class="fas fa-file-circle-question"></i> Sollicitaties
                        </a>
                    </li>
                    <!-- Divider -->
                    <li class="nav-item">
                        <hr class="dropdown-divider mx-3 my-2">
                        <div class="px-3 mb-1"><small class="text-muted">ADMINISTRATIE</small></div>
                    </li>
                    
                    <!-- User Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Gebruikers
                        </a>
                    </li>

                    @endif
                    
                    
                    <!-- Logout -->
                    <li class="nav-item mt-auto">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                                <i class="fas fa-sign-out-alt"></i> Uitloggen
                            </button>
                        </form>
                    </li>
                </ul>
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=c3f135&color=222" alt="Avatar" class="avatar">
                    <div>
                        <p class="user-name">{{ Auth::user()->name }}</p>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                @yield('actions')
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
