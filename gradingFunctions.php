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
}

function insertFinalGrade($dbc, $studentId, $finalGrade) {
    $query = "INSERT INTO final (student_id, Final_Grade) VALUES (?, ?)";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('ii', $studentId, $finalGrade);
    $stmt->execute();
}

?>