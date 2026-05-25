<?php
include 'attendance_connection.php';

$student_id = $_GET['id'];
$status = $_GET['status'];
$date = date("Y-m-d");

// check if exists today
$check = $conn->query("
    SELECT * FROM attendance
    WHERE student_id='$student_id'
    AND attendance_date='$date'
");

if ($check->num_rows > 0) {

    $conn->query("
        UPDATE attendance
        SET status='$status'
        WHERE student_id='$student_id'
        AND attendance_date='$date'
    ");
} else {

    $conn->query("
        INSERT INTO attendance (student_id, status, attendance_date)
        VALUES ('$student_id', '$status', '$date')
    ");
}

header("Location: display.php");
