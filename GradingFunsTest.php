<?php

use PHPUnit\Framework\TestCase;

require 'gradingFuns.php';

class GradingFunctionsTest extends TestCase {

    public function testGetStudentGrades() {
        // Mock the database connection
        $mockDb = $this->createMock(mysqli::class);
        $mockResult = $this->createMock(mysqli_result::class);

        $mockResult->method('fetch_assoc')->willReturnOnConsecutiveCalls(
            ['student_id' => 1, 'studentName' => 'John Doe', 'Final_Grade' => 90],
            null  // End of fetch
        );

        $mockDb->method('query')->willReturn($mockResult);

        $result = getStudentGrades($mockDb);

        $this->assertCount(1, $result);
        $this->assertEquals('John Doe', $result[0]['studentName']);
        $this->assertEquals(90, $result[0]['Final_Grade']);
    }

    // Add more tests to handle edge cases
}
?>
