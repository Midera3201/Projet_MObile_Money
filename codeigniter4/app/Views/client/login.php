<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #F4FCF0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0px 2px 8px rgba(15, 23, 42, 0.05); width: 100%; max-width: 400px; }
        .login-logo { font-size: 20px; font-weight: 700; color: #1E293B; letter-spacing: -0.5px; }
        .login-sub { font-size: 13px; color: #64748B; }
        .form-control { border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; padding: 10px 14px; }
        .form-control:focus { border-color: #16A34A; box-shadow: 0 0 0 3px rgba(22,163,74,0.08); }
        .btn-login { background: #fff; border: 1px solid #E2E8F0; color: #16A34A; font-weight: 600; font-size: 14px; border-radius: 8px; height: 42px; transition: all 0.15s; }
        .btn-login:hover { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .btn-link-alt { background: #fff; border: 1px solid #E2E8F0; color: #64748B; font-weight: 500; font-size: 13px; border-radius: 8px; height: 42px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.15s; }
        .btn-link-alt:hover { background: #F4FCF0; color: #1E293B; }
    </style>
</head>
<body>
    <div class="login-card p-5">
        <div class="text-center mb-4">
            <div class="login-logo">M-Money</div>
            <div class="login-sub mt-1">Connectez-vous avec votre numéro</div>
        </div>

        <?php if (session()->getFlashdata("error")): ?>
            <div style="padding:10px 14px;border-radius:8px;font-size:13px;font-weight:500;background:#fef2f2;color:#DC2626;border:1px solid #fecaca;margin-bottom:16px;">
                <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata("error") ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata("success")): ?>
            <div style="padding:10px 14px;border-radius:8px;font-size:13px;font-weight:500;background:#f0fdf4;color:#16A34A;border:1px solid #bbf7d0;margin-bottom:16px;">
                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata("success") ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/login">
            <div class="mb-4">
                <label class="form-label" style="font-size:13px;font-weight:500;">Numéro de téléphone</label>
                <input type="text" class="form-control" name="telephone" placeholder="033 00 000 00" required maxlength="10">
                <div style="font-size:12px;color:#64748B;margin-top:4px;">Numéro à 10 chiffres (033 ou 037)</div>
            </div>
            <button type="submit" class="btn-login w-100 mb-3">Se connecter</button>
        </form>
        <a href="/admin/login" class="btn-link-alt w-100"><i class="bi bi-shield-lock"></i> Espace Administration</a>
    </div>
</body>
</html>
