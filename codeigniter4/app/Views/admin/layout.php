<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: #343a40; width: 220px; position: fixed; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background: #495057; }
        .sidebar h5 { color: #fff; padding: 15px 20px; border-bottom: 1px solid #495057; }
        .main-content { margin-left: 220px; padding: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5>Mobile Money</h5>
        <a href="/admin" class="active">Dashboard</a>
        <a href="/admin/prefixes">Prefixes</a>
        <a href="/admin/types">Types operations</a>
        <a href="/admin/baremes">Baremes de frais</a>
        <hr class="text-secondary">
        <a href="/admin/logout">Deconnexion</a>
    </div>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><?= $title ?? 'Dashboard' ?></h4>
            <span>Admin: <?= session()->get('admin')['login'] ?? '' ?></span>
        </div>
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>