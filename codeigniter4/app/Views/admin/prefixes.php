<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Gestion des préfixes</h2>
    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="/admin/prefixes/create" class="row g-2">
                <div class="col-auto">
                    <input type="text" class="form-control" name="prefixe" placeholder="033" maxlength="3" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr><th>Préfixe</th><th>Statut</th><th>Date</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($prefixes as $p): ?>
                        <tr>
                            <td><?= $p["prefixe"] ?></td>
                            <td><?= $p["statut"] ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-danger">Inactif</span>' ?></td>
                            <td><?= $p["date_creation"] ?></td>
                            <td>
                                <a href="/admin/prefixes/toggle/<?= $p["id"] ?>" class="btn btn-sm btn-warning">Activer/Désactiver</a>
                                <a href="/admin/prefixes/delete/<?= $p["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
