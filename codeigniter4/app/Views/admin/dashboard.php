<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white text-center p-3">
            <h5>Clients</h5>
            <h2><?= $totalClients ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white text-center p-3">
            <h5>Gains totaux</h5>
            <h2><?= format_argent($totalGains) ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white text-center p-3">
            <h5>Operations</h5>
            <h2><?= array_sum(array_column($gains, 'nombre_operations')) ?></h2>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white"><h5 class="mb-0">Situation des gains (Frais)</h5></div>
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead class="table-light"><tr><th>Type</th><th>Nb operations</th><th>Total montant</th><th>Total frais</th></tr></thead>
            <tbody>
                <?php if (empty($gains)): ?>
                    <tr><td colspan="4" class="text-center text-muted">Aucune transaction</td></tr>
                <?php else: ?>
                    <?php foreach ($gains as $g): ?>
                        <tr>
                            <td><?= $g->type_operation ?></td>
                            <td><?= $g->nombre_operations ?></td>
                            <td><?= format_argent($g->total_montant) ?></td>
                            <td class="text-success fw-bold"><?= format_argent($g->total_frais) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">Situation des comptes clients</h5></div>
    <div class="card-body">
        <table class="table table-bordered table-striped mb-0">
            <thead class="table-light"><tr><th>Telephone</th><th>Solde</th><th>Nb transactions</th><th>Inscrit le</th></tr></thead>
            <tbody>
                <?php if (empty($comptes)): ?>
                    <tr><td colspan="4" class="text-center text-muted">Aucun client</td></tr>
                <?php else: ?>
                    <?php foreach ($comptes as $c): ?>
                        <tr>
                            <td><?= $c->telephone ?></td>
                            <td class="fw-bold"><?= format_argent($c->solde) ?></td>
                            <td><?= $c->nombre_transactions ?></td>
                            <td><?= $c->created_at ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>