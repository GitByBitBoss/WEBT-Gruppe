<?php
    session_start();


    if(isset($_SESSION['userID'])) {
        echo "deine id ist: " . $_SESSION['userID'];
    }

    else {
        echo "Session gestartet :D";
        $_SESSION['userID'] = random_int(1,20);
    }

