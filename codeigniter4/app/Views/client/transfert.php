<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0dcaf0" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/></svg>
                    Transfert
                </h3>
                <?php if (session()->getFlashdata("success")): ?><div class="alert alert-success"><?= session()->getFlashdata("success") ?></div><?php endif; ?>
                <?php if (session()->getFlashdata("error")): ?><div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div><?php endif; ?>
                <form method="post" action="/client/transfert">
                    <div class="mb-3">
                        <label for="destinataire" class="form-label">Destinataire</label>
                        <input type="text" class="form-control form-control-lg text-center" id="destinataire" name="destinataire" placeholder="033 00 000 00" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant (FCFA)</label>
                        <input type="number" class="form-control form-control-lg text-center" id="montant" name="montant" min="100" step="100" placeholder="100" required>
                        <div class="form-text">Des frais de transfert s'appliquent selon le montant.</div>
                    </div>
                    <button type="submit" class="btn btn-info text-white btn-lg w-100">Transf?rer</button>
                    <a href="/client/dashboard" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
