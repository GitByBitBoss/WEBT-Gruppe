<?php
require_once "./Question.php";
require_once "./Course.php";
class Seeder {
    public static function createDemoData(): array {
        $courses = [];

        for ($i = 1; $i <= 3; $i++) {
            $questions = [];
            for ($j = 0; $j <= 3; $j++) {
                $questions[] = new Question(
                    $j,
                    "Frage $j zu Kurs $i",
                    ["Antwort A", "Antwort B", "Antwort C"],
                    "Antwort A",
                    1
                );
            }
            $courses[] = new Course($i, "Kurs $i", "PKW", $questions);
        }

        return $courses;
    }
}