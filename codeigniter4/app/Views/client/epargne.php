<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div class="stat-card mb-4 text-center">
    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:0.3px;font-weight:500;">Solde épargne</div>
    <div style="font-size:32px;font-weight:700;color:#F59E0B;margin-top:4px;">
        <?= number_format($currentUser["solde_epargne"] ?? 0, 0, ",", " ") ?> <span style="font-size:16px;color:var(--text-light);font-weight:500;">Ar</span>
    </div>
    <div style="font-size:13px;color:var(--text-light);margin-top:4px;">
        <i class="bi bi-piggy-bank me-1"></i> Taux d'intérêt: <strong><?= $params->taux_interet ?? 5 ?>%</strong> &middot; Blocage: <strong><?= $params->duree_blocage_jours ?? 30 ?> jours</strong>
    </div>
</div>

<div class="row g-3" style="max-width:440px;margin:0 auto;">
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6 style="margin:0;font-weight:600;"><i class="bi bi-plus-circle me-2" style="color:#F59E0B;"></i>Verser</h6>
            </div>
            <div class="card-body-custom">
                <form method="post" action="/client/epargne/depot" class="form-custom">
                    <div class="mb-3">
                        <label class="form-label">Montant (Ar)</label>
                        <input type="number" class="form-control text-center" name="montant" min="100" step="100" placeholder="5000" required style="font-size:18px;font-weight:600;">
                        <div style="font-size:12px;color:var(--text-light);margin-top:4px;">Solde disponible: <?= number_format($currentUser["solde"], 0, ",", " ") ?> Ar</div>
                    </div>
                    <button type="submit" class="btn-custom full" style="color:#F59E0B;border-color:#fde68a;"><i class="bi bi-piggy-bank"></i> Verser</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6 style="margin:0;font-weight:600;"><i class="bi bi-arrow-down-circle me-2" style="color:#F59E0B;"></i>Retirer</h6>
            </div>
            <div class="card-body-custom">
                <form method="post" action="/client/epargne/retrait" class="form-custom">
                    <div class="mb-3">
                        <label class="form-label">Montant (Ar)</label>
                        <input type="number" class="form-control text-center" name="montant" min="100" step="100" placeholder="5000" required style="font-size:18px;font-weight:600;">
                        <div style="font-size:12px;color:var(--text-light);margin-top:4px;">Solde épargne: <?= number_format($currentUser["solde_epargne"] ?? 0, 0, ",", " ") ?> Ar</div>
                    </div>
                    <button type="submit" class="btn-custom full" style="color:#F59E0B;border-color:#fde68a;"><i class="bi bi-wallet2"></i> Retirer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<p class="text-center mt-3" style="font-size:12px;color:var(--text-light);">
    <i class="bi bi-info-circle me-1"></i> Les versements sont bloqués pendant <?= $params->duree_blocage_jours ?? 30 ?> jours avec un taux de <?= $params->taux_interet ?? 5 ?>% par an.
</p>
