<div class="row">
    <div class="col-md-10 mx-auto">

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

                                        <span class="badge bg-warning text-dark">Retrait</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">Transfert</span>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>


    </div>
</div>
