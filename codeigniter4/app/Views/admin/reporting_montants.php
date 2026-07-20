$pageTitle = 'Montants à reverser';
<?= view("admin/templates/header") ?>

<div class="card-custom mb-4">
    <div class="card-body-custom text-center py-4">
        <div class="stat-label mb-2">Total à reverser</div>
        <div style="font-size:28px;font-weight:700;color:var(--red);"><?= format_argent($totalAReverser) ?></div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Détail par opérateur</h6>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Opérateur</th>
                    <th>Préfixe</th>
                    <th>Commission (%)</th>
                    <th style="text-align:right;">Nb transferts</th>
                    <th style="text-align:right;">Montant à reverser</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($montants as $m): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($m["nom"]) ?></strong></td>
                        <td><strong><?= htmlspecialchars($m["prefixe"]) ?></strong></td>
                        <td><?= $m["commission_pct"] ?>%</td>
                        <td style="text-align:right;"><?= $m["nb_transferts"] ?></td>
                        <td style="text-align:right;font-weight:600;<?= $m["commission_totale"] > 0 ? 'color:var(--red);' : '' ?>">
                            <?= format_argent($m["commission_totale"]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($montants)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color:var(--text-light);">Aucun opérateur externe configuré</td>
                    </tr>
                <?php endif; ?>
                <tr style="background:var(--bg);">
                    <td colspan="4" style="font-weight:700;">Total</td>
                    <td style="text-align:right;font-weight:700;color:var(--red);"><?= format_argent($totalAReverser) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?= view("admin/templates/footer") ?>
