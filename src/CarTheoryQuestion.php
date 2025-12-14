<?php

namespace Webt\Drivingschool;

use Webt\Drivingschool\Question;

class CarTheoryQuestion extends Question {
    function getHTML(): string {
        return "
        <h2>{$this->getVersionNumber()}</h2>
        <h3>{$this->getText()}</h3>
        <img src='../images/car.svg' width='2%' height='2%' />";
     }

    public function __construct($id, $text, $options = [], $correctAnswer = null, $versionNumber = 1) {
        parent::__construct($id, $text, $options, $correctAnswer, $versionNumber);
    }
}