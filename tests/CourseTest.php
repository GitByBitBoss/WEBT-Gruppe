<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\Course;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class CourseTest extends TestCase {

    public function testConstructAndGetters() {
        $q1 = new Question(1, 'What color is the sky?', ['blue','green'], 'blue', 1);
        $course = new Course(10, 'Basic Driving', 'car', [$q1]);

        $this->assertEquals(10, $course->getId());
        $this->assertEquals('Basic Driving', $course->getName());
        $this->assertEquals('car', $course->getVehicleType());
        $this->assertCount(1, $course->getQuestions());
    }

    public function testAddQuestionAndJsonSerialize() {
        $q1 = new Question(1, 'Q1?', ['a','b'], 'a', 1);
        $q2 = new Question(2, 'Q2?', ['x','y'], 'y', 1);

        $course = new Course(20, 'Advanced', 'motorcycle');
        $course->addQuestion($q1);
        $course->addQuestion($q2);

        $this->assertCount(2, $course->getQuestions());
        $json = json_encode($course);
        $this->assertStringContainsString('Advanced', $json);
        $this->assertStringContainsString('motorcycle', $json);
    }

    public function testEmptyQuestionsList() {
        $course = new Course(30, 'Empty Course', 'car');
        $this->assertIsArray($course->getQuestions());
        $this->assertCount(0, $course->getQuestions());
    }

    public function testQuestionIsCorrect() {
        $q = new Question(3, 'The sky is blue, Right?', ['yes','no'], 'yes', 1);
        $this->assertTrue($q->isCorrect('yes'));
        $this->assertFalse($q->isCorrect('no'));
    }
}
