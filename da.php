<?php

function getDbConnection() {
    $dbc = new mysqli('localhost', 'csc350', 'xampp', 'gradingSystem');
    if ($dbc->connect_error) {
        throw new Exception('Database connection error: ' . $dbc->connect_error);
    }
    return $dbc;
}

?>
