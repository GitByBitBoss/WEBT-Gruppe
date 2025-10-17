<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Theoriefragen – DriveWell</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<h1>Theoriefragen</h1>

<?php

require_once "../src/CarTheoryQuestion.php";
require_once "../src/MotorcycleTheoryQuestion.php";

// --- Car Theory Questions ---

$questionsCar = [
    new CarTheoryQuestion("How large is a car", "Car Theory"),
    new CarTheoryQuestion("How much does a car weigh", "Car Theory"),
    new CarTheoryQuestion("What is the minimum tire tread depth for cars?", "Car Theory"),
    new CarTheoryQuestion("At what speed must you use a seatbelt?", "Car Theory"),
    new CarTheoryQuestion("What does a red traffic light mean?", "Car Theory"),
    new CarTheoryQuestion("When should you use your headlights?", "Car Theory"),
    new CarTheoryQuestion("What does an amber traffic light indicate?", "Car Theory"),
    new CarTheoryQuestion("How should you overtake another vehicle safely?", "Car Theory"),
    new CarTheoryQuestion("What does a blue road sign generally indicate?", "Car Theory"),
    new CarTheoryQuestion("How far should you park from a fire hydrant?", "Car Theory"),
    new CarTheoryQuestion("What is the main function of the catalytic converter?", "Car Theory"),
    new CarTheoryQuestion("What should you check before a long journey?", "Car Theory"),
];

$questionsBike = [
    new MotorcycleTheoryQuestion("What safety gear must a motorcyclist always wear?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("What does countersteering mean?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("When should you use your motorcycle’s high beam?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("How often should you check your chain tension?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("What is the correct tire pressure for motorcycles?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("Why is visibility important for motorcyclists?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("What should you do if your motorcycle starts to skid?", "Motorcycle Theory"),
    new MotorcycleTheoryQuestion("How do you safely corner on a motorcycle?", "Motorcycle Theory")

];

foreach( $questionsCar as $questionCar){
    echo '<div class="questionCar">' . $questionCar->getHTML() . '</div>';
}

foreach( $questionsBike as $questionBike){
    echo '<div class="questionBike">' . $questionBike->getHTML() . '</div>';
}

?>

</body>
</html>

