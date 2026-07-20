<?= view("admin/templates/header") ?>
<div class="container-fluid">
    <h2 class="mb-4">Types d'opérations</h2>
    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="/admin/types/create" class="row g-2">
                <div class="col-auto">
                    <input type="text" class="form-control" name="code" placeholder="code" required>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" name="libelle" placeholder="Libellé" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr><th>Code</th><th>Libellé</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($types as $t): ?>
                        <tr>
                            <td><?= $t["code"] ?></td>
                            <td><?= $t["libelle"] ?></td>
                            <td>
                                <a href="/admin/types/delete/<?= $t["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view("admin/templates/footer") ?>
