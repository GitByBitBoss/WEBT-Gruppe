<?php

class Course {
    protected $id;
    protected $name;
    protected $vehicleType;
    protected $questions = [];

     public function __construct($id, $name, $vehicleType, $questions = []) {
        $this->id = $id;
        $this->name = $name;
        $this->vehicleType = $vehicleType;
        $this->questions = $questions;
    }

    // Getter für ID
    public function getId() {
        return $this->id;
    }

    // Setter für ID
    public function setId($id) {
        $this->id = $id;
    }

    // Getter für Name
    public function getName() {
        return $this->name;
    }

    // Setter für Name
    public function setName($name) {
        $this->name = $name;
    }

    // Getter für Fahrzeugtyp
    public function getVehicleType() {
        return $this->vehicleType;
    }

    // Setter für Fahrzeugtyp
    public function setVehicleType($vehicleType) {
        $this->vehicleType = $vehicleType;
    }

    // Getter für Fragenliste
    public function getQuestions() {
        return $this->questions;
    }

    // Setter für Fragenliste (komplett ersetzen)
    public function setQuestions($questions) {
        $this->questions = $questions;
    }

    // Optionale Ergänzung: Frage hinzufügen
    public function addQuestion($question) {
        $this->questions[] = $question;
    }

    


}