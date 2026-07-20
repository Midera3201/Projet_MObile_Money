<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baremes de frais</title>
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
        <h2>Baremes de frais</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="/admin/baremes/create" class="row g-3">
                    <div class="col-auto">
                        <select name="type_operation_id" class="form-select" required>
                            <option value="">Type</option>
                            <?php foreach ($types as $t): ?>
                                <option value="<?= $t->id ?>"><?= $t->nom ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="montant_min" class="form-control" placeholder="Min (Ar)" required>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="montant_max" class="form-control" placeholder="Max (Ar)" required>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="frais_fixe" class="form-control" placeholder="Frais (Ar)" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead><tr><th>ID</th><th>Type</th><th>Min</th><th>Max</th><th>Frais</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($baremes as $b): ?>
                    <tr>
                        <td><?= $b->id ?></td>
                        <td><?= $b->type_nom ?></td>
                        <td><?= format_argent($b->montant_min) ?></td>
                        <td><?= format_argent($b->montant_max) ?></td>
                        <td class="text-danger fw-bold"><?= format_argent($b->frais_fixe) ?></td>
                        <td>
                            <a href="/admin/baremes/delete/<?= $b->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/admin" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>