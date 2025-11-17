<?php
require_once __DIR__ . "/../src/Seeder.php";
require_once __DIR__ . "/../src/Course.php";
require_once __DIR__ . "/../src/Question.php";

$courses = Seeder::createDemoData();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Seeder Demo – Mock Daten</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .course {
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .question {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        .options {
            margin-left: 40px;
        }
        .correct {
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<h1>Seeder – Demo Mock Daten</h1>
<p>Hier siehst du die Daten, die der Seeder für Präsentationszwecke erzeugt.</p>

<?php foreach ($courses as $course): ?>
    <div class="course">
        <h2>Kurs <?= $course->getId() ?>: <?= $course->getName() ?></h2>
        <p><strong>Fahrzeugtyp:</strong> <?= $course->getVehicleType() ?></p>

        <h3>Fragen:</h3>

        <?php foreach ($course->getQuestions() as $q): ?>
            <div class="question">
                <strong>Frage <?= $q->getId() ?>:</strong> <?= $q->getText() ?><br>

                <div class="options">
                    <?php foreach ($q->getOptions() as $opt): ?>
                        • <?= $opt ?><br>
                    <?php endforeach; ?>
                </div>

                <p class="correct">Richtige Antwort: <?= $q->getCorrectAnswer() ?></p>
            </div>
        <?php endforeach; ?>

    </div>
<?php endforeach; ?>

</body>
</html>
