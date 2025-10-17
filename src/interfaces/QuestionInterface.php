<?php

Interface QuestionInterface {
    public function getName(): string;
    public function getCategory(): string;
    public function getHTML(): string;
}