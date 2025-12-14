<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\Course;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class CourseSettersTest extends TestCase {
    public function testSettersAndJson() {
        $course = new Course(1, 'A', 'car', []);
        $this->assertEquals(1, $course->getId());

        $course->setId(2);
        $this->assertEquals(2, $course->getId());

        $course->setName('B');
        $this->assertEquals('B', $course->getName());

        $course->setVehicleType('motorcycle');
        $this->assertEquals('motorcycle', $course->getVehicleType());

        $q = new Question(10, 'T', ['o1'], 'o1', 1);
        $course->addQuestion($q);
        $this->assertCount(1, $course->getQuestions());

        $course->setQuestions([]);
        $this->assertCount(0, $course->getQuestions());

        $json = json_encode($course);
        $this->assertStringContainsString('vehicleType', $json);
    }
}
