$pageTitle = 'Simulateur';
<?= view("admin/templates/header") ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6>Paramètres du transfert</h6>
    </div>
    <div class="card-body-custom">
        <form method="post" action="/admin/simulateur" class="form-custom">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Numéro destinataire</label>
                    <input type="text" class="form-control" name="destinataire" placeholder="033 00 000 00" maxlength="10" required value="<?= old('destinataire') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Montant (Ar)</label>
                    <input type="number" class="form-control" name="montant" min="100" step="100" placeholder="10000" required value="<?= old('montant') ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn-custom green"><i class="bi bi-calculator"></i> Calculer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if ($resultat): ?>
    <div class="card-custom mb-4">
        <div class="card-header-custom">
            <h6>Résultat</h6>
            <?php if ($resultat["est_externe"]): ?>
                <span class="badge-custom" style="background:#fff7ed;color:#EA580C;">Externe — <?= htmlspecialchars($resultat["nom_operateur"]) ?></span>
            <?php else: ?>
                <span class="badge-custom active">Interne</span>
            <?php endif; ?>
        </div>
        <div class="card-body-custom p-0">
            <table class="table-custom">
                <tbody>
                    <tr>
                        <td>Montant à transférer</td>
                        <td style="text-align:right;font-weight:600;"><?= format_argent($resultat["montant"]) ?></td>
                    </tr>
                    <tr>
                        <td>Frais de transfert (barème)</td>
                        <td style="text-align:right;"><?= format_argent($resultat["frais_base"]) ?></td>
                    </tr>
                    <?php if ($resultat["est_externe"]): ?>
                        <tr>
                            <td>Commission externe (<?= htmlspecialchars($resultat["nom_operateur"]) ?>)</td>
                            <td style="text-align:right;font-weight:600;color:var(--orange);"><?= format_argent($resultat["commission_externe"]) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr style="background:var(--bg);">
                        <td style="font-weight:700;">Total à débiter</td>
                        <td style="text-align:right;font-weight:700;color:var(--primary);font-size:16px;"><?= format_argent($resultat["total"]) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($baremes)): ?>
<div class="card-custom">
    <div class="card-header-custom">
        <h6>Barèmes de frais actuels</h6>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($baremes as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b["type_libelle"]) ?></td>
                        <td><?= format_argent($b["montant_min"]) ?></td>
                        <td><?= format_argent($b["montant_max"]) ?></td>
                        <td><?= format_argent($b["frais_fixe"]) ?></td>
                        <td><?= $b["frais_pourcentage"] ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?= view("admin/templates/footer") ?>
