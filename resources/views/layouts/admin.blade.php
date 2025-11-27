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
        :root {
            --text: #1a1a1a;
            --bg: #ffffff;
            /* ubah main bg jadi putih */
            --primary: #d1d5db;
            /* sidebar bg lebih terang */
            --secondary: #ffffff;
            --accent: #9ca3af;
            /* hover */
            --border: #6b7280;
            /* garis */
        }

        body {
            background-color: var(--bg);
            color: var(--text);
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--primary);
            min-height: 100vh;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
            padding-top: 1rem;
            transition: all 0.3s ease;
        }

        .sidebar .text-center h4 {
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            color: var(--text);
        }

        .nav-link {
            border-radius: 8px;
            margin: 6px 10px;
            padding: 12px 16px;
            color: var(--text) !important;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover {
            background-color: var(--accent);
            color: var(--text) !important;
        }

        .nav-link.active {
            font-weight: 600;
            background-color: var(--secondary);
            color: var(--text) !important;
            box-shadow: inset 3px 0 0 #a6a6a6;
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        /* Scrollbar sidebar */
        .sidebar-sticky::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background-color: var(--accent);
            border-radius: 3px;
        }

        .sidebar-sticky::-webkit-scrollbar-track {
            background-color: transparent;
        }

        /* Alerts */
        .alert-success {
            background-color: var(--primary);
            color: var(--text);
            border-color: var(--border);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border-color: #f5c2c7;
        }

        .btn-close {
            filter: brightness(0.5);
        }

        main {
            background-color: var(--bg);
            transition: margin-left 0.3s ease;
        }

        /* Responsive: collapse sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            main {
                margin-left: 0 !important;
            }
        }
    </style>

</head>

<body>
    <div class="container-fluid p-0 min-vh-100 d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse vh-100 position-fixed">
            <div class="position-sticky pt-3 h-100 d-flex flex-column">
                <div class="text-center mb-4">
                    <h4 style="color: var(--text)">Admin Panel</h4>
                </div>
                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/penyesuaian-data*') ? 'active' : '' }}"
                            href="{{ route('admin.penyesuaian-data') }}">
                            <i class="fas fa-file-alt me-2"></i>
                            Data Pengajuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/serah-terima*') ? 'active' : '' }}"
                            href="{{ route('admin.serah-terima.index') }}">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Serah Terima
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/penerimaan-sk*') ? 'active' : '' }}"
                            href="{{ route('admin.penerimaan-sk.index') }}">
                            <i class="fas fa-file-signature me-2"></i>
                            Penerimaan SK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/penyerahan-sk*') ? 'active' : '' }}"
                            href="{{ route('admin.penyerahan-sk.index') }}">
                            <i class="fas fa-file-export me-2"></i>
                            Penyerahan SK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/penyerahan-sk*') ? 'active' : '' }}"
                            href="{{ route('admin.penyerahan-sk.index') }}">
                            <i class="fas fa-file-import me-2"></i>
                            Rekapitulasi Penyerahan Perizinan Layanan Khusus (LAJIK)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/rekapitulasi-penerimaan*') ? 'active' : '' }}"
                            href="{{ route('admin.rekapitulasi-penerimaan.index') }}">
                            <i class="fas fa-clipboard-list me-2"></i> Rekapitulasi Penerimaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/rekapitulasi-penyerahan*') ? 'active' : '' }}"
                            href="{{ route('admin.rekapitulasi-penyerahan.index') }}">
                            <i class="fas fa-clipboard-list me-2"></i> Rekapitulasi Penyerahan
                        </a>
                    </li>
                    <li class="nav-item mt-auto">
                        <a class="nav-link" href="#"
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
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <div class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts -->
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>
