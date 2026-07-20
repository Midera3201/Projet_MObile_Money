<?php if (session()->getFlashdata("success")): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm"><?= session()->getFlashdata("success") ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm"><?= session()->getFlashdata("error") ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card text-center">
            <div class="card-body p-5">
                <p class="text-muted mb-0 small text-uppercase tracking-wide">Bienvenue</p>
                <h4 class="fw-bold mt-1"><?= $client["telephone"] ?></h4>
                <hr class="my-4 opacity-25">
                <p class="text-muted mb-0 small text-uppercase tracking-wide">Solde disponible</p>
                <h1 class="display-4 text-primary fw-bold mb-0"><?= number_format($client["solde"], 0, ",", " ") ?> <small class="fs-5 text-muted">Ar</small></h1>
            </div>
        </div>

        <div class="row mt-4 g-3">
            <div class="col-4">
                <a href="/client/depot" class="btn btn-success btn-action btn-lg w-100 py-4 shadow-sm">
                    <i class="bi bi-plus-circle fs-2 d-block mb-2"></i>
                    <span class="fw-bold">Dépôt</span>
                </a>
            </div>
            <div class="col-4">
                <a href="/client/retrait" class="btn btn-warning btn-action btn-lg w-100 py-4 shadow-sm">
                    <i class="bi bi-dash-circle fs-2 d-block mb-2"></i>
                    <span class="fw-bold">Retrait</span>
                </a>
            </div>
            <div class="col-4">
                <a href="/client/transfert" class="btn btn-info text-white btn-action btn-lg w-100 py-4 shadow-sm">
                    <i class="bi bi-send fs-2 d-block mb-2"></i>
                    <span class="fw-bold">Transfert</span>
                </a>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="/client/historique" class="btn btn-outline-primary rounded-pill px-4"><i class="bi bi-clock-history me-1"></i>Voir l'historique</a>
            <a href="/admin/login" class="btn btn-outline-secondary rounded-pill px-4 ms-2"><i class="bi bi-shield-lock me-1"></i>Administration</a>
        </div>
    </div>
</div>
