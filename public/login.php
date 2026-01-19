<?php
declare(strict_types=1);

// Demo-Credentials (für Schule ok). In echt: DB + password_hash/password_verify.
const DEMO_USER = 'Manuel';
const DEMO_PASS = 'test123';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username === DEMO_USER && $password === DEMO_PASS) {
        // Session Fixation Schutz
        session_start();
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'username' => $username,
            'login_time' => time(),
        ];

        header('Location: index_US5.php');
        exit;
    }

    $error = 'Benutzername oder Passwort ist falsch.';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | DriveWell</title>
  <style>
    body{margin:0;font:16px/1.55 system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif;background:#f6f7fb;color:#1f2937}
    .wrap{max-width:520px;margin:60px auto;padding:0 16px}
    .panel{background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 10px 28px rgba(2,6,23,.06);padding:18px}
    h1{margin:0 0 12px 0}
    label{display:block;margin:10px 0 6px;font-weight:700}
    input{width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px}
    input:focus{outline:2px solid #2563eb}
    .btn{margin-top:12px;border:1px solid #e5e7eb;background:#2563eb;color:#fff;border-radius:10px;padding:10px 12px;font-weight:700;cursor:pointer}
    .err{margin-top:10px;padding:10px 12px;border-left:4px solid #dc2626;background:#fef2f2;border-radius:10px}
    .hint{color:#6b7280;font-size:14px;margin-top:10px}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="panel">
      <h1>DriveWell Login</h1>

      <?php if ($error): ?>
        <div class="err" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <label for="username">Benutzername</label>
        <input id="username" name="username" required />

        <label for="password">Passwort</label>
        <input id="password" name="password" type="password" required />

        <button class="btn" type="submit">Einloggen</button>
      </form>

      <div class="hint">
        Demo: <strong><?= htmlspecialchars(DEMO_USER, ENT_QUOTES, 'UTF-8') ?></strong> /
        <strong><?= htmlspecialchars(DEMO_PASS, ENT_QUOTES, 'UTF-8') ?></strong>
      </div>
    </div>
  </div>
</body>
</html>
