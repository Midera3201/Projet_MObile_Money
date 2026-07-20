<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header bg-white"><h5 class="mb-0">Ajouter un prefixe</h5></div>
    <div class="card-body">
        <form method="POST" action="/admin/prefixes/create" class="row g-3">
            <div class="col-auto">
                <input type="text" name="prefixe" class="form-control" placeholder="Prefixe (ex: 033)" required pattern="[0-9]{3,4}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">Liste des prefixes</h5></div>
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead class="table-light"><tr><th>ID</th><th>Prefixe</th><th>Actif</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($prefixes as $p): ?>
                    <tr>
                        <td><?= $p->id ?></td>
                        <td><strong><?= $p->prefixe ?></strong></td>
                        <td><span class="badge bg-<?= $p->actif ? 'success' : 'secondary' ?>"><?= $p->actif ? 'Oui' : 'Non' ?></span></td>
                        <td>
                            <a href="/admin/prefixes/toggle/<?= $p->id ?>" class="btn btn-sm btn-warning"><?= $p->actif ? 'Desactiver' : 'Activer' ?></a>
                            <a href="/admin/prefixes/delete/<?= $p->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>