<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileMoney - Transfert d'argent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; letter-spacing: -0.5px; }
        .card { border-radius: 16px; border: none; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .btn { border-radius: 10px; font-weight: 600; }
        .display-4 { font-weight: 700; }
        .btn-action { transition: transform 0.15s; }
        .btn-action:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-phone me-2"></i>MobileMoney
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (session()->has("user")): ?>
                    <li class="nav-item"><a class="nav-link" href="/client/dashboard"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/client/historique"><i class="bi bi-clock-history me-1"></i>Historique</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-light text-primary ms-2 px-3 rounded-pill" href="/logout"><i class="bi bi-box-arrow-right me-1"></i>Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
