<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Situation des gains</h2>

    <p class="text-muted mb-4">
        Resume des gains generes par les frais de transaction, separes entre operateurs internes et externes.
    </p>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Gains internes</h5>
                    <p class="card-text small">Frais sur les transactions internes</p>
                    <h2 class="display-6"><?= format_argent($gainsInternes) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Gains externes</h5>
                    <p class="card-text small">Frais + commissions sur les transferts sortants</p>
                    <h2 class="display-6"><?= format_argent($gainsExternes) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total gains</h5>
                    <p class="card-text small">Gains combines</p>
                    <h2 class="display-6"><?= format_argent($totalGains) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h5>Detail</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Frais internals (retraits + transferts internes + depots)</td>
                        <td class="text-end fw-bold"><?= format_argent($gainsInternes) ?></td>
                    </tr>
                    <tr>
                        <td>Frais externes (transferts vers autres operateurs)</td>
                        <td class="text-end fw-bold"><?= format_argent($gainsExternes) ?></td>
                    </tr>
                    <tr class="table-primary">
                        <td><strong>Total</strong></td>
                        <td class="text-end"><strong><?= format_argent($totalGains) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
