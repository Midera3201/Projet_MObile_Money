<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types d'operations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/admin">Mobile Money - Admin</a>
            <a href="/admin/logout" class="btn btn-outline-light btn-sm">Deconnexion</a>
        </div>
    </nav>
    <div class="container">
        <h2>Types d'operations</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="/admin/types/create" class="row g-3">
                    <div class="col-auto">
                        <input type="text" name="nom" class="form-control" placeholder="Nom (ex: Depot)" required>
                    </div>
                    <div class="col-auto">
                        <input type="text" name="description" class="form-control" placeholder="Description">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Nom</th><th>Description</th><th>Actif</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($types as $t): ?>
                    <tr>
                        <td><?= $t->id ?></td>
                        <td><strong><?= $t->nom ?></strong></td>
                        <td><?= $t->description ?></td>
                        <td><span class="badge bg-<?= $t->actif ? 'success' : 'secondary' ?>"><?= $t->actif ? 'Oui' : 'Non' ?></span></td>
                        <td>
                            <a href="/admin/types/delete/<?= $t->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/admin" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>