CREATE DATABASE IF NOT EXISTS gradingSystem;

USE gradingSystem;

DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS scores;

CREATE TABLE students(
    student_id int AUTO_INCREMENT PRIMARY KEY,
    studentName varchar(100) NOT NULL
);

CREATE TABLE scores(
    student_id int,
    Homework1 int,
    Homework2 int,
    Homework3 int,
    Homework4 int,
    Homework5 int,
    Quiz1 int,
    Quiz2 int,
    Quiz3 int,
    Quiz4 int,
    Quiz5 int,
    Midterm int,
    Final_Project int,
    FOREIGN KEY(student_id) REFERENCES students(student_id)
);

CREATE TABLE final(
    final_id int AUTO_INCREMENT PRIMARY KEY,
    student_id int,
    Final_Grade int,
    FOREIGN KEY(student_id) REFERENCES students(student_id)
);


INSERT INTO students(studentName)
VALUES
('Doe','John'),
('Smith','Jane'),
('Max','Koo');
('Alice Johnson'),
('Bob Williams'),
('Michael Brown');
