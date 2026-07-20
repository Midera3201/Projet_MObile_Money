$pageTitle = 'Barèmes de frais';
<?= view("admin/templates/header") ?>

<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6>Ajouter un barème</h6>
    </div>
    <div class="card-body-custom">
        <form method="post" action="/admin/baremes/create" class="form-custom">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="id_type_operation" required>
                        <option value="">Choisir</option>
                        <?php foreach ($types as $t): ?>
                            <option value="<?= $t["id"] ?>"><?= htmlspecialchars($t["libelle"]) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Montant min (Ar)</label>
                    <input type="number" class="form-control" name="montant_min" step="100" placeholder="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Montant max (Ar)</label>
                    <input type="number" class="form-control" name="montant_max" step="100" placeholder="100000" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Frais fixe (Ar)</label>
                    <input type="number" class="form-control" name="frais_fixe" step="0.01" placeholder="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Pourcentage (%)</label>
                    <input type="number" class="form-control" name="frais_pourcentage" step="0.01" placeholder="0">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn-custom green"><i class="bi bi-plus-lg"></i> Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Liste des barèmes</h6>
        <span class="badge-custom inactive"><?= count($baremes) ?> barème(s)</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Frais fixe</th>
                    <th>Pourcentage</th>
                    <th style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($baremes as $b): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($b["type_libelle"]) ?></strong></td>
                        <td><?= format_argent($b["montant_min"]) ?></td>
                        <td><?= format_argent($b["montant_max"]) ?></td>
                        <td><?= format_argent($b["frais_fixe"]) ?></td>
                        <td><?= $b["frais_pourcentage"] ?>%</td>
                        <td>
                            <a href="/admin/baremes/delete/<?= $b["id"] ?>" class="btn-custom red" onclick="return confirm('Supprimer ce barème ?')">
                                <i class="bi bi-trash3"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($baremes)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color:var(--text-light);">Aucun barème enregistré</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view("admin/templates/footer") ?>
