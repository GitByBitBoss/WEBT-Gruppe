<?php

namespace Webt\Drivingschool;

class Question implements \JsonSerializable {
    protected $id;
    protected $text;
    protected $options;
    protected $correctAnswer;
    protected $versionNumber;

    public function __construct($id, $text, $options, $correctAnswer, $versionNumber) {
        $this->id = $id;
        $this->text = $text;
        $this->options = $options;
        $this->correctAnswer = $correctAnswer;
        $this->versionNumber = $versionNumber;
    }

    // Getter für ID
    public function getId() {
        return $this->id;
    }

    // Setter für ID
    public function setId($id) {
        $this->id = $id;
    }

    // Getter für Fragetext
    public function getText() {
        return $this->text;
    }

    // Setter für Fragetext
    public function setText($text) {
        $this->text = $text;
    }

    // Getter für Antwortoptionen
    public function getOptions() {
        return $this->options;
    }

    // Setter für Antwortoptionen (z. B. Array)
    public function setOptions($options) {
        $this->options = $options;
    }

    // Getter für richtige Antwort
    public function getCorrectAnswer() {
        return $this->correctAnswer;
    }

    // Setter für richtige Antwort
    public function setCorrectAnswer($correctAnswer) {
        $this->correctAnswer = $correctAnswer;
    }

    // Getter für Versionsnummer
    public function getVersionNumber() {
        return $this->versionNumber;
    }

    // Setter für Versionsnummer
    public function setVersionNumber($versionNumber) {
        $this->versionNumber = $versionNumber;
    }

    // Optionale Zusatzmethode: Antwort prüfen
    public function isCorrect($answer) {
        return $this->correctAnswer === $answer;
    }

    // Implementierung der jsonSerialize-Methode
    public function jsonSerialize():array {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'options' => $this->options,
            'correctAnswer' => $this->correctAnswer,
            'versionNumber' => $this->versionNumber
        ];
    }
}
