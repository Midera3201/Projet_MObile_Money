<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div class="stat-card mb-4 text-center">
    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:0.3px;font-weight:500;">Solde disponible</div>
    <div style="font-size:32px;font-weight:700;color:var(--primary);margin-top:4px;">
        <?= number_format($client["solde"], 0, ",", " ") ?> <span style="font-size:16px;color:var(--text-light);font-weight:500;">Ar</span>
    </div>
    <div style="font-size:13px;color:var(--text-light);margin-top:4px;"><?= htmlspecialchars($client["telephone"]) ?></div>
</div>

<div class="stat-card mb-4 text-center" style="background:#fffbeb;border-color:#fde68a;">
    <div style="display:flex;align-items:center;justify-content:center;gap:8px;flex-wrap:wrap;">
        <div>
            <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:0.3px;font-weight:500;">Épargne</div>
            <div style="font-size:24px;font-weight:700;color:#F59E0B;">
                <?= number_format($client["solde_epargne"] ?? 0, 0, ",", " ") ?> <span style="font-size:14px;color:var(--text-light);font-weight:500;">Ar</span>
            </div>
        </div>
        <div style="width:1px;height:40px;background:var(--border);"></div>
        <a href="/client/epargne" class="btn-custom" style="color:#F59E0B;border-color:#fde68a;font-size:12px;height:32px;"><i class="bi bi-piggy-bank"></i> Gérer</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="/client/depot" class="card-custom d-block text-decoration-none" style="cursor:pointer;">
            <div class="card-body-custom text-center py-4">
                <div style="width:40px;height:40px;border-radius:10px;background:#f0fdf4;color:#16A34A;display:inline-flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:8px;">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div style="font-weight:600;font-size:14px;color:var(--text);">Dépôt</div>
                <div style="font-size:12px;color:var(--text-light);">Ajouter de l'argent</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="/client/retrait" class="card-custom d-block text-decoration-none" style="cursor:pointer;">
            <div class="card-body-custom text-center py-4">
                <div style="width:40px;height:40px;border-radius:10px;background:#fff7ed;color:#EA580C;display:inline-flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:8px;">
                    <i class="bi bi-dash-circle"></i>
                </div>
                <div style="font-weight:600;font-size:14px;color:var(--text);">Retrait</div>
                <div style="font-size:12px;color:var(--text-light);">Retirer de l'argent</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="/client/transfert" class="card-custom d-block text-decoration-none" style="cursor:pointer;">
            <div class="card-body-custom text-center py-4">
                <div style="width:40px;height:40px;border-radius:10px;background:#eff6ff;color:#2563EB;display:inline-flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:8px;">
                    <i class="bi bi-send"></i>
                </div>
                <div style="font-weight:600;font-size:14px;color:var(--text);">Transfert</div>
                <div style="font-size:12px;color:var(--text-light);">Envoyer de l'argent</div>
            </div>
        </a>
    </div>
</div>
