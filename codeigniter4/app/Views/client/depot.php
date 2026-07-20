<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="bg-success bg-gradient text-white d-inline-flex rounded-3 p-3 mb-2">
                        <i class="bi bi-plus-circle fs-2"></i>
                    </div>
                    <h3 class="fw-bold mt-2">Dépôt</h3>
                </div>
                <?php if (session()->getFlashdata("success")): ?><div class="alert alert-success"><?= session()->getFlashdata("success") ?></div><?php endif; ?>
                <?php if (session()->getFlashdata("error")): ?><div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div><?php endif; ?>
                <form method="post" action="/client/depot">
                    <div class="mb-3">
                        <label for="montant" class="form-label fw-semibold">Montant (Ar)</label>
                        <input type="number" class="form-control form-control-lg text-center" id="montant" name="montant" min="100" step="100" placeholder="100" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill"><i class="bi bi-check-lg me-1"></i>Déposer</button>
                    <a href="/client/dashboard" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
