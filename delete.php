<?php
include 'connection.php';
if (isset($_GET['deleteid'])) {
    $stuid = $_GET['deleteid'];
    $sql = "DELETE FROM stutbl WHERE num = $stuid";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Deleted successfully";
        header('location:display.php');
    }
}
