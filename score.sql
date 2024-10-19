CREATE DATABASE IF NOT EXISTS score;

USE score;

DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS scores;

CREATE TABLE students(
    student_id int AUTO_INCREMENT PRIMARY KEY,
    lastName varchar(50) NOT NULL,
    firstName varchar(50) NOT NULL,
    email varchar(100) NOT NULL,
    phone varchar(20),
    class varchar(50),
    major varchar(50)
);

CREATE TABLE scores(
    student_id int,
    Homework1 varchar(10) NOT NULL,
    Homework2 varchar(10) NOT NULL,
    Homework3 varchar(10) NOT NULL,
    Homework4 varchar(10) NOT NULL,
    Homework5 varchar(10) NOT NULL,
    Quiz1 varchar(10) NOT NULL,
    Quiz2 varchar(10) NOT NULL,
    Quiz3 varchar(10) NOT NULL,
    Quiz4 varchar(10) NOT NULL,
    Quiz5 varchar(10) NOT NULL,
    Midterm varchar(10) NOT NULL,
    Final_Project varchar(10) NOT NULL,
    Final_Grade varchar(10) NOT NUll,
    FOREIGN KEY(student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

INSERT INTO students(lastName, firstName, email, phone, class, major)
VALUES
('Doe','John','john.doe@csc350.com','3479998888','CSC350','Computer Science'),
('Smith','Jane','jane.smith@csc350.com',NULL,'CSC350','Computer Science'),
('Max','Koo','koo.max@csc350.com','9292208888','CSC350','Computer Science');

