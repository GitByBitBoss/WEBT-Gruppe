<?php
header('Content-Type: application/json; charset=utf-8');
require_once "./Seeder.php";

if (!isset($_GET["id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Parameter 'id' fehlt."]);
    exit;
}

$id = (int) $_GET["id"];
$courses = Seeder::createDemoData();

if (!isset($courses[$id])) {
    http_response_code(404);
    echo json_encode(["error" => "Kurs mit ID $id nicht gefunden."]);
    exit;
}

$course = $courses[$id];

// Hilfsfunktionen für saubere Serialisierung
function safeGet($obj, $method, $fallback = null) {
    return (is_object($obj) && method_exists($obj, $method)) ? $obj->$method() : $fallback;
}

function courseToArray($course) {
    $questions = [];
    foreach (safeGet($course, "getQuestions", []) as $q) {
        $questions[] = [
            "text" => safeGet($q, "getText"),
            "options" => safeGet($q, "getOptions", []),
            "correctAnswer" => safeGet($q, "getCorrectAnswer")
        ];
    }

    return [
        "id" => safeGet($course, "getId"),
        "name" => safeGet($course, "getName"),
        "vehicleType" => safeGet($course, "getVehicleType"),
        "questions" => $questions
    ];
}

echo json_encode(courseToArray($course), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
