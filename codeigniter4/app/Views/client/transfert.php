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
                        <label for="destinataires" class="form-label">Destinataire(s)</label>
                        <textarea class="form-control form-control-lg text-center" id="destinataires" name="destinataires" rows="3" placeholder="033 00 000 00&#10;037 00 000 00" required></textarea>
                        <div class="form-text">Un numéro par ligne. L'envoi se fera à chaque destinataire.</div>
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant par destinataire (Ar)</label>
                        <input type="number" class="form-control form-control-lg text-center" id="montant" name="montant" min="100" step="100" placeholder="100" required>
                        <div class="form-text">Des frais de transfert s'appliquent selon le montant.</div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="inclure_frais" name="inclure_frais" value="1">
                        <label class="form-check-label" for="inclure_frais">Inclure les frais de retrait du destinataire</label>
                    </div>
                    <button type="submit" class="btn btn-info text-white btn-lg w-100">Transférer</button>
                    <a href="/client/dashboard" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
