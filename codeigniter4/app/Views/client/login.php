<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Connexion</h3>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form method="post" action="/login">
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="text" class="form-control form-control-lg" id="telephone" name="telephone"
                               placeholder="Ex: 0331234567" required maxlength="10">
                        <div class="form-text">Entrez votre numéro (033 ou 037).</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
