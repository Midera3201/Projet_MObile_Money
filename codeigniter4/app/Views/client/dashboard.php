
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

        </div>
    </div>
</div>
