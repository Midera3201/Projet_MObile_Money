<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white text-center p-3">
            <h5>Clients inscrits</h5>
            <h2><?= $totalClients ?></h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-success text-white text-center p-3">
            <h5>Gains totaux (frais)</h5>
            <h2><?= format_argent($totalGains) ?></h2>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">Navigation rapide</h5></div>
    <div class="card-body">
        <a href="/admin/prefixes" class="btn btn-outline-primary me-2">Prefixes</a>
        <a href="/admin/types" class="btn btn-outline-primary me-2">Types operations</a>
        <a href="/admin/baremes" class="btn btn-outline-primary me-2">Baremes</a>
        <a href="/admin/operateurs" class="btn btn-outline-primary">Operateurs externes</a>
    </div>
</div>

<?= $this->endSection() ?>
