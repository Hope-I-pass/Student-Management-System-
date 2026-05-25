<?php
$conn = new mysqli("localhost", "root", "", "studentdb");
if (!$conn) {
    // echo "Database connected successfully";
    die(mysqli_error($conn));
}
