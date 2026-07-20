<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header bg-white"><h5 class="mb-0">Ajouter un operateur</h5></div>
    <div class="card-body">
        <form method="POST" action="/admin/operateurs/create" class="row g-3">
            <div class="col-auto">
                <input type="text" name="nom" class="form-control" placeholder="Nom (ex: Orange)" required>
            </div>
            <div class="col-auto">
                <input type="text" name="prefixe" class="form-control" placeholder="Prefixe (ex: 032)" required pattern="[0-9]{3,4}">
            </div>
            <div class="col-auto">
                <input type="number" step="0.1" name="commission_pct" class="form-control" placeholder="Commission %" value="0">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">Operateurs externes enregistres</h5></div>
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr><th>ID</th><th>Nom</th><th>Prefixe</th><th>Commission</th><th>Actif</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php if (empty($operateurs)): ?>
                    <tr><td colspan="6" class="text-center text-muted">Aucun operateur</td></tr>
                <?php else: ?>
                    <?php foreach ($operateurs as $op): ?>
                        <tr>
                            <td><?= $op->id ?></td>
                            <td><strong><?= esc($op->nom) ?></strong></td>
                            <td><?= esc($op->prefixe) ?></td>
                            <td><?= $op->commission_pct ?>%</td>
                            <td><span class="badge bg-<?= $op->actif ? 'success' : 'secondary' ?>"><?= $op->actif ? 'Oui' : 'Non' ?></span></td>
                            <td>
                                <a href="/admin/operateurs/toggle/<?= $op->id ?>" class="btn btn-sm btn-warning"><?= $op->actif ? 'Desactiver' : 'Activer' ?></a>
                                <a href="/admin/operateurs/delete/<?= $op->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
