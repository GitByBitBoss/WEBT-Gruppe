<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_SESSION['name'])) {
    echo "<br>Saved name: " . htmlspecialchars($_SESSION['name']);
}

echo "<br>Aktuelle Session-ID: " . session_id();
?>
<form method="post">
    <input type="text" name="name" placeholder="Enter your name">
    <input type="submit" value="Save Name">
</form>
        <button onclick="window.location.href='deleteSession_Hijacking.php'">ausloggen</button>
