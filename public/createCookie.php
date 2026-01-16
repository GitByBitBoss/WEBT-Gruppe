<?php
    setcookie('username', "Manuel", time() + 10);
    echo "username";

?>

<button onclick="window.location.href='getCookies.php'"> Cookies anschauen</button>