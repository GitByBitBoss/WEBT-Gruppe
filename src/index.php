<?php
echo "test";

require_once "../src/CarTheoryQuestion.php";
require_once "../src/MotorcycleTheoryQuestion.php";

$carQst = new CarTheoryQuestion("How large is a car","Car Theory");
echo $carQst->getHTML();
?>
