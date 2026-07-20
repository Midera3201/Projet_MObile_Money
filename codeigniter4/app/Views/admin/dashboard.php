$pageTitle = 'Dashboard';
<?= view("admin/templates/header") ?>

<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Clients</div>
                <div class="stat-value"><?= $totalClients ?></div>
            </div>
            <div class="stat-icon" style="background:#eff6ff;color:#2563EB;">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Dépôts</div>
                <div class="stat-value"><?= $totalDepots ?></div>
            </div>
            <div class="stat-icon" style="background:#f0fdf4;color:#16A34A;">
                <i class="bi bi-plus-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Retraits</div>
                <div class="stat-value"><?= $totalRetraits ?></div>
            </div>
            <div class="stat-icon" style="background:#fff7ed;color:#EA580C;">
                <i class="bi bi-dash-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Transferts</div>
                <div class="stat-value"><?= $totalTransferts ?></div>
            </div>
            <div class="stat-icon" style="background:#fefce8;color:#ca8a04;">
                <i class="bi bi-send"></i>
            </div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Résumé</h6>
    </div>
    <div class="card-body-custom">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#f0fdf4;color:#16A34A;width:40px;height:40px;font-size:16px;">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total transactions</div>
                        <div style="font-size:20px;font-weight:700;"><?= $totalTransactions ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#eff6ff;color:#2563EB;width:40px;height:40px;font-size:16px;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="stat-label">Clients enregistrés</div>
                        <div style="font-size:20px;font-weight:700;"><?= $totalClients ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#fefce8;color:#ca8a04;width:40px;height:40px;font-size:16px;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <div class="stat-label">Opérations totales</div>
                        <div style="font-size:20px;font-weight:700;"><?= $totalDepots + $totalRetraits + $totalTransferts ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view("admin/templates/footer") ?>
