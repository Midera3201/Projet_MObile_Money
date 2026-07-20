<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Barèmes de frais</h2>
    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="/admin/baremes/create" class="row g-2">
                <div class="col-auto">
                    <select class="form-select" name="id_type_operation" required>
                        <option value="">Type</option>
                        <?php foreach ($types as $t): ?>
                            <option value="<?= $t["id"] ?>"><?= $t["libelle"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <input type="number" class="form-control" name="montant_min" placeholder="Min" step="0.01" required>
                </div>
                <div class="col-auto">
                    <input type="number" class="form-control" name="montant_max" placeholder="Max" step="0.01" required>
                </div>
                <div class="col-auto">
                    <input type="number" class="form-control" name="frais_fixe" placeholder="Frais fixe" step="0.01">
                </div>
                <div class="col-auto">
                    <input type="number" class="form-control" name="frais_pourcentage" placeholder="%" step="0.01">
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
                    <tr><th>Type</th><th>Min</th><th>Max</th><th>Frais fixe</th><th>%</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($baremes as $b): ?>
                        <tr>
                            <td><?= $b["type_libelle"] ?></td>
                            <td><?= number_format($b["montant_min"], 0, ",", " ") ?></td>
                            <td><?= number_format($b["montant_max"], 0, ",", " ") ?></td>
                            <td><?= $b["frais_fixe"] ?></td>
                            <td><?= $b["frais_pourcentage"] ?>%</td>
                            <td>
                                <a href="/admin/baremes/delete/<?= $b["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
