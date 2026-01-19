<?php
declare(strict_types=1);
session_start();

// Session-Daten löschen
$_SESSION = [];

// Session-Cookie löschen (falls gesetzt)
/* if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'],
        $params['domain'],
        (bool)$params['secure'],
        (bool)$params['httponly']
    );
} */
setcookie(session_name(),'',0,'/');

// Session zerstören
//session_unset();
session_destroy();


// Zur Login-Seite
header('Location: login.php');
die;