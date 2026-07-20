$pageTitle = 'Préfixes';
<?= view("admin/templates/header") ?>

<?php if (session()->getFlashdata("success")): ?>
    <div class="alert-custom success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata("error")): ?>
    <div class="alert-custom error"><i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?></div>
<?php endif; ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6>Ajouter un préfixe</h6>
    </div>
    <div class="card-body-custom">
        <form method="post" action="/admin/prefixes/create" class="form-custom">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Préfixe</label>
                    <input type="text" class="form-control" name="prefixe" placeholder="033" maxlength="3" required>
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
        <h6>Liste des préfixes</h6>
        <span class="badge-custom inactive"><?= count($prefixes) ?> préfixe(s)</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Préfixe</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prefixes as $p): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($p["prefixe"]) ?></strong></td>
                        <td>
                            <?php if ($p["statut"]): ?>
                                <span class="badge-custom active">Actif</span>
                            <?php else: ?>
                                <span class="badge-custom inactive">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-light);"><?= $p["date_creation"] ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="/admin/prefixes/toggle/<?= $p["id"] ?>" class="btn-custom orange">
                                    <i class="bi bi-arrow-left-right"></i> <?= $p["statut"] ? "Désactiver" : "Activer" ?>
                                </a>
                                <a href="/admin/prefixes/delete/<?= $p["id"] ?>" class="btn-custom red" onclick="return confirm('Supprimer ce préfixe ?')">
                                    <i class="bi bi-trash3"></i> Supprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($prefixes)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4" style="color:var(--text-light);">Aucun préfixe enregistré</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view("admin/templates/footer") ?>
