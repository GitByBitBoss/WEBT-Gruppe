<?php

namespace Webt\Drivingschool\Interfaces;

interface QuestionInterface {
    public function getName(): string;
    public function getCategory(): string;
    public function getHTML(): string;
}