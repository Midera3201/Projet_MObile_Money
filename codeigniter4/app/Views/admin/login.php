<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0d6efd, #6610f2); min-height: 100vh; display: flex; align-items: center; }
        .card { border-radius: 15px; border: none; }
        .btn { border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-body p-5 text-center">
                        <h3 class="mb-3">Administration</h3>
                        <p class="text-muted mb-4">MobileMoney</p>
                        <?php if (session()->getFlashdata("error")): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
                        <?php endif; ?>
                        <form method="post" action="/admin/login">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-lg" name="username" placeholder="Utilisateur" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control form-control-lg" name="password" placeholder="Mot de passe" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Connexion</button>
                        </form>
                        <hr class="my-4">
                        <a href="/login" class="btn btn-outline-secondary w-100">← Espace Client</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
