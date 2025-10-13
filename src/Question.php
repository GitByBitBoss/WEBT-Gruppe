<?php
require_once __DIR__ ."/interfaces/QuestionInterface.php";

abstract class Question implements QuestionInterface {
    protected string $name;
    protected string $category;
    function getName(): string {
        return $this->name;
    }

    function getCategory(): string {
        return $this->category;
    }

    function getHTML(): string {
        return "
        <h2>{$this->getCategory()}</h2>
        <h3>{$this->getName()}</h3>";
     }

     public function __construct(string $name, string $category) {
        $this->name = $name;
        $this->category = $category;
     }
     

}