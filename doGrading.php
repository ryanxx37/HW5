<?php

require 'db.php';
require 'gradingFunctions.php';

// Function to sanitize and validate inputs
function sanitizeAndValidate($postData, $requiredFields) {
    $data = [];
    foreach ($requiredFields as $field) {
        if (!isset($postData[$field]) || !is_numeric($postData[$field])) {
            throw new Exception("Invalid or missing input: " . $field);
        }
        $data[$field] = (int)htmlspecialchars(trim($postData[$field]));
    }
    return $data;
}

try {
    $requiredFields = ['student_id', 'homework1', 'homework2', 'homework3', 'homework4', 'homework5', 
                       'quiz1', 'quiz2', 'quiz3', 'quiz4', 'quiz5', 'midterm', 'final_project'];
    $grades = sanitizeAndValidate($_POST, $requiredFields);

    $dbc = getDbConnection(); // From `db.php`
    $dbc->begin_transaction();

    // Insert scores
    insertScores($dbc, $grades);

    // Calculate and insert final grade
    $finalGrade = calcFinalGrade($grades);
    insertFinalGrade($dbc, $grades['student_id'], $finalGrade);

    $dbc->commit();

    echo "<h1>Grades submitted successfully!</h1>";

} catch (Exception $e) {
    if (isset($dbc)) $dbc->rollback();
    error_log($e->getMessage());
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($dbc)) $dbc->close();
}

?>
