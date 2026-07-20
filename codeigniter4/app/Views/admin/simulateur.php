<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Simulateur de transfert</h2>

    <p class="text-muted mb-4">
        Testez le calcul des frais pour un transfert vers un numero interne ou externe.
    </p>

    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Parametres du transfert</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="/admin/simulateur">
                        <div class="mb-3">
                            <label class="form-label">Numero du destinataire</label>
                            <input type="text" class="form-control" name="destinataire" placeholder="033 00 000 00" maxlength="10" required
                                value="<?= old('destinataire') ?>">
                            <div class="form-text">
                                Prefices internes : 033, 037 — Externes :
                                <?php foreach ($operateurs as $op): ?>
                                    <?= htmlspecialchars($op["prefixe"]) ?> (<?= htmlspecialchars($op["nom"]) ?>),
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Montant (Ar)</label>
                            <input type="number" class="form-control" name="montant" min="100" step="100" placeholder="10000" required
                                value="<?= old('montant') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Calculer les frais</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <?php if ($resultat): ?>
                <div class="card shadow mb-4 <?= $resultat["est_externe"] ? "border-warning" : "border-success" ?>">
                    <div class="card-header <?= $resultat["est_externe"] ? "bg-warning" : "bg-success" ?> text-white">
                        <h5 class="mb-0">
                            <?php if ($resultat["est_externe"]): ?>
                                Transfert EXTERNE vers <?= htmlspecialchars($resultat["nom_operateur"]) ?>
                            <?php else: ?>
                                Transfert INTERNE
                            <?php endif; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Montant a transferer</td>
                                <td class="text-end fw-bold"><?= format_argent($resultat["montant"]) ?></td>
                            </tr>
                            <tr>
                                <td>Frais de transfert (bareme)</td>
                                <td class="text-end"><?= format_argent($resultat["frais_base"]) ?></td>
                            </tr>
                            <?php if ($resultat["est_externe"]): ?>
                                <tr class="table-warning">
                                    <td>Commission externe (<?= htmlspecialchars($resultat["nom_operateur"]) ?>)</td>
                                    <td class="text-end fw-bold"><?= format_argent($resultat["commission_externe"]) ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="table-light">
                                <td><strong>Total a debiter</strong></td>
                                <td class="text-end"><strong><?= format_argent($resultat["total"]) ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow">
                    <div class="card-body text-center text-muted py-5">
                        <h5>Resultat du calcul</h5>
                        <p>Remplissez le formulaire et cliquez sur "Calculer" pour voir le detail des frais.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($baremes)): ?>
    <div class="card shadow mt-4">
        <div class="card-header">
            <h5 class="mb-0">Baremes de frais actuels</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Tranche min</th>
                        <th>Tranche max</th>
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
</div>
<?= view("admin/templates/footer") ?>
