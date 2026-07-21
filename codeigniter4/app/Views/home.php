<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Money - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #F4FCF0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .home-logo { font-size: 28px; font-weight: 700; color: #1E293B; letter-spacing: -0.5px; }
        .home-slogan { font-size: 14px; color: #64748B; margin-top: 4px; }
        .home-desc { font-size: 13px; color: #94A3B8; max-width: 420px; margin: 0 auto; }
        .home-students { font-size: 12px; color: #94A3B8; margin-top: 6px; }
        .card-espace { background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0px 2px 8px rgba(15, 23, 42, 0.05); padding: 32px 24px; text-align: center; text-decoration: none; color: inherit; display: block; transition: all 0.15s; }
        .card-espace:hover { border-color: #bbf7d0; box-shadow: 0px 4px 12px rgba(22, 163, 74, 0.08); color: inherit; text-decoration: none; }
        .card-icon { width: 56px; height: 56px; border-radius: 50%; background: #f0fdf4; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .card-icon i { font-size: 24px; color: #16A34A; }
        .card-title { font-size: 16px; font-weight: 600; color: #1E293B; margin-bottom: 8px; }
        .card-desc { font-size: 13px; color: #64748B; line-height: 1.5; margin-bottom: 20px; }
        .btn-card { background: #fff; border: 1px solid #E2E8F0; color: #16A34A; font-weight: 600; font-size: 13px; border-radius: 8px; padding: 10px 20px; transition: all 0.15s; }
        .btn-card:hover { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 700px; padding: 40px 16px;">
        <div class="text-center mb-5">
            <div class="home-logo">M-Money</div>
            <div class="home-students">ETU004276 et ETU004281</div>
            <div class="home-slogan mt-2">Simulation d'un operateur Mobile Money</div>
            <div class="home-desc mt-3">Une application de simulation permettant de gerer les operations d'un operateur Mobile Money : depots, retraits, transferts et reporting.</div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <a href="/login" class="card-espace">
                    <div class="card-icon"><i class="bi bi-person"></i></div>
                    <div class="card-title">Espace Client</div>
                    <div class="card-desc">Acceder a votre compte Mobile Money pour consulter votre solde, effectuer un depot, un retrait, un transfert et consulter votre historique.</div>
                    <span class="btn-card">Acceder a l'espace client</span>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/admin/login" class="card-espace">
                    <div class="card-icon"><i class="bi bi-shield-lock"></i></div>
                    <div class="card-title">Espace Operateur</div>
                    <div class="card-desc">Acceder a l'interface de gestion de l'operateur Mobile Money.</div>
                    <span class="btn-card">Acceder a l'espace operateur</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
