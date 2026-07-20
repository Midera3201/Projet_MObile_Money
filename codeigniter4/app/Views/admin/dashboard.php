<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/admin">Mobile Money - Admin</a>
            <div>
                <span class="text-light me-3"><?= session()->get('admin')['login'] ?? '' ?></span>
                <a href="/admin/logout" class="btn btn-outline-light btn-sm">Deconnexion</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Tableau de bord</h2>

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
                    <h5>Operations fee revenue</h5>
                    <h2><?= array_sum(array_column($gains, 'nombre_operations')) ?></h2>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h5>Situation des gains (Frais)</h5></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th>Type</th><th>Nb operations</th><th>Total montant</th><th>Total frais</th></tr></thead>
                    <tbody>
                        <?php if (empty($gains)): ?>
                            <tr><td colspan="4" class="text-center">Aucune transaction pour le moment</td></tr>
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

        <div class="card mb-4">
            <div class="card-header"><h5>Situation des comptes clients</h5></div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>Telephone</th><th>Solde</th><th>Nb transactions</th><th>Inscrit le</th></tr></thead>
                    <tbody>
                        <?php if (empty($comptes)): ?>
                            <tr><td colspan="4" class="text-center">Aucun client</td></tr>
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

        <div class="mb-4">
            <a href="/admin/prefixes" class="btn btn-outline-primary me-2">Prefixes</a>
            <a href="/admin/types" class="btn btn-outline-primary me-2">Types operations</a>
            <a href="/admin/baremes" class="btn btn-outline-primary">Baremes</a>
        </div>
    </div>
</body>
</html>