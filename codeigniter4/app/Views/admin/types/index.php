<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header bg-white"><h5 class="mb-0">Ajouter un type d'operation</h5></div>
    <div class="card-body">
        <form method="POST" action="/admin/types/create" class="row g-3">
            <div class="col-auto">
                <input type="text" name="code" class="form-control" placeholder="Code (ex: depot)" required>
            </div>
            <div class="col-auto">
                <input type="text" name="libelle" class="form-control" placeholder="Libelle (ex: Depot)" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">Types d'operations</h5></div>
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead class="table-light"><tr><th>ID</th><th>Code</th><th>Libelle</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($types as $t): ?>
                    <tr>
                        <td><?= $t->id ?></td>
                        <td><strong><?= esc($t->code) ?></strong></td>
                        <td><?= esc($t->libelle) ?></td>
                        <td>
                            <a href="/admin/types/delete/<?= $t->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
