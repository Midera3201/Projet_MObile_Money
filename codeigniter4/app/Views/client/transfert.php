<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div style="max-width:440px;margin:0 auto;">
    <div class="card-custom">
        <div class="card-header-custom">
            <h6 style="margin:0;font-weight:600;"><i class="bi bi-send me-2" style="color:var(--blue);"></i>Transfert</h6>
        </div>
        <div class="card-body-custom">
            <form method="post" action="/client/transfert" class="form-custom">
                <div class="mb-3">
                    <label class="form-label">Destinataire(s)</label>
                    <textarea class="form-control" name="destinataires" rows="3" placeholder="033 00 000 00&#10;037 00 000 00" required></textarea>
                    <div style="font-size:12px;color:var(--text-light);margin-top:4px;">Un numéro par ligne.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Montant total à répartir (Ar)</label>
                    <input type="number" class="form-control text-center" name="montant" min="100" step="100" placeholder="10000" required style="font-size:18px;font-weight:600;">
                    <div style="font-size:12px;color:var(--text-light);margin-top:4px;">Le montant sera réparti entre les destinataires.</div>
                </div>
                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" id="inclure_frais" name="inclure_frais" value="1">
                    <label class="form-check-label" for="inclure_frais" style="font-size:13px;">Inclure les frais de retrait du destinataire</label>
                </div>
                <button type="submit" class="btn-custom full" style="color:var(--blue);border-color:#bfdbfe;"><i class="bi bi-send"></i> Transférer</button>
                <a href="/client/dashboard" class="btn-custom full mt-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
