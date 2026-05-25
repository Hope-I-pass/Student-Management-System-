<?php

$conn = new mysqli("localhost", "root", "", "attendance_tbl");

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
