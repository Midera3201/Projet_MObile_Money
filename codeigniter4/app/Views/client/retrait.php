<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Retrait</h3>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <form method="post" action="/client/retrait">
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant à retirer (FCFA)</label>
                        <input type="number" class="form-control form-control-lg" id="montant" name="montant"
                               min="100" step="100" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg w-100">Retirer</button>
                    <a href="/client/dashboard" class="btn btn-outline-secondary btn-lg w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
