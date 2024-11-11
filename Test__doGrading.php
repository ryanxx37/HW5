<?php
require_once 'db.php';
require_once 'gradingFunctions.php';
require_once 'path_to_your_function_file.php'; // Update with the path to your main file

function testSanitizeAndValidate() {
    $postData = [
        'student_id' => '1', 
        'homework1' => '88', 'homework2' => '92', 'homework3' => '90', 
        'homework4' => '85', 'homework5' => '87', 
        'quiz1' => '80', 'quiz2' => '70', 'quiz3' => '90', 'quiz4' => '85', 'quiz5' => '95',
        'midterm' => '78', 'final_project' => '92'
    ];
    $requiredFields = ['student_id', 'homework1', 'homework2', 'homework3', 'homework4', 'homework5', 
                       'quiz1', 'quiz2', 'quiz3', 'quiz4', 'quiz5', 'midterm', 'final_project'];

    try {
        $sanitizedData = sanitizeAndValidate($postData, $requiredFields);
        echo "testSanitizeAndValidate: PASS - Data sanitized and validated successfully.\n";
    } catch (Exception $e) {
        echo "testSanitizeAndValidate: FAIL - " . $e->getMessage() . "\n";
    }
}

function testProcessGrades() {
    $postData = [
        'student_id' => '1', 
        'homework1' => '88', 'homework2' => '92', 'homework3' => '90', 
        'homework4' => '85', 'homework5' => '87', 
        'quiz1' => '80', 'quiz2' => '70', 'quiz3' => '90', 'quiz4' => '85', 'quiz5' => '95',
        'midterm' => '78', 'final_project' => '92'
    ];
    $requiredFields = ['student_id', 'homework1', 'homework2', 'homework3', 'homework4', 'homework5', 
                       'quiz1', 'quiz2', 'quiz3', 'quiz4', 'quiz5', 'midterm', 'final_project'];

    try {
        // Sanitize and validate inputs
        $grades = sanitizeAndValidate($postData, $requiredFields);

        $dbc = getDbConnection();
        $dbc->begin_transaction();

        // Insert scores and calculate final grade
        insertScores($dbc, $grades);
        $finalGrade = calcFinalGrade($grades);
        insertFinalGrade($dbc, $grades['student_id'], $finalGrade);

        $dbc->commit();
        echo "testProcessGrades: PASS - Grades processed and committed successfully.\n";
    } catch (Exception $e) {
        if (isset($dbc)) $dbc->rollback();
        echo "testProcessGrades: FAIL - " . $e->getMessage() . "\n";
    } finally {
        if (isset($dbc)) $dbc->close();
    }
}

function testProcessGradesWithInvalidData() {
    $postData = [
        'student_id' => '1', 
        'homework1' => '88', 'homework2' => 'invalid', // invalid data for testing
        'homework3' => '90', 'homework4' => '85', 'homework5' => '87', 
        'quiz1' => '80', 'quiz2' => '70', 'quiz3' => '90', 'quiz4' => '85', 'quiz5' => '95',
        'midterm' => '78', 'final_project' => '92'
    ];
    $requiredFields = ['student_id', 'homework1', 'homework2', 'homework3', 'homework4', 'homework5', 
                       'quiz1', 'quiz2', 'quiz3', 'quiz4', 'quiz5', 'midterm', 'final_project'];

    try {
        $grades = sanitizeAndValidate($postData, $requiredFields);
        echo "testProcessGradesWithInvalidData: FAIL - Invalid data passed validation.\n";
    } catch (Exception $e) {
        echo "testProcessGradesWithInvalidData: PASS - Caught error with invalid data: " . $e->getMessage() . "\n";
    }
}

// Run the tests
testSanitizeAndValidate();
testProcessGrades();
testProcessGradesWithInvalidData();
?>
