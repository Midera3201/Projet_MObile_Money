<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Promotions de frais</h2>

    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white fw-bold">Nouvelle promotion</div>
        <div class="card-body">
            <form method="post" action="/admin/promotions/create" class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="code" placeholder="Code (ex: PROMO_ETE)" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="description" placeholder="Description">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="id_type_operation" required>
                        <option value="3">Transfert</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="prefixe_source" placeholder="Source (033)" maxlength="3" required>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="prefixe_dest" placeholder="Dest (033)" maxlength="3" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="frais_fixe_promo" placeholder="Frais fixe promo" step="0.01">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="frais_pourcentage_promo" placeholder="% promo" step="0.01">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="montant_min" placeholder="Montant min" step="0.01">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="montant_max" placeholder="Montant max" step="0.01">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_debut" required>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_fin" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr><th>Code</th><th>Description</th><th>Source→Dest</th><th>Frais promo</th><th>% promo</th><th>Montant</th><th>Validité</th><th>Statut</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($promotions as $p): ?>
                        <tr>
                            <td class="fw-bold"><?= $p["code"] ?></td>
                            <td><?= $p["description"] ?></td>
                            <td><?= $p["prefixe_source"] ?>→<?= $p["prefixe_dest"] ?></td>
                            <td><?= $p["frais_fixe_promo"] ?></td>
                            <td><?= $p["frais_pourcentage_promo"] ?>%</td>
                            <td><?= number_format($p["montant_min"], 0, ",", " ") ?> - <?= number_format($p["montant_max"], 0, ",", " ") ?></td>
                            <td><?= $p["date_debut"] ?> → <?= $p["date_fin"] ?></td>
                            <td><?= $p["statut"] ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-danger">Inactif</span>' ?></td>
                            <td>
                                <a href="/admin/promotions/toggle/<?= $p["id"] ?>" class="btn btn-sm btn-warning">Activer/Désactiver</a>
                                <a href="/admin/promotions/delete/<?= $p["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
