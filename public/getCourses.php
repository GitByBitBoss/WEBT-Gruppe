<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../vendor/autoload.php';

use Webt\Drivingschool\Seeder;

$courses = Seeder::createDemoData();

echo json_encode($courses, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
