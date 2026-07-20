<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Tableau de bord</h2>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Clients</h5>
                    <h2 class="display-6"><?= $totalClients ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Dépôts</h5>
                    <h2 class="display-6"><?= $totalDepots ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Retraits</h5>
                    <h2 class="display-6"><?= $totalRetraits ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Transferts</h5>
                    <h2 class="display-6"><?= $totalTransferts ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Total transactions</h5>
                    <h3><?= $totalTransactions ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
