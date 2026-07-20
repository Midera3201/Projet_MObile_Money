

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-body text-center p-5">
                <h2>Bienvenue</h2>
                <p class="lead"><?= $client['telephone'] ?></p>
                <hr>
                <h1 class="display-4 text-primary"><?= number_format($client['solde'], 0, ',', ' ') ?> FCFA</h1>
                <p class="text-muted">Solde disponible</p>
            </div>
        </div>

        <div class="row mt-4 g-2">
            <div class="col-3">
                <a href="/client/depot" class="btn btn-success w-100 py-3">
                    <div class="fw-bold">Dépôt</div>

                </a>
            </div>
            <div class="col-3">
                <a href="/client/retrait" class="btn btn-warning w-100 py-3">
                    <div class="fw-bold">Retrait</div>
                    <small>Retirer</small>
                </a>
            </div>
            <div class="col-3">
                <a href="/client/transfert" class="btn btn-info text-white w-100 py-3">
                    <div class="fw-bold">Transfert</div>

                </a>
            </div>
        </div>
    </div>
</div>
