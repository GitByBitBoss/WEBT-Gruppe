<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>TheoriefragDriveWell</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<h1>Theoriefragen</h1>

<?php

require_once "./Question.php";
require_once "./Course.php";
require_once "./Seeder.php";

$courses = Seeder::createDemoData();

foreach ($courses as $course) {
    echo print_r($course). "<br>";
}

?>

</body>
</html>

