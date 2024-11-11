<?php

function calcFinalGrade($grades) {
    $quizzes = [$grades['quiz1'], $grades['quiz2'], $grades['quiz3'], $grades['quiz4'], $grades['quiz5']];
    sort($quizzes);
    array_shift($quizzes); // Drop the lowest quiz score

    $homeworks = [$grades['homework1'], $grades['homework2'], $grades['homework3'], $grades['homework4'], $grades['homework5']];
    $homework_avg = array_sum($homeworks) / count($homeworks);
    $quiz_avg = array_sum($quizzes) / count($quizzes);

    return round(($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($grades['midterm'] * 0.3) + ($grades['final_project'] * 0.4));
}

function studentExists($dbc, $studentId) {
    $query = "SELECT 1 FROM scores WHERE student_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

function updateScores($dbc, $grades) {
    $query = "
        UPDATE scores SET
            Homework1 = ?, Homework2 = ?, Homework3 = ?, Homework4 = ?, Homework5 = ?,
            Quiz1 = ?, Quiz2 = ?, Quiz3 = ?, Quiz4 = ?, Quiz5 = ?,
            Midterm = ?, Final_Project = ?
        WHERE student_id = ?
    ";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param(
        "iiiiiiiiiiiis",
        $grades['homework1'], $grades['homework2'], $grades['homework3'], $grades['homework4'], $grades['homework5'],
        $grades['quiz1'], $grades['quiz2'], $grades['quiz3'], $grades['quiz4'], $grades['quiz5'],
        $grades['midterm'], $grades['final_project'],
        $grades['student_id']
    );
    $stmt->execute();
    $stmt->close();
}

function insertScores($dbc, $grades) {
    $query = "
        INSERT INTO scores (student_id, Homework1, Homework2, Homework3, Homework4, Homework5, Quiz1, Quiz2, Quiz3, Quiz4, Quiz5, Midterm, Final_Project)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('iiiiiiiiiiiii', 
        $grades['student_id'], $grades['homework1'], $grades['homework2'], $grades['homework3'], 
        $grades['homework4'], $grades['homework5'], $grades['quiz1'], $grades['quiz2'], 
        $grades['quiz3'], $grades['quiz4'], $grades['quiz5'], $grades['midterm'], $grades['final_project']
    );
    $stmt->execute();
    $stmt->close();
}

function insertFinalGrade($dbc, $studentId, $finalGrade) {
    $query = "INSERT INTO final (student_id, Final_Grade) VALUES (?, ?)";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('ii', $studentId, $finalGrade);
    $stmt->execute();
    $stmt->close();
}

// Check if a final grade record exists for the student
function finalGradeExists($dbc, $studentId) {
    $query = "SELECT 1 FROM final WHERE student_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Update the final grade for an existing student
function updateFinalGrade($dbc, $studentId, $finalGrade) {
    $query = "UPDATE final SET Final_Grade = ? WHERE student_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("di", $finalGrade, $studentId);
    $stmt->execute();
    $stmt->close();
}

?>
