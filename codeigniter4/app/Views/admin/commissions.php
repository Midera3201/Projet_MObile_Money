$pageTitle = 'Commissions';
<?= view("admin/templates/header") ?>

<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<p class="text-muted mb-4" style="font-size:13px;">
    Pourcentage de commission appliqué aux transferts sortants vers chaque opérateur externe.
</p>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Configuration des commissions</h6>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Opérateur</th>
                    <th>Préfixe</th>
                    <th>Commission actuelle</th>
                    <th>Nouveau pourcentage (%)</th>
                    <th>Statut</th>
                    <th style="width:150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operateurs as $op): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($op["nom"]) ?></strong></td>
                        <td><strong><?= htmlspecialchars($op["prefixe"]) ?></strong></td>
                        <td><span class="badge-custom active"><?= $op["commission_pct"] ?>%</span></td>
                        <td>
                            <?php if ($op["actif"]): ?>
                                <form method="post" action="/admin/commissions/update/<?= $op["id"] ?>" class="form-custom d-flex gap-2 align-items-center">
                                    <input type="number" class="form-control" name="commission_pct" value="<?= $op["commission_pct"] ?>" step="0.01" min="0" max="100" style="width:90px;">
                                    <button type="submit" class="btn-custom green"><i class="bi bi-check-lg"></i> Modifier</button>
                                </form>
                            <?php else: ?>
                                <span style="color:var(--text-light);font-size:13px;">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($op["actif"]): ?>
                                <span class="badge-custom active">Actif</span>
                            <?php else: ?>
                                <span class="badge-custom inactive">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/admin/operateurs" class="btn-custom blue"><i class="bi bi-eye"></i> Détails</a>
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
