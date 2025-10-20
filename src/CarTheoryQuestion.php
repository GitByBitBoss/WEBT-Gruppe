<?php
require_once "Question.php";
class CarTheoryQuestion extends Question {
    

    function getHTML(): string {
        return "
        <h2>{$this->getCategory()}</h2>
        <h3>{$this->getName()}</h3>
        <img src='../images/car.svg' width='2%' height='2%' />";
     }

    public function __construct($name,$category) {
        parent::__construct($name,$category);
    }
}