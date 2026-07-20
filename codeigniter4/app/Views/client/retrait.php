<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffc107" viewBox="0 0 16 16"><path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1z" transform="rotate(45 8 8)"/></svg>
                    Retrait
                </h3>
                <?php if (session()->getFlashdata("success")): ?><div class="alert alert-success"><?= session()->getFlashdata("success") ?></div><?php endif; ?>
                <?php if (session()->getFlashdata("error")): ?><div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div><?php endif; ?>
                <form method="post" action="/client/retrait">
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant (Ar)</label>
                        <input type="number" class="form-control form-control-lg text-center" id="montant" name="montant" min="100" step="100" placeholder="100" required>
                        <div class="form-text">Des frais de retrait s'appliquent selon le montant.</div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg w-100">Retirer</button>
                    <a href="/client/dashboard" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
