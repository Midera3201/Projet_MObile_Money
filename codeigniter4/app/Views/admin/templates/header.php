<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .sidebar { background: #212529; min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,.7); padding: 12px 20px; border-radius: 0; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar col-2 p-0">
        <div class="p-3 text-white text-center fw-bold fs-4 border-bottom">Admin</div>
        <ul class="nav flex-column mt-2">
            <li class="nav-item"><a class="nav-link" href="/admin">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/prefixes">Préfixes</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/types">Types d'opérations</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/baremes">Barèmes</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/operateurs">Opérateurs externes</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/commissions">Commissions</a></li>
            <li class="nav-item mt-4"><a class="nav-link text-danger" href="/admin/logout">Déconnexion</a></li>
        </ul>
    </div>
    <div class="col-10 p-4">
