<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        .sidebar {
            min-height: calc(100vh - 60px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            border-radius: 5px;
            margin: 5px 0;
            padding: 10px 15px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            font-weight: 600;
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            padding-top: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid p-0 min-vh-100 d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse vh-100 position-fixed">
            <div class="position-sticky pt-3 h-100 d-flex flex-column">
                <div class="text-center mb-4">
                    <h4 class="text-white">Admin Panel</h4>
                </div>
                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/penyesuaian-data*') ? 'active bg-primary' : '' }}"
                            href="{{ route('admin.penyesuaian-data') }}">
                            <i class="fas fa-file-alt me-2"></i>
                            Data Pengajuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/serah-terima*') ? 'active bg-primary' : '' }}"
                            href="{{ route('admin.serah-terima.index') }}">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Serah Terima
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/penerimaan-sk*') ? 'active bg-primary' : '' }}"
                            href="{{ route('admin.penerimaan-sk.index') }}">
                            <i class="fas fa-file-signature me-2"></i>
                            Penerimaan SK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/penyerahan-sk*') ? 'active bg-primary' : '' }}"
                            href="{{ route('admin.penyerahan-sk.index') }}">
                            <i class="fas fa-file-import me-2"></i>
                            Penyerahan SK
                        </a>
                    </li>
                    <li class="nav-item mt-auto">
                        <a class="nav-link text-white" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0" style="margin-left: 25%; width: 75%;">
            <div class="p-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('admin-content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
        // Enable Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>