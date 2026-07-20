<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .card { border-radius: 15px; border: none; }
        .btn { border-radius: 10px; }
        .display-4 { font-weight: 700; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16"><path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/><path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
            MobileMoney
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (session()->has("user")): ?>
                    <li class="nav-item"><a class="nav-link" href="/client/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/client/historique">Historique</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-light text-primary ms-2 px-3" href="/logout">D?connexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
