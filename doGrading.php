<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title>Grading System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="shadow">

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

    if (studentExists($dbc, $grades['student_id'])) {
        // Update scores if student exists
        updateScores($dbc, $grades);
    } else {
        // Insert new scores if student does not exist
        insertScores($dbc, $grades);
    }

    // Calculate and insert final grade
    $finalGrade = calcFinalGrade($grades);
    
    if (finalGradeExists($dbc, $grades['student_id'])) {
        updateFinalGrade($dbc, $grades['student_id'], $finalGrade);
    } else {
        insertFinalGrade($dbc, $grades['student_id'], $finalGrade);
    }
    

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
<div class="submitb">
<form action="dispayGrade.php" method="post">
    <input type="submit" name="submit" value="Display Student Scores">
</form>
</div>
</div>
</body>
</html>
