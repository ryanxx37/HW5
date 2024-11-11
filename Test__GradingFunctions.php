<?php
require_once 'gradingFunctions.php';
require_once 'db.php';


function testGetDbConnection() {
    try {
        $dbc = getDbConnection();
        echo "testGetDbConnection: " . ($dbc instanceof mysqli ? "PASS" : "FAIL") . "\n";
    } catch (Exception $e) {
        echo "testGetDbConnection: FAIL - " . $e->getMessage() . "\n";
    }
}

function testCalcFinalGrade() {
    $grades = [
        'quiz1' => 80, 'quiz2' => 70, 'quiz3' => 90, 'quiz4' => 85, 'quiz5' => 95,
        'homework1' => 88, 'homework2' => 92, 'homework3' => 90, 'homework4' => 85, 'homework5' => 87,
        'midterm' => 78,
        'final_project' => 92
    ];
    
    $expectedFinalGrade = round((88.4 * 0.2) + (87.5 * 0.1) + (78 * 0.3) + (92 * 0.4));
    $actualFinalGrade = calcFinalGrade($grades);
    
    echo "testCalcFinalGrade: " . ($expectedFinalGrade === $actualFinalGrade ? "PASS" : "FAIL") . "\n";
}

function testInsertScores() {
    $dbc = getDbConnection();
    
    $grades = [
        'student_id' => 1,
        'homework1' => 88, 'homework2' => 92, 'homework3' => 90, 'homework4' => 85, 'homework5' => 87,
        'quiz1' => 80, 'quiz2' => 70, 'quiz3' => 90, 'quiz4' => 85, 'quiz5' => 95,
        'midterm' => 78,
        'final_project' => 92
    ];
    
    try {
        insertScores($dbc, $grades);
        echo "testInsertScores: PASS\n";
    } catch (Exception $e) {
        echo "testInsertScores: FAIL - " . $e->getMessage() . "\n";
    }
}

function testInsertFinalGrade() {
    $dbc = getDbConnection();
    $studentId = 1;
    $finalGrade = 85;
    
    try {
        insertFinalGrade($dbc, $studentId, $finalGrade);
        echo "testInsertFinalGrade: PASS\n";
    } catch (Exception $e) {
        echo "testInsertFinalGrade: FAIL - " . $e->getMessage() . "\n";
    }
}


// Run all tests
testCalcFinalGrade();
testInsertScores();
testInsertFinalGrade();
testGetDbConnection();
?>
