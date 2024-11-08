<?php

use PHPUnit\Framework\TestCase;

require 'gradingFunctions.php';

class GradingFunctionsTest extends TestCase {

    public function testCalcFinalGrade() {
        $grades = [
            'homework1' => 90, 'homework2' => 85, 'homework3' => 80, 'homework4' => 75, 'homework5' => 70,
            'quiz1' => 100, 'quiz2' => 90, 'quiz3' => 80, 'quiz4' => 70, 'quiz5' => 60,
            'midterm' => 88, 'final_project' => 92
        ];
        $expected = 86; // Based on weighted calculation
        $this->assertEquals($expected, calcFinalGrade($grades));
    }

    // You can add more tests for database interactions using mocks.
}

?>
