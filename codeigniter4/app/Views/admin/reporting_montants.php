<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Montants a reverser</h2>

    <p class="text-muted mb-4">
        Montant des commissions dues a chaque operateur externe pour les transferts sortants.
    </p>

    <div class="card shadow mb-4 border-danger">
        <div class="card-body text-center">
            <h5 class="text-danger">Total a reverser</h5>
            <h2 class="display-5 text-danger"><?= format_argent($totalAReverser) ?></h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Operateur</th>
                        <th>Prefixe</th>
                        <th>Commission (%)</th>
                        <th>Nb transferts</th>
                        <th>Montant a reverser</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($montants as $m): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($m["nom"]) ?></strong></td>
                            <td><?= htmlspecialchars($m["prefixe"]) ?></td>
                            <td><?= $m["commission_pct"] ?>%</td>
                            <td><?= $m["nb_transferts"] ?></td>
                            <td class="fw-bold <?= $m["commission_totale"] > 0 ? "text-danger" : "" ?>">
                                <?= format_argent($m["commission_totale"]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark text-white">
                        <td colspan="4"><strong>TOTAL</strong></td>
                        <td><strong><?= format_argent($totalAReverser) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
