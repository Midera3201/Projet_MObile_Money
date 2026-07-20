<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div style="max-width:440px;margin:0 auto;">
    <div class="card-custom">
        <div class="card-header-custom">
            <h6 style="margin:0;font-weight:600;"><i class="bi bi-dash-circle me-2" style="color:var(--orange);"></i>Retrait</h6>
        </div>
        <div class="card-body-custom">
            <form method="post" action="/client/retrait" class="form-custom">
                <div class="mb-4">
                    <label class="form-label">Montant (Ar)</label>
                    <input type="number" class="form-control text-center" name="montant" min="100" step="100" placeholder="10000" required style="font-size:18px;font-weight:600;">
                    <div style="font-size:12px;color:var(--text-light);margin-top:4px;">Des frais de retrait s'appliquent selon le montant.</div>
                </div>
                <button type="submit" class="btn-custom full" style="color:var(--orange);border-color:#fed7aa;"><i class="bi bi-check-lg"></i> Retirer</button>
                <a href="/client/dashboard" class="btn-custom full mt-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
