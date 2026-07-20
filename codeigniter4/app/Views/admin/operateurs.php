<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Opérateurs externes</h2>

    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="/admin/operateurs/create" class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" placeholder="Orange, Yas..." required>
                </div>
                <div class="col-auto">
                    <label class="form-label">Préfixe</label>
                    <input type="text" class="form-control" name="prefixe" placeholder="032" maxlength="3" required>
                </div>
                <div class="col-auto">
                    <label class="form-label">Commission (%)</label>
                    <input type="number" class="form-control" name="commission_pct" step="0.01" value="0" required>
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
                    <tr>
                        <th>Nom</th>
                        <th>Préfixe</th>
                        <th>Commission</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($operateurs as $op): ?>
                        <tr>
                            <td><?= htmlspecialchars($op["nom"]) ?></td>
                            <td><?= htmlspecialchars($op["prefixe"]) ?></td>
                            <td><?= $op["commission_pct"] ?>%</td>
                            <td>
                                <?php if ($op["actif"]): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $op["date_creation"] ?></td>
                            <td>
                                <a href="/admin/operateurs/toggle/<?= $op["id"] ?>" class="btn btn-sm btn-warning">
                                    <?= $op["actif"] ? "Désactiver" : "Activer" ?>
                                </a>
                                <a href="/admin/operateurs/delete/<?= $op["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet opérateur ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
