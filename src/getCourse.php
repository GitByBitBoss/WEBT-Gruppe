<?php
header('Content-Type: application/json');


require_once "./Seeder.php";
if (!isset($_GET["id"])) {
    return;
}

$courses = Seeder::createDemoData();

$course = $courses[$_GET["id"]];
echo json_encode($course);
