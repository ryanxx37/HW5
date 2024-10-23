<?php

$dbc = mysqli_connect('localhost','csc350','xampp','gradingSystem');

if (!$dbc) {
    die('Database connection error: ' . mysqli_connect_error());
}

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

$result = mysqli_query($dbc, $query);

if (!$result) {
    die('Query error: ' . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title>Grading System</title>
</head>
<body>
    <h1>Student Grades</h1>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Homework 1</th>
                <th>Homework 2</th>
                <th>Homework 3</th>
                <th>Homework 4</th>
                <th>Homework 5</th>
                <th>Quiz 1</th>
                <th>Quiz 2</th>
                <th>Quiz 3</th>
                <th>Quiz 4</th>
                <th>Quiz 5</th>
                <th>Midterm</th>
                <th>Final Project</th>
                <th>Final Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['student_id'] . "</td>";
                    echo "<td>" . $row['studentName'] . "</td>";
                    echo "<td>" . $row['Homework1'] . "</td>";
                    echo "<td>" . $row['Homework2'] . "</td>";
                    echo "<td>" . $row['Homework3'] . "</td>";
                    echo "<td>" . $row['Homework4'] . "</td>";
                    echo "<td>" . $row['Homework5'] . "</td>";
                    echo "<td>" . $row['Quiz1'] . "</td>";
                    echo "<td>" . $row['Quiz2'] . "</td>";
                    echo "<td>" . $row['Quiz3'] . "</td>";
                    echo "<td>" . $row['Quiz4'] . "</td>";
                    echo "<td>" . $row['Quiz5'] . "</td>";
                    echo "<td>" . $row['Midterm'] . "</td>";
                    echo "<td>" . $row['Final_Project'] . "</td>";
                    echo "<td>" . $row['Final_Grade'] . "</td>";
                    echo "</tr>";  
                }
            } else {
                echo "<tr><td>No students found!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
mysqli_close($dbc);

?>