<div class="row">
    <div class="col-md-10 mx-auto">
        <h3 class="mb-4">Historique des transactions</h3>

        <?php if (empty($transactions)): ?>
            <div class="alert alert-info">Aucune transaction pour le moment.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Total</th>
                            <th>Destinataire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= $t['date_creation'] ?></td>
                                <td>
                                    <?php if ($t['type_operation'] === 'depot'): ?>
                                        <span class="badge bg-success">Dépôt</span>
                                    <?php elseif ($t['type_operation'] === 'retrait'): ?>
                                        <span class="badge bg-warning text-dark">Retrait</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">Transfert</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($t['montant'], 0, ',', ' ') ?></td>
                                <td><?= number_format($t['frais'], 0, ',', ' ') ?></td>
                                <td><?= number_format($t['montant_total'], 0, ',', ' ') ?></td>
                                <td><?= $t['destinataire'] ?: '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="/client/dashboard" class="btn btn-outline-primary mt-3">Retour au dashboard</a>
    </div>
</div>
