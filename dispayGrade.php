<?php

require 'db.php';  // Reusable database connection logic
require 'gradingFuns.php';  // Query and display logic

try {
    $dbc = getDbConnection();  // Fetch database connection

    $studentsData = getStudentGrades($dbc);  // Fetch grades data

} catch (Exception $e) {
    error_log($e->getMessage());
    die("Error retrieving data: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title>Grading System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
            <?php if (!empty($studentsData)): ?>
                <?php foreach ($studentsData as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['studentName']) ?></td>
                        <td><?= htmlspecialchars($row['Homework1']) ?></td>
                        <td><?= htmlspecialchars($row['Homework2']) ?></td>
                        <td><?= htmlspecialchars($row['Homework3']) ?></td>
                        <td><?= htmlspecialchars($row['Homework4']) ?></td>
                        <td><?= htmlspecialchars($row['Homework5']) ?></td>
                        <td><?= htmlspecialchars($row['Quiz1']) ?></td>
                        <td><?= htmlspecialchars($row['Quiz2']) ?></td>
                        <td><?= htmlspecialchars($row['Quiz3']) ?></td>
                        <td><?= htmlspecialchars($row['Quiz4']) ?></td>
                        <td><?= htmlspecialchars($row['Quiz5']) ?></td>
                        <td><?= htmlspecialchars($row['Midterm']) ?></td>
                        <td><?= htmlspecialchars($row['Final_Project']) ?></td>
                        <td><?= htmlspecialchars($row['Final_Grade']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="15">No students found!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$dbc->close();
?>
