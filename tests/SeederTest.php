<?php
use PHPUnit\Framework\TestCase;
use Webt\Drivingschool\Seeder;
use Webt\Drivingschool\Course;
use Webt\Drivingschool\Question;

require_once __DIR__ . '/../vendor/autoload.php';

class SeederTest extends TestCase {
    private $courses;

    protected function setUp(): void
    {
        $this->courses = Seeder::createDemoData();
    }

    protected function tearDown(): void
    {
        $this->courses = null;
    }

    public function testCreateDemoDataStructure() {
        $this->assertIsArray($this->courses);
        $this->assertCount(3, $this->courses);

        foreach ($this->courses as $course) {
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
