<?php
require_once "Question.php";
class MotorcycleTheoryQuestion extends Question {
    public function __construct($name,$category) {
        parent::__construct($name,$category);
    }

    
    function getHTML(): string {
        return "
        <h2>{$this->getCategory()}</h2>
        <h3>{$this->getName()}</h3>
        <img src='../images/motorcycle.svg' width='2%' height='2%' />";
     }
}