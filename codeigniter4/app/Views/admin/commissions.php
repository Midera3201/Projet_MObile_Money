<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Gestion des commissions</h2>

    <p class="text-muted mb-4">
        Configurez le pourcentage de commission applique aux transferts sortants vers chaque operateur externe.
    </p>

    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Operateur</th>
                        <th>Prefixe</th>
                        <th>Commission actuelle</th>
                        <th>Nouveau pourcentage (%)</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($operateurs as $op): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($op["nom"]) ?></strong></td>
                            <td><?= htmlspecialchars($op["prefixe"]) ?></td>
                            <td>
                                <span class="badge bg-info fs-6"><?= $op["commission_pct"] ?>%</span>
                            </td>
                            <td>
                                <?php if ($op["actif"]): ?>
                                    <form method="post" action="/admin/commissions/update/<?= $op["id"] ?>" class="d-flex gap-2">
                                        <input type="number" class="form-control form-control-sm" name="commission_pct" value="<?= $op["commission_pct"] ?>" step="0.01" min="0" max="100" style="width: 100px;">
                                        <button type="submit" class="btn btn-sm btn-primary">Modifier</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Operateur inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($op["actif"]): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/operateurs" class="btn btn-sm btn-outline-secondary">Voir details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
