<?php if (empty($transactions)): ?>
    <div class="card-custom">
        <div class="card-body-custom text-center py-5" style="color:var(--text-light);">
            <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px;"></i>
            Aucune transaction pour le moment.
        </div>
    </div>
<?php else: ?>
    <div class="card-custom">
        <div class="card-body-custom p-0">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th style="text-align:right;">Montant</th>
                        <th style="text-align:right;">Frais</th>
                        <th style="text-align:right;">Total</th>
                        <th>Destinataire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td style="color:var(--text-light);font-size:13px;"><?= date("d/m/Y H:i", strtotime($t["date_creation"])) ?></td>
                            <td>
                                <?php if ($t["type_operation"] === "depot"): ?>
                                    <span class="badge-custom depot">Dépôt</span>
                                <?php elseif ($t["type_operation"] === "retrait"): ?>
                                    <span class="badge-custom retrait">Retrait</span>
                                <?php else: ?>
                                    <span class="badge-custom transfert">Transfert</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:right;font-weight:600;"><?= number_format($t["montant"], 0, ",", " ") ?> Ar</td>
                            <td style="text-align:right;color:var(--text-light);"><?= $t["frais"] > 0 ? number_format($t["frais"], 0, ",", " ") . ' Ar' : '-' ?></td>
                            <td style="text-align:right;"><?= number_format($t["montant_total"], 0, ",", " ") ?> Ar</td>
                            <td style="font-size:13px;"><?= $t["destinataire"] ?: '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<div class="mt-3">
    <a href="/client/dashboard" class="btn-custom"><i class="bi bi-arrow-left"></i> Retour</a>
</div>
