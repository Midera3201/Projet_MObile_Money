$pageTitle = 'Opérateurs externes';
<?= view("admin/templates/header") ?>

<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6>Ajouter un opérateur</h6>
    </div>
    <div class="card-body-custom">
        <form method="post" action="/admin/operateurs/create" class="form-custom">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" placeholder="Orange" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Préfixe</label>
                    <input type="text" class="form-control" name="prefixe" placeholder="032" maxlength="3" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Commission (%)</label>
                    <input type="number" class="form-control" name="commission_pct" step="0.01" value="0" required>
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
        <h6>Liste des opérateurs</h6>
        <span class="badge-custom inactive"><?= count($operateurs) ?> opérateur(s)</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Préfixe</th>
                    <th>Commission</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th style="width:220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operateurs as $op): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($op["nom"]) ?></strong></td>
                        <td><strong><?= htmlspecialchars($op["prefixe"]) ?></strong></td>
                        <td><?= $op["commission_pct"] ?>%</td>
                        <td>
                            <?php if ($op["actif"]): ?>
                                <span class="badge-custom active">Actif</span>
                            <?php else: ?>
                                <span class="badge-custom inactive">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-light);"><?= $op["date_creation"] ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="/admin/operateurs/toggle/<?= $op["id"] ?>" class="btn-custom orange">
                                    <i class="bi bi-arrow-left-right"></i> <?= $op["actif"] ? "Désactiver" : "Activer" ?>
                                </a>
                                <a href="/admin/operateurs/delete/<?= $op["id"] ?>" class="btn-custom red" onclick="return confirm('Supprimer cet opérateur ?')">
                                    <i class="bi bi-trash3"></i> Supprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($operateurs)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color:var(--text-light);">Aucun opérateur enregistré</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view("admin/templates/footer") ?>
