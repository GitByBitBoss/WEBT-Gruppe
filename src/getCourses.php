<?php
header('Content-Type: application/json');


require_once "./Seeder.php";
$courses = Seeder::createDemoData();

echo json_encode($courses);
