<?php
require_once "Question.php";
class CarTheoryQuestion extends Question {
    public function __construct($name,$category) {
        parent::__construct($name,$category);
    }
}