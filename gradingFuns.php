<?php

function getStudentGrades($dbc) {
    $query = "
        SELECT 
            students.student_id, 
            students.studentName, 
            scores.Homework1, 
            scores.Homework2,
            scores.Homework3,
            scores.Homework4, 
            scores.Homework5, 
            scores.Quiz1, 
            scores.Quiz2, 
            scores.Quiz3, 
            scores.Quiz4, 
            scores.Quiz5,
            scores.Midterm,
            scores.Final_Project,
            final.Final_Grade
        FROM students
        LEFT JOIN scores ON students.student_id = scores.student_id
        LEFT JOIN final ON students.student_id = final.student_id
    ";

    $result = $dbc->query($query);

    if (!$result) {
        throw new Exception("Query error: " . $dbc->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

?>
