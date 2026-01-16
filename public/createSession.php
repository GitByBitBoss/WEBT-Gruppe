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
    session_start();


    if (!isset($_SESSION['userID'])) {
        
        $_SESSION['userID'] = random_int(1, 20);
        echo "Session gestartet :D";
    } else {
        session_regenerate_id(true);    
        var_dump(session_get_cookie_params()) ; 
        echo "deine id ist: " . $_SESSION['userID'];
    }
