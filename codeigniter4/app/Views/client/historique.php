<div class="row">
    <div class="col-md-10 mx-auto">
        <h3 class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5-3.5a.5.5 0 0 1 .5.5V8h2.5a.5.5 0 0 1 0 1H8.5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 1 .5-.5z"/></svg>
            Historique des transactions
        </h3>

        <?php if (empty($transactions)): ?>
            <div class="alert alert-info text-center">Aucune transaction pour le moment.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
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
                                <td><?= date("d/m/Y H:i", strtotime($t["date_creation"])) ?></td>
                                <td>
                                    <?php if ($t["type_operation"] === "depot"): ?>
                                        <span class="badge bg-success">Dépôt</span>
                                    <?php elseif ($t["type_operation"] === "retrait"): ?>
                                        <span class="badge bg-warning text-dark">Retrait</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">Transfert</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= number_format($t["montant"], 0, ",", " ") ?></td>
                                <td><?= $t["frais"] > 0 ? number_format($t["frais"], 0, ",", " ") : "-" ?></td>
                                <td><?= number_format($t["montant_total"], 0, ",", " ") ?></td>
                                <td><?= $t["destinataire"] ?: "-" ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="/client/dashboard" class="btn btn-outline-primary">Retour au dashboard</a>
        </div>
    </div>
</div>
