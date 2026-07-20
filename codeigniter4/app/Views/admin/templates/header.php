<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>M-Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #16A34A;
            --primary-light: #f0fdf4;
            --primary-hover: #15803d;
            --blue: #2563EB;
            --red: #DC2626;
            --orange: #EA580C;
            --gray: #64748B;
            --text: #1E293B;
            --text-light: #64748B;
            --bg: #F4FCF0;
            --white: #FFFFFF;
            --border: #E2E8F0;
            --sidebar-w: 260px;
            --navbar-h: 60px;
            --radius: 10px;
            --radius-sm: 8px;
        }

        * { font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--text); margin: 0; font-size: 14px; }

        .app-layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--white);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            overflow-y: auto;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand h5 {
            font-weight: 700;
            font-size: 18px;
            color: var(--text);
            margin: 0;
            letter-spacing: -0.5px;
        }
        .sidebar-brand small {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 400;
        }
        .sidebar-nav {
            padding: 12px 0;
        }
        .sidebar-nav .nav-section {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 24px 8px;
        }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 24px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }
        .sidebar-nav .nav-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        .sidebar-nav .nav-link:hover {
            color: var(--text);
            background: var(--bg);
        }
        .sidebar-nav .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
            border-left-color: var(--primary);
            font-weight: 600;
        }
        .sidebar-nav .nav-link.active i {
            color: var(--primary);
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
        }

        /* Navbar */
        .top-navbar {
            height: var(--navbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .top-navbar .page-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }
        .top-navbar .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .top-navbar .navbar-actions .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
        }

        /* Page content */
        .page-content {
            padding: 32px;
        }

        /* Cards */
        .card-custom {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0px 2px 8px rgba(15, 23, 42, 0.05);
        }
        .card-custom .card-header-custom {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-custom .card-header-custom h6 {
            font-weight: 600;
            font-size: 14px;
            margin: 0;
            color: var(--text);
        }
        .card-custom .card-body-custom {
            padding: 24px;
        }

        /* Stat cards */
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 2px 8px rgba(15, 23, 42, 0.05);
        }
        .stat-card .stat-label {
            font-size: 12.5px;
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .stat-card .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
            margin-top: 4px;
        }
        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Buttons */
        .btn-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0 16px;
            height: 38px;
            font-size: 13px;
            font-weight: 500;
            border-radius: var(--radius-sm);
            background: var(--white);
            border: 1px solid var(--border);
            color: var(--text);
            text-decoration: none;
            transition: all 0.15s;
            cursor: pointer;
        }
        .btn-custom:hover {
            background: var(--bg);
            box-shadow: 0px 2px 8px rgba(15, 23, 42, 0.06);
            color: var(--text);
        }
        .btn-custom i { font-size: 14px; }
        .btn-custom.green { color: var(--primary); border-color: #bbf7d0; }
        .btn-custom.green:hover { background: var(--primary-light); }
        .btn-custom.blue { color: var(--blue); border-color: #bfdbfe; }
        .btn-custom.blue:hover { background: #eff6ff; }
        .btn-custom.red { color: var(--red); border-color: #fecaca; }
        .btn-custom.red:hover { background: #fef2f2; }
        .btn-custom.orange { color: var(--orange); border-color: #fed7aa; }
        .btn-custom.orange:hover { background: #fff7ed; }

        /* Tables */
        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }
        .table-custom thead th {
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .table-custom tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 13.5px;
            color: var(--text);
            vertical-align: middle;
        }
        .table-custom tbody tr:hover {
            background: var(--bg);
        }
        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
        }
        .badge-custom.active {
            background: var(--primary-light);
            color: var(--primary);
        }
        .badge-custom.inactive {
            background: #f1f5f9;
            color: var(--gray);
        }
        .badge-custom.depot {
            background: var(--primary-light);
            color: var(--primary);
        }
        .badge-custom.retrait {
            background: #fff7ed;
            color: var(--orange);
        }
        .badge-custom.transfert {
            background: #eff6ff;
            color: var(--blue);
        }

        /* Forms */
        .form-custom .form-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 6px;
        }
        .form-custom .form-control,
        .form-custom .form-select {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            padding: 8px 12px;
            color: var(--text);
            transition: border-color 0.15s;
        }
        .form-custom .form-control:focus,
        .form-custom .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(22,163,74,0.08);
        }

        /* Alerts */
        .alert-custom {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            border: 1px solid;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-custom.success {
            background: var(--primary-light);
            color: var(--primary);
            border-color: #bbf7d0;
        }
        .alert-custom.error {
            background: #fef2f2;
            color: var(--red);
            border-color: #fecaca;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h5>M-Money</h5>
            <small>Gestion Mobile Money</small>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Principal</div>
            <a class="nav-link <?= uri_string() === 'admin' || uri_string() === '' ? 'active' : '' ?>" href="/admin">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <div class="nav-section">Configuration</div>
            <a class="nav-link <?= uri_string() === 'admin/prefixes' ? 'active' : '' ?>" href="/admin/prefixes">
                <i class="bi bi-hash"></i> Préfixes
            </a>
            <a class="nav-link <?= uri_string() === 'admin/types' ? 'active' : '' ?>" href="/admin/types">
                <i class="bi bi-tags"></i> Types d'opérations
            </a>
            <a class="nav-link <?= uri_string() === 'admin/baremes' ? 'active' : '' ?>" href="/admin/baremes">
                <i class="bi bi-cash-stack"></i> Barèmes de frais
            </a>

            <div class="nav-section">Opérateurs</div>
            <a class="nav-link <?= uri_string() === 'admin/operateurs' ? 'active' : '' ?>" href="/admin/operateurs">
                <i class="bi bi-broadcast"></i> Opérateurs externes
            </a>
            <a class="nav-link <?= uri_string() === 'admin/commissions' ? 'active' : '' ?>" href="/admin/commissions">
                <i class="bi bi-percent"></i> Commissions
            </a>

            <div class="nav-section">Analyse</div>
            <a class="nav-link <?= uri_string() === 'admin/reporting/gains' ? 'active' : '' ?>" href="/admin/reporting/gains">
                <i class="bi bi-graph-up"></i> Situation des gains
            </a>
            <a class="nav-link <?= uri_string() === 'admin/reporting/montants' ? 'active' : '' ?>" href="/admin/reporting/montants">
                <i class="bi bi-arrow-left-right"></i> Montants à reverser
            </a>

            <div class="nav-section mt-3">Compte</div>
            <a class="nav-link text-danger" href="/admin/logout">
                <i class="bi bi-box-arrow-left"></i> Déconnexion
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-navbar">
            <div class="page-title"><?= $pageTitle ?? 'Dashboard' ?></div>
            <div class="navbar-actions">
                <div class="avatar">A</div>
            </div>
        </header>
        <div class="page-content">
