<?php
$statusCode = $statusCode ?? 404;
$title = $title ?? 'Page non trouvee';
$message = $message ?? 'La page que vous recherchez n existe pas ou a ete deplacee.';
http_response_code($statusCode);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?= escapeHtml($title) ?> - NexSkin</title>
    <link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { color-scheme: light; --blue: #2563EB; --text: #111827; --muted: #6B7280; --bg: #FFFFFF; --soft: #EFF6FF; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: grid; place-items: center; padding: 24px; font-family: Manrope, Arial, sans-serif; color: var(--text); background: linear-gradient(180deg, var(--soft), var(--bg) 38%); }
        main { width: min(100%, 520px); text-align: center; }
        .logo { width: 44px; height: 44px; margin: 0 auto 28px; display: block; }
        .code { font-size: clamp(64px, 18vw, 112px); line-height: .9; font-weight: 800; color: var(--blue); letter-spacing: 0; margin-bottom: 20px; }
        h1 { font-size: clamp(24px, 4vw, 34px); line-height: 1.15; margin: 0 0 12px; }
        p { margin: 0 auto 32px; color: var(--muted); line-height: 1.65; }
        a { display: inline-flex; align-items: center; justify-content: center; min-height: 46px; padding: 0 22px; border-radius: 999px; background: var(--blue); color: white; text-decoration: none; font-weight: 700; box-shadow: 0 14px 28px rgba(37, 99, 235, .18); }
        a:focus-visible { outline: 3px solid rgba(37, 99, 235, .35); outline-offset: 3px; }
    </style>
</head>
<body>
    <main>
        <img src="<?= asset('images/logo-mark.png') ?>" alt="" class="logo">
        <div class="code"><?= (int) $statusCode ?></div>
        <h1><?= escapeHtml($title) ?></h1>
        <p><?= escapeHtml($message) ?></p>
        <a href="<?= url('/') ?>">Retour a l'accueil</a>
    </main>
</body>
</html>

