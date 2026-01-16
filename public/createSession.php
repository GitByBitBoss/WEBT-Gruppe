<?php
    /*  */
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => false,    //https funktioniert nicht weil wir kein ssl haben 
        'httponly' => true,   
        'samesite' => 'Lax'   // CSRF-Risiko reduzieren (häufig Lax/Strict)
    ]);
    ini_set('session.gc_maxlifetime', 10); 
    ini_set('session.gc_probability', 1);   
    ini_set('session.gc_divisor', 1);
    session_start();


    if (!isset($_SESSION['userID'])) {
        $_SESSION['userID'] = random_int(1, 20);
        echo "Session gestartet :D";
    } else {
        session_regenerate_id(true);    
        echo "deine id ist: " . $_SESSION['userID'];
    }

    // Zeige die aktuelle Session-ID
    echo "<br>Aktuelle Session-ID: " . session_id();

    // Zeige die Cookie-Parameter an
    echo "<br>Session-Cookie-Parameter: ";
    var_dump(session_get_cookie_params());

    // Manuell die Garbage Collection auslösen
?>