$pageTitle = 'Types d\'opérations';
<?= view("admin/templates/header") ?>

<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6>Ajouter un type d'opération</h6>
    </div>
    <div class="card-body-custom">
        <form method="post" action="/admin/types/create" class="form-custom">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Code</label>
                    <input type="text" class="form-control" name="code" placeholder="depot" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Libellé</label>
                    <input type="text" class="form-control" name="libelle" placeholder="Dépôt" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn-custom green"><i class="bi bi-plus-lg"></i> Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Liste des types</h6>
        <span class="badge-custom inactive"><?= count($types) ?> type(s)</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th style="width:150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($types as $t): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($t["code"]) ?></strong></td>
                        <td><?= htmlspecialchars($t["libelle"]) ?></td>
                        <td>
                            <a href="/admin/types/delete/<?= $t["id"] ?>" class="btn-custom red" onclick="return confirm('Supprimer ce type ?')">
                                <i class="bi bi-trash3"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($types)): ?>
                    <tr>
                        <td colspan="3" class="text-center py-4" style="color:var(--text-light);">Aucun type enregistré</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view("admin/templates/footer") ?>
