<?php

namespace Webt\Drivingschool;

use Webt\Drivingschool\Question;

class MotorcycleTheoryQuestion extends Question {
    public function __construct($id, $text, $options = [], $correctAnswer = null, $versionNumber = 1) {
        parent::__construct($id, $text, $options, $correctAnswer, $versionNumber);
    }

    function getHTML(): string {
        return "
        <h2>{$this->getVersionNumber()}</h2>
        <h3>{$this->getText()}</h3>
        <img src='../images/motorcycle.svg' width='2%' height='2%' />";
     }
}