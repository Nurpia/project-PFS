<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Rekam Medis')); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --medical-blue: #0ea5e9;
            --medical-dark-blue: #0369a1;
            --accent-green: #22c55e;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--medical-blue);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar-header {
            padding: 24px 20px;
            background-color: var(--medical-dark-blue);
        }
        
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-link.active {
            background-color: white;
            color: var(--medical-blue);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        /* Main Content Styling */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .top-navbar {
            background-color: var(--medical-dark-blue);
            color: white;
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        }

        .content-body {
            padding: 2rem;
            background-color: #ffffff;
            flex-grow: 1;
            margin: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        }

        /* Sidebar Toggle Button */
        #sidebarToggle {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            display: none;
            cursor: pointer;
        }

        /* Buttons & Accents */
        .btn-success {
            background-color: var(--accent-green) !important;
            border-color: var(--accent-green) !important;
            font-weight: 500;
        }

        .btn-success:hover {
            filter: brightness(95%);
        }

        .btn-primary {
            background-color: var(--medical-blue);
            border-color: var(--medical-blue);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            #sidebarToggle {
                display: block;
            }
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:998;"></div>

    <!-- Sidebar -->
    <?php if(auth()->guard()->check()): ?>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand">
                <i class="bi bi-heart-pulse-fill"></i>
                <span>RAKYAT SEHAT</span>
            </a>
        </div>
        <div class="mt-3">
            <ul class="nav flex-column">
                <?php if(auth()->user()->role === 'superadmin'): ?>
                    <?php echo $__env->make('partials._sidebar_superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php elseif(auth()->user()->role === 'doctor'): ?>
                    <?php echo $__env->make('partials._sidebar_doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php elseif(auth()->user()->role === 'kasir'): ?>
                    <?php echo $__env->make('partials._sidebar_kasir', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php elseif(auth()->user()->role === 'apotek'): ?>
                    <?php echo $__env->make('partials._sidebar_apotek', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php else: ?>
                    <?php echo $__env->make('partials._sidebar_staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="main-content" <?php if(auth()->guard()->guest()): ?> style="margin-left: 0;" <?php endif; ?>>
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <?php if(auth()->guard()->check()): ?>
                <button id="sidebarToggle" class="me-3">
                    <i class="bi bi-list"></i>
                </button>
                <?php endif; ?>
                <h5 class="mb-0 fw-semibold"><?php echo e($title ?? 'Sistem Informasi Rekam Medis'); ?></h5>
            </div>
            
            <?php if(auth()->guard()->check()): ?>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-white text-decoration-none dropdown-toggle p-0" type="button" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(Auth::user()->name)); ?>&background=fff&color=0369a1" class="rounded-circle me-2" width="32" height="32">
                        <span class="d-none d-md-inline"><?php echo e(Auth::user()->name); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-3">
                        <li><a class="dropdown-item" href="<?php echo e(auth()->user()->role === 'doctor' ? route('doctor.profile.edit') : route('profile.edit')); ?>"><i class="bi bi-person me-2"></i> Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </header>

        <!-- Content -->
        <main class="content-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').style.display = 
                document.getElementById('sidebarOverlay').style.display === 'block' ? 'none' : 'block';
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.style.display = 'none';
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\rekam_medis\resources\views/app.blade.php ENDPATH**/ ?>