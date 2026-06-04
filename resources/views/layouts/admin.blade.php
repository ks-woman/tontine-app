<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Tontine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #2c3e50;
            color: white;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar .active {
            background-color: #1abc9c;
        }

        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content-wrapper {
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center py-4">
                    <h4>Gestion Tontine</h4>
                    <small>Admin Panel</small>
                </div>
                <nav>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.membres.index') }}"
                        class="{{ request()->routeIs('admin.membres.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Membres
                    </a>
                    <a href="{{ route('tontines.index') }}"
                        class="{{ request()->routeIs('tontines.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-usd"></i> Tontines
                    </a>
                    <a href="{{ route('tours.index') }}" class="{{ request()->routeIs('tours.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Tours
                    </a>
                    <a href="{{ route('cotisations.index') }}"
                        class="{{ request()->routeIs('cotisations.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i> Cotisations
                    </a>
                    <a href="{{ route('admin.annonces.index') }}"
                        class="{{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i> Annonces
                    </a>
                    <a href="{{ route('public.annonces') }}">
                        <i class="fas fa-eye"></i> Voir les annonces
                    </a>
                </nav>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10">
                <!-- Navbar -->
                <nav class="navbar navbar-custom px-4">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="mt-2">Tableau de bord administrateur</h5>
                        <div class="d-flex align-items-center gap-3">
                            @auth
                                <span class="text-dark">
                                    <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                                </span>
                                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>

                    <a href="{{ route('admin.candidatures.index') }}"
                        class="{{ request()->routeIs('admin.candidatures.*') ? 'active' : '' }}">
                        <i class="fas fa-file-signature"></i> Candidatures
                    </a>

                    <a href="{{ route('admin.urgences.index') }}"
                        class="{{ request()->routeIs('admin.urgences.*') ? 'active' : '' }}">
                        <i class="fas fa-exclamation-triangle"></i> Urgences
                    </a>

                </nav>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>

</html>
