<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #16A34A;
            --primary-light: #f0fdf4;
            --blue: #2563EB;
            --red: #DC2626;
            --orange: #EA580C;
            --gray: #64748B;
            --text: #1E293B;
            --text-light: #64748B;
            --bg: #F8FAFC;
            --white: #FFFFFF;
            --border: #E2E8F0;
            --radius: 10px;
            --radius-sm: 8px;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--text); margin: 0; font-size: 14px; }

        .client-navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .client-navbar .brand {
            font-weight: 700;
            font-size: 16px;
            color: var(--text);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .client-navbar .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .client-navbar .nav-actions a {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-light);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            transition: all 0.15s;
        }
        .client-navbar .nav-actions a:hover { background: var(--bg); color: var(--text); }
        .client-navbar .nav-actions a.active { color: var(--primary); background: var(--primary-light); }
        .client-page { padding: 32px; max-width: 960px; margin: 0 auto; }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .card-custom {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .card-custom .card-header-custom {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 14px;
        }
        .card-custom .card-body-custom { padding: 24px; }

        .btn-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
        .btn-custom:hover { background: var(--bg); box-shadow: 0 1px 3px rgba(0,0,0,0.06); color: var(--text); }
        .btn-custom.green { color: var(--primary); border-color: #bbf7d0; }
        .btn-custom.green:hover { background: var(--primary-light); }
        .btn-custom.blue { color: var(--blue); border-color: #bfdbfe; }
        .btn-custom.blue:hover { background: #eff6ff; }
        .btn-custom.full { width: 100%; }

        .form-custom .form-label { font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        .form-custom .form-control {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            padding: 10px 14px;
        }
        .form-custom .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(22,163,74,0.08); }

        .alert-custom { padding: 10px 14px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; border: 1px solid; margin-bottom: 20px; }
        .alert-custom.success { background: var(--primary-light); color: var(--primary); border-color: #bbf7d0; }
        .alert-custom.error { background: #fef2f2; color: var(--red); border-color: #fecaca; }

        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom thead th { background: var(--bg); border-bottom: 1px solid var(--border); padding: 10px 16px; font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.3px; }
        .table-custom tbody td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13.5px; }
        .table-custom tbody tr:last-child td { border-bottom: none; }

        .badge-custom { display: inline-flex; align-items: center; padding: 3px 10px; font-size: 12px; font-weight: 500; border-radius: 6px; }
        .badge-custom.depot { background: var(--primary-light); color: var(--primary); }
        .badge-custom.retrait { background: #fff7ed; color: var(--orange); }
        .badge-custom.transfert { background: #eff6ff; color: var(--blue); }
    </style>
</head>
<body>
<nav class="client-navbar">
    <a class="brand" href="/client/dashboard">M-Money</a>
    <div class="nav-actions">
        <a href="/client/dashboard" class="active"><i class="bi bi-grid-1x2 me-1"></i> Dashboard</a>
        <a href="/client/historique"><i class="bi bi-clock-history me-1"></i> Historique</a>
        <a href="/logout"><i class="bi bi-box-arrow-left me-1"></i> Déconnexion</a>
    </div>
</nav>
<div class="client-page">
