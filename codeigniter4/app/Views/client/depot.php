<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Dépôt</h3>

                <form method="post" action="/client/depot">
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant à déposer (FCFA)</label>
                        <input type="number" class="form-control form-control-lg" id="montant" name="montant"
                               min="100" step="100" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Déposer</button>
                    <a href="/client/dashboard" class="btn btn-outline-secondary btn-lg w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
