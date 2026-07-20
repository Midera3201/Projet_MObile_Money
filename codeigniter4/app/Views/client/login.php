<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-body p-5 text-center">
                <div class="mb-3">
                    <div class="bg-primary bg-gradient text-white d-inline-flex rounded-3 p-3 mb-2">
                        <i class="bi bi-phone fs-1"></i>
                    </div>
                </div>
                <h3 class="fw-bold">MobileMoney</h3>
                <p class="text-muted mb-4">Connectez-vous avec votre numéro</p>

                <?php if (session()->getFlashdata("error")): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata("error") ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata("success")): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
                <?php endif; ?>

                <form method="post" action="/login">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg text-center" id="telephone" name="telephone"
                               placeholder="033 00 000 00" required maxlength="10" style="font-size: 1.3rem;">
                        <div class="form-text">Numéro à 10 chiffres (033 ou 037)</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill"><i class="bi bi-arrow-right-circle me-1"></i>Se connecter</button>
                </form>
                <hr class="my-4 opacity-25">
                <a href="/admin/login" class="btn btn-outline-secondary w-100 rounded-pill"><i class="bi bi-shield-lock me-1"></i>Espace Administration</a>
            </div>
        </div>
    </div>
</div>
