<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\MotorcycleTheoryQuestion;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class MotorcycleTheoryQuestionTest extends TestCase {
    public function testConstructAndGetHTML() {
        $q = new MotorcycleTheoryQuestion(202, 'Helmet required?', ['yes','no'], 'yes', 3);

        $this->assertInstanceOf(MotorcycleTheoryQuestion::class, $q);
        $this->assertInstanceOf(Question::class, $q);

        $html = $q->getHTML();
        $this->assertStringContainsString('3', $html);
        $this->assertStringContainsString('Helmet required?', $html);
        $this->assertStringContainsString('motorcycle.svg', $html);
    }
}
