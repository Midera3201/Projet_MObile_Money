<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header bg-white"><h5 class="mb-0">Ajouter un bareme</h5></div>
    <div class="card-body">
        <form method="POST" action="/admin/baremes/create" class="row g-3">
            <div class="col-auto">
                <select name="type_operation_id" class="form-select" required>
                    <option value="">Type</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t->id ?>"><?= $t->nom ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <input type="number" name="montant_min" class="form-control" placeholder="Min (Ar)" required>
            </div>
            <div class="col-auto">
                <input type="number" name="montant_max" class="form-control" placeholder="Max (Ar)" required>
            </div>
            <div class="col-auto">
                <input type="number" name="frais_fixe" class="form-control" placeholder="Frais (Ar)" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">Liste des baremes</h5></div>
    <div class="card-body">
        <table class="table table-bordered table-striped mb-0">
            <thead class="table-light"><tr><th>ID</th><th>Type</th><th>Min</th><th>Max</th><th>Frais</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($baremes as $b): ?>
                    <tr>
                        <td><?= $b->id ?></td>
                        <td><?= $b->type_nom ?></td>
                        <td><?= format_argent($b->montant_min) ?></td>
                        <td><?= format_argent($b->montant_max) ?></td>
                        <td class="text-danger fw-bold"><?= format_argent($b->frais_fixe) ?></td>
                        <td>
                            <a href="/admin/baremes/delete/<?= $b->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>