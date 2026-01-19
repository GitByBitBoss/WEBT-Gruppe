<?php
// Startet die Session
session_start();

// Lösche das Session-Cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Zerstöre die Session
session_destroy();

echo "Session beendet und Daten gelöscht.";

?>
<button onclick="window.location='createSession_Hijacking.php'">Einloggen mit random ID</button>