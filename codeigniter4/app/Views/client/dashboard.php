<?php if (session()->getFlashdata("success")): ?>
    <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata("success") ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?= session()->getFlashdata("error") ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg text-center">
            <div class="card-body p-5">
                <p class="text-muted mb-0">Bienvenue</p>
                <h4><?= $client["telephone"] ?></h4>
                <hr class="my-4">
                <p class="text-muted mb-0">Solde disponible</p>
                <h1 class="display-4 text-primary fw-bold"><?= number_format($client["solde"], 0, ",", " ") ?> Ar</h1>
            </div>
        </div>

        <div class="row mt-4 g-3">
            <div class="col-4">
                <a href="/client/depot" class="btn btn-success btn-lg w-100 py-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1z"/></svg>
                    <div class="fw-bold mt-1">Dépôt</div>
                </a>
            </div>
            <div class="col-4">
                <a href="/client/retrait" class="btn btn-warning btn-lg w-100 py-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1z" transform="rotate(45 8 8)"/></svg>
                    <div class="fw-bold mt-1">Retrait</div>
                    <small>Retirer</small>
                </a>
            </div>
            <div class="col-4">
                <a href="/client/transfert" class="btn btn-info text-white btn-lg w-100 py-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/></svg>
                    <div class="fw-bold mt-1">Transfert</div>
                    <small>Envoyer</small>
                </a>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="/admin/login" class="btn btn-outline-secondary">← Espace Administration</a>
        </div>
    </div>
</div>
