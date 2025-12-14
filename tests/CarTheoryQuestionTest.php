<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\CarTheoryQuestion;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class CarTheoryQuestionTest extends TestCase {
    public function testConstructAndGetHTML() {
        $q = new CarTheoryQuestion(101, 'Stop sign?', ['yes','no'], 'yes', 2);

        $this->assertInstanceOf(CarTheoryQuestion::class, $q);
        $this->assertInstanceOf(Question::class, $q);

        $html = $q->getHTML();
        $this->assertStringContainsString('2', $html);
        $this->assertStringContainsString('Stop sign?', $html);
        $this->assertStringContainsString('car.svg', $html);
    }
}
