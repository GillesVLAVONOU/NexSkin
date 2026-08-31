<?php

/**
 * NexSkin - Setup Wizard
 * Web-based installation interface.
 */

define('ROOT_PATH', __DIR__);

$lockFile = ROOT_PATH . '/.installed';
$envFile = ROOT_PATH . '/.env';
if (file_exists($lockFile) && file_exists($envFile)) {
    http_response_code(403);
    exit('NexSkin est déjà installé. Supprimez le fichier .installed pour réinstaller.');
}

$step = (int) ($_GET['step'] ?? 1);
$action = $_POST['action'] ?? '';
$error = '';
$success = '';

function redirect(int $newStep): void {
    header('Location: install.php?step=' . $newStep);
    exit;
}

function generateKey(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}

function dbConnectWithDb(string $host, int $port, string $db, string $user, string $pass): PDO {
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function e(string $val): string {
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

function envLine(string $key, string $value): string {
    $value = str_replace(["\r", "\n"], '', $value);
    return $key . '=' . $value;
}

// ─── START SESSION ─────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ─── POST HANDLING ─────────────────────────────────────────────
if ($action === 'test_db') {
    $host = trim($_POST['db_host'] ?? '127.0.0.1');
    $port = (int) ($_POST['db_port'] ?? 3306);
    $user = trim($_POST['db_user'] ?? '');
    $pass = $_POST['db_pass'] ?? '';
    $dbName = trim($_POST['db_name'] ?? 'nexskin');

    try {
        $dbName = preg_replace('/[^a-zA-Z0-9_]/', '', $dbName);
        $pdo = dbConnectWithDb($host, $port, $dbName, $user, $pass);

        $schemaFile = ROOT_PATH . '/database/schema.sql';
        if (file_exists($schemaFile)) {
            $schema = file_get_contents($schemaFile);
            $schema = preg_replace('/CREATE DATABASE.*?;/is', '', $schema);
            $schema = preg_replace('/USE\s+`?nexskin`?\s*;/i', '', $schema);
            $pdo->exec($schema);
        }

        $dirs = [
            '/public/uploads/projects',
            '/public/uploads/categories',
            '/public/uploads/references',
            '/storage/logs',
        ];
        foreach ($dirs as $dir) {
            $path = ROOT_PATH . $dir;
            if (!is_dir($path)) mkdir($path, 0755, true);
        }

        $uploadsHtaccess = ROOT_PATH . '/public/uploads/.htaccess';
        if (!file_exists($uploadsHtaccess)) {
            file_put_contents($uploadsHtaccess, "Options -Indexes\n\n<FilesMatch \"\\.(php|php[0-9]?|phtml|phar|cgi|pl|py|jsp|asp|aspx|sh|bat|cmd|exe)$\">\n    Require all denied\n</FilesMatch>\n");
        }

        $_SESSION['setup_db'] = [
            'host' => $host, 'port' => $port, 'user' => $user,
            'pass' => $pass, 'name' => $dbName,
        ];
        redirect(2);
    } catch (PDOException $e) {
        $error = 'Connexion échouée : ' . $e->getMessage();
        $step = 1;
    }
}

if ($action === 'create_admin') {
    $db = $_SESSION['setup_db'] ?? null;
    if (!$db) redirect(1);

    $name = trim($_POST['admin_name'] ?? '');
    $email = trim($_POST['admin_email'] ?? '');
    $password = $_POST['admin_password'] ?? '';
    $passwordConfirm = $_POST['admin_password_confirm'] ?? '';

    if (strlen($name) < 2) { $error = 'Le nom doit contenir au moins 2 caractères.'; $step = 2; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $error = 'Adresse email invalide.'; $step = 2; }
    elseif (strlen($password) < 8) { $error = 'Le mot de passe doit contenir au moins 8 caractères.'; $step = 2; }
    elseif ($password !== $passwordConfirm) { $error = 'Les mots de passe ne correspondent pas.'; $step = 2; }
    else {
        try {
            $pdo = dbConnectWithDb($db['host'], $db['port'], $db['name'], $db['user'], $db['pass']);
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
            $stmt->execute([$email]);
            if ((int) $stmt->fetchColumn() === 0) {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
                $stmt->execute([$name, $email, $hash]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET name = ?, password = ?, role = 'admin', updated_at = NOW() WHERE email = ?");
                $stmt->execute([$name, $hash, $email]);
            }
            $_SESSION['setup_admin'] = ['name' => $name, 'email' => $email];
            redirect(3);
        } catch (PDOException $e) {
            $error = 'Erreur : ' . $e->getMessage();
            $step = 2;
        }
    }
}

if ($action === 'save_config') {
    $db = $_SESSION['setup_db'] ?? null;
    $admin = $_SESSION['setup_admin'] ?? null;
    if (!$db || !$admin) redirect(1);

    $appName = trim($_POST['app_name'] ?? 'NexSkin');
    $appUrl = rtrim(trim($_POST['app_url'] ?? 'http://localhost/nexskin'), '/');
    $timezone = trim($_POST['timezone'] ?? 'Africa/Lagos');

    $key = generateKey();

    $envLines = [
        envLine('APP_NAME', $appName),
        'APP_ENV=production',
        envLine('APP_URL', $appUrl),
        envLine('APP_KEY', $key),
        envLine('APP_TIMEZONE', $timezone),
        '',
        envLine('DB_HOST', $db['host']),
        envLine('DB_PORT', (string) $db['port']),
        envLine('DB_DATABASE', $db['name']),
        envLine('DB_USERNAME', $db['user']),
        envLine('DB_PASSWORD', $db['pass']),
        '',
        'UPLOAD_MAX_SIZE=5242880',
        'UPLOAD_ALLOWED_TYPES=jpg,jpeg,png,webp',
        '',
        envLine('MAIL_FROM_EMAIL', $admin['email']),
        envLine('MAIL_FROM_NAME', $appName),
        envLine('CONTACT_NOTIFICATION_EMAIL', $admin['email']),
    ];

    $envContent = implode(PHP_EOL, $envLines) . PHP_EOL;
    if (file_put_contents($envFile, $envContent, LOCK_EX) === false) {
        $error = "Impossible de créer le fichier .env. Vérifiez les permissions du dossier racine.";
        $step = 3;
    } elseif (file_put_contents($lockFile, date('Y-m-d H:i:s'), LOCK_EX) === false) {
        $error = "Le fichier .env a été créé, mais le verrou d'installation .installed n'a pas pu être écrit.";
        $step = 3;
    } else {
        session_destroy();
        redirect(4);
    }
}

// ─── RENDER ────────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>NexSkin — Installation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f8fafc; color: #111827; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .container { width: 100%; max-width: 540px; }
        .card { background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,.05); padding: 2.5rem; }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo span { font-size: 1.75rem; font-weight: 700; color: #111827; }
        .logo span b { color: #2563EB; }
        h2 { font-size: 1.25rem; font-weight: 700; margin-bottom: .25rem; }
        .subtitle { color: #6b7280; font-size: .875rem; margin-bottom: 1.5rem; }

        .steps { display: flex; gap: .5rem; margin-bottom: 2rem; }
        .step { flex: 1; height: 4px; border-radius: 2px; background: #e5e7eb; }
        .step.active { background: #2563EB; }
        .step.done { background: #22c55e; }

        .field { margin-bottom: 1.25rem; }
        .field label { display: block; font-size: .8125rem; font-weight: 600; color: #374151; margin-bottom: .375rem; }
        .field input, .field select { width: 100%; padding: .625rem .875rem; border: 1px solid #e5e7eb; border-radius: .5rem; font-size: .875rem; color: #111827; transition: border-color .15s, box-shadow .15s; outline: none; }
        .field input:focus, .field select:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .field input::placeholder { color: #9ca3af; }
        .field .hint { font-size: .75rem; color: #9ca3af; margin-top: .25rem; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        .btn { width: 100%; padding: .75rem 1.5rem; border: none; border-radius: .5rem; font-size: .9375rem; font-weight: 600; cursor: pointer; transition: all .15s; }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-success { background: #22c55e; color: #fff; }
        .btn-success:hover { background: #16a34a; }

        .alert { padding: .75rem 1rem; border-radius: .5rem; font-size: .8125rem; margin-bottom: 1.25rem; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

        .success-box { text-align: center; }
        .success-box .icon { font-size: 3rem; margin-bottom: 1rem; }
        .success-box h2 { font-size: 1.5rem; margin-bottom: .5rem; }
        .success-box p { color: #6b7280; font-size: .875rem; margin-bottom: 1.5rem; line-height: 1.6; }
        .success-box code { display: block; background: #f1f5f9; padding: .75rem 1rem; border-radius: .5rem; font-size: .8125rem; margin: 1rem 0; text-align: left; word-break: break-all; }
        .success-box .links { display: flex; gap: .75rem; justify-content: center; margin-top: 1.5rem; }
        .success-box .links a { display: inline-flex; align-items: center; gap: .375rem; padding: .625rem 1.25rem; border-radius: .5rem; font-size: .875rem; font-weight: 600; text-decoration: none; transition: all .15s; }
        .links .link-primary { background: #2563EB; color: #fff; }
        .links .link-primary:hover { background: #1d4ed8; }
        .links .link-secondary { background: #f1f5f9; color: #374151; border: 1px solid #e5e7eb; }
        .links .link-secondary:hover { background: #e2e8f0; }

        .footer-note { text-align: center; margin-top: 1.5rem; font-size: .75rem; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo"><span>Nex<b>Skin</b></span></div>
        <div class="card">
            <div class="steps">
                <div class="step <?= $step >= 1 ? ($step > 1 ? 'done' : 'active') : '' ?>"></div>
                <div class="step <?= $step >= 2 ? ($step > 2 ? 'done' : 'active') : '' ?>"></div>
                <div class="step <?= $step >= 3 ? ($step > 3 ? 'done' : 'active') : '' ?>"></div>
                <div class="step <?= $step >= 4 ? 'done' : '' ?>"></div>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>

            <?php if ($step === 1): ?>
            <h2>Configuration de la base de données</h2>
            <p class="subtitle">Connectez-vous à MySQL pour créer la base de données.</p>
            <form method="POST" action="install.php?step=1">
                <input type="hidden" name="action" value="test_db">
                <div class="row">
                    <div class="field">
                        <label>Hôte</label>
                        <input type="text" name="db_host" value="127.0.0.1" required>
                    </div>
                    <div class="field">
                        <label>Port</label>
                        <input type="number" name="db_port" value="3306" required>
                    </div>
                </div>
                <div class="field">
                    <label>Nom de la base</label>
                    <input type="text" name="db_name" value="<?= e($_POST['db_name'] ?? 'nexskin') ?>" required>
                    <p class="hint">Sur InfinityFree, créez d'abord la base dans le panel puis saisissez son nom complet ici.</p>
                </div>
                <div class="field">
                    <label>Utilisateur</label>
                    <input type="text" name="db_user" value="<?= e($_POST['db_user'] ?? 'root') ?>" required>
                </div>
                <div class="field">
                    <label>Mot de passe</label>
                    <input type="password" name="db_pass" value="" placeholder="Laisser vide si aucun">
                </div>
                <button type="submit" class="btn btn-primary">Tester et installer</button>
            </form>

            <?php elseif ($step === 2): ?>
            <h2>Compte administrateur</h2>
            <p class="subtitle">Créez votre premier compte administrateur.</p>
            <form method="POST" action="install.php?step=2">
                <input type="hidden" name="action" value="create_admin">
                <div class="field">
                    <label>Nom complet</label>
                    <input type="text" name="admin_name" value="Admin" required minlength="2">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="admin_email" value="admin@nexskin.com" required>
                </div>
                <div class="field">
                    <label>Mot de passe</label>
                    <input type="password" name="admin_password" required minlength="8" placeholder="Minimum 8 caractères">
                </div>
                <div class="field">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="admin_password_confirm" required>
                </div>
                <button type="submit" class="btn btn-primary">Continuer</button>
            </form>

            <?php elseif ($step === 3): ?>
            <h2>Configuration du site</h2>
            <p class="subtitle">Paramètres généraux et messagerie.</p>
            <form method="POST" action="install.php?step=3">
                <input type="hidden" name="action" value="save_config">
                <div class="field">
                    <label>Nom du site</label>
                    <input type="text" name="app_name" value="NexSkin" required>
                </div>
                <div class="field">
                    <label>URL du site</label>
                    <input type="url" name="app_url" value="http://localhost/nexskin" required>
                    <p class="hint">URL complète avec le protocole (http:// ou https://)</p>
                </div>
                <div class="field">
                    <label>Timezone</label>
                    <select name="timezone">
                        <option value="Africa/Lagos">Africa/Lagos (WAT)</option>
                        <option value="Africa/Dakar">Africa/Dakar (GMT)</option>
                        <option value="Africa/Abidjan">Africa/Abidjan (GMT)</option>
                        <option value="Africa/Casablanca">Africa/Casablanca (WET)</option>
                        <option value="Europe/Paris">Europe/Paris (CET)</option>
                        <option value="Europe/London">Europe/London (GMT)</option>
                        <option value="America/New_York">America/New_York (EST)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Finaliser l'installation</button>
            </form>

            <?php elseif ($step === 4): ?>
            <div class="success-box">
                <div class="icon">✅</div>
                <h2>Installation terminée</h2>
                <p>NexSkin est prêt. Vous pouvez accéder à l'administration et commencer à personnaliser votre site.</p>
                <div class="alert alert-success">
                    ⚠️ Supprimez ou renommez le fichier <strong>install.php</strong> pour sécuriser votre site.
                </div>
                <div class="links">
                    <a href="admin/login" class="link-primary">Connexion admin</a>
                    <a href="public/" class="link-secondary">Voir le site</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <p class="footer-note">NexSkin Setup Wizard</p>
    </div>
</body>
</html>
