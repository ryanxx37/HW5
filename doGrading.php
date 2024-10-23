<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title>Grading System</title>
</head>
<body>

<?php

$student_id = $_POST['student_id'];
$homework1 = $_POST['homework1'];
$homework2 = $_POST['homework2'];
$homework3 = $_POST['homework3'];
$homework4 = $_POST['homework4'];
$homework5 = $_POST['homework5'];
$quiz1 = $_POST['quiz1'];
$quiz2 = $_POST['quiz2'];
$quiz3 = $_POST['quiz3'];
$quiz4 = $_POST['quiz4'];
$quiz5 = $_POST['quiz5'];
$midterm = $_POST['midterm'];
$final_project = $_POST['final_project'];


$dbc = mysqli_connect('localhost','csc350','xampp','gradingSystem')

if (!$dbc) {
    die('Database connection error: ' . mysqli_connect_error());
}

$insert_query = "
    INSERT INTO scores (student_id, Homework1, Homework2, Homework3, Homework4, Homework5, Quiz1, Quiz2, Quiz3, Quiz4, Quiz5, Midterm, Final_Project)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
"

$stmt = mysqli_prepare($dbc, $insert_query);
mysqli_stmt_bind_param($stmt, 'iiiiiiiiiiiii', $student_id, $homework1, $homework2, $homework3, $homework4, $homework5, $quiz1, $quiz2, $quiz3, $quiz4, $quiz5, $midterm, $final_project);
mysqli_stmt_execute($stmt);


function calcFinalGrade($grades) {
    $quizzes = [$grades['quiz1'], $grades['quiz2'], $grades['quiz3'], $grades['quiz4'], $grades['quiz5']];
    sort($quizzes);
    array_shift($quizzes); // drop the lowset quiz score

    $homework_avg = array_sum($grades['homework1'], $grades['homework2'], $grades['homework3'], $grades['homework4'], $grades['homework5']) / 5;
    $quiz_avg = array_sum($quizzes) / 4;

    $final_grade = round(($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midterm * 0.3) + ($final_project * 0.4));

    return $final_grade;
}

$grades = [
    'homework1' => $homework1,
    'homework2' => $homework2,
    'homework3' => $homework3,
    'homework4' => $homework4,
    'homework5' => $homework5,
    'quiz1' => $quiz1,
    'quiz2' => $quiz2,
    'quiz3' => $quiz3,
    'quiz4' => $quiz4,
    'quiz5' => $quiz5,
    'midterm' => $midterm,
    'final_project' => $final_project,
];

$final_grade = calcFinalGrade($grades);

$stmt_final = mysqli_prepare($dbc, 'INSERT INTO final (student_id, Final_Grade) VALUES (?, ?)');
mysqli_stmt_bind_param($stmt_final, 'ii', $student_id, $final_grade);
mysqli_stmt_execute($stmt_final);

echo "Grads submitted successfully!"

mysqli_close($dbc);
?>

<form action="dispayGrade.php" method="post">
    <input type="submit" name="submit" value="Display Student Scores">
</form>

</body>
</html>