$pageTitle = 'Situation des gains';
<?= view("admin/templates/header") ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <div class="stat-label">Gains internes</div>
                <div class="stat-value" style="color:var(--primary);"><?= format_argent($gainsInternes) ?></div>
            </div>
            <div class="stat-icon" style="background:#f0fdf4;color:#16A34A;">
                <i class="bi bi-building"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <div class="stat-label">Gains externes</div>
                <div class="stat-value" style="color:var(--orange);"><?= format_argent($gainsExternes) ?></div>
            </div>
            <div class="stat-icon" style="background:#fff7ed;color:#EA580C;">
                <i class="bi bi-broadcast"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <div class="stat-label">Total gains</div>
                <div class="stat-value" style="color:var(--blue);"><?= format_argent($totalGains) ?></div>
            </div>
            <div class="stat-icon" style="background:#eff6ff;color:#2563EB;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Détail des gains</h6>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th style="text-align:right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Frais internes (retraits, transferts, dépôts)</td>
                    <td style="text-align:right;font-weight:600;"><?= format_argent($gainsInternes) ?></td>
                </tr>
                <tr>
                    <td>Frais externes (transferts vers autres opérateurs)</td>
                    <td style="text-align:right;font-weight:600;"><?= format_argent($gainsExternes) ?></td>
                </tr>
                <tr style="background:var(--bg);">
                    <td style="font-weight:700;">Total</td>
                    <td style="text-align:right;font-weight:700;color:var(--primary);"><?= format_argent($totalGains) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?= view("admin/templates/footer") ?>
