<?php

$dbc = mysqli_connect('localhost','csc350','xampp','gradingSystem')

if (!$dbc) {
    die('Database connection error: ' . mysqli_connect_error());
}

$query = "
        SELECT 
            s.student_id, 
            s.studentName, 
            g.Homework1, 
            g.Homework2,
            g.Homework3,
            g.Homework4, 
            g.Homework5, 
            g.Quiz1, 
            g.Quiz2, 
            g.Quiz3, 
            g.Quiz, 
            g.Quiz5,
            g.Midterm,
            g.Final_Project,
            f.Final_Grade
        FROM students s
        JOIN grades g ON s.student_id = g.students_id
        JOIN final f ON s.student_id = f.student_id
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
                    echo "<td>" . $row['student_name'] . "</td>";
                    echo "<td>" . $row['homework1'] . "</td>";
                    echo "<td>" . $row['homework2'] . "</td>";
                    echo "<td>" . $row['homework3'] . "</td>";
                    echo "<td>" . $row['homework4'] . "</td>";
                    echo "<td>" . $row['homework5'] . "</td>";
                    echo "<td>" . $row['quiz1'] . "</td>";
                    echo "<td>" . $row['quiz2'] . "</td>";
                    echo "<td>" . $row['quiz3'] . "</td>";
                    echo "<td>" . $row['quiz4'] . "</td>";
                    echo "<td>" . $row['quiz5'] . "</td>";
                    echo "<td>" . $row['midterm'] . "</td>";
                    echo "<td>" . $row['final_project'] . "</td>";
                    echo "<td>" . $row['final_grade'] . "</td>";
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