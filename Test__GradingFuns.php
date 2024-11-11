<?php
require_once 'db.php';
require_once 'path_to_your_function_file.php'; // Update to the path of the file containing getStudentGrades

function testGetStudentGrades() {
    $dbc = getDbConnection();

    try {
        $grades = getStudentGrades($dbc);

        if (is_array($grades)) {
            echo "testGetStudentGrades: PASS - Returned data is an array.\n";
        } else {
            echo "testGetStudentGrades: FAIL - Returned data is not an array.\n";
            return;
        }

        if (count($grades) > 0) {
            echo "testGetStudentGrades: PASS - Returned array is not empty.\n";
            
            // Check if the keys match expected structure
            $requiredKeys = ['student_id', 'studentName', 'Homework1', 'Homework2', 'Homework3', 'Homework4', 'Homework5', 
                             'Quiz1', 'Quiz2', 'Quiz3', 'Quiz4', 'Quiz5', 'Midterm', 'Final_Project', 'Final_Grade'];
            $missingKeys = array_diff($requiredKeys, array_keys($grades[0]));

            if (empty($missingKeys)) {
                echo "testGetStudentGrades: PASS - All required keys are present.\n";
            } else {
                echo "testGetStudentGrades: FAIL - Missing keys: " . implode(', ', $missingKeys) . "\n";
            }
        } else {
            echo "testGetStudentGrades: WARNING - Returned array is empty. Check if there is data in the database.\n";
        }

    } catch (Exception $e) {
        echo "testGetStudentGrades: FAIL - " . $e->getMessage() . "\n";
    }
}

// Run the test
testGetStudentGrades();
?>
