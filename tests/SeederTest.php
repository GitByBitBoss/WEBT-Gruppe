<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\Seeder;
use Webt\Drivingschool\Course;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class SeederTest extends TestCase {
    public function testCreateDemoDataStructure() {
        $courses = Seeder::createDemoData();
        $this->assertIsArray($courses);
        $this->assertCount(3, $courses);

        foreach ($courses as $course) {
            $this->assertInstanceOf(Course::class, $course);
            $this->assertIsArray($course->getQuestions());
            $this->assertCount(4, $course->getQuestions());
            foreach ($course->getQuestions() as $q) {
                $this->assertInstanceOf(Question::class, $q);
                $this->assertIsString($q->getText());
                $this->assertIsArray($q->getOptions());
            }
        }
    }
}
