<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class QuestionSettersTest extends TestCase {
    public function testSetters() {
        $q = new Question(1, 'Text', ['a','b'], 'a', 1);
        $this->assertEquals(1, $q->getId());

        $q->setId(5);
        $this->assertEquals(5, $q->getId());

        $q->setText('New');
        $this->assertEquals('New', $q->getText());

        $q->setOptions(['x']);
        $this->assertEquals(['x'], $q->getOptions());

        $q->setCorrectAnswer('x');
        $this->assertEquals('x', $q->getCorrectAnswer());

        $q->setVersionNumber(2);
        $this->assertEquals(2, $q->getVersionNumber());

        $this->assertFalse($q->isCorrect('wrong'));
        $this->assertTrue($q->isCorrect('x'));

        $arr = $q->jsonSerialize();
        $this->assertArrayHasKey('text', $arr);
    }
}
