<div class="row justify-content-center min-vh-75 align-items-center" style="min-height: 60vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#0d6efd" viewBox="0 0 16 16"><path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/><path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                </div>
                <h3 class="mb-1">MobileMoney</h3>
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
                        <div class="form-text">Entrez votre numéro (033 ou 037) - 10 chiffres</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
