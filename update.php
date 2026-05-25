<?php
include 'connection.php';
$stuid = $_GET['updateid'];
$sql = "SELECT * FROM stutbl WHERE num=$stuid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id_num = $row['id_num'];
$lastname = $row['lastname'];
$firstname = $row['firstname'];
$middlename = $row['middlename'];
$email = $row['email'];
$course = $row['course'];


if (isset($_POST['btn'])) {
    $id_n = $_POST['id_n'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $sql = "update stutbl set num= $stuid, id_num='$id_n', lastname='$last_name', firstname='$first_name', middlename='$middle_name', email='$email', course='$course' where num=$stuid";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // echo "Data inserted successfully";
        header('location:display.php');
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">ID Number</label>
                <input type="text" name="id_n" class="form-control" placeholder="Enter the ID Number" autocomplete="off" value="<?php echo $id_num; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter the Last Name" autocomplete="off" value="<?php echo $lastname; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="Enter the First Name" autocomplete="off" value="<?php echo $firstname; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" placeholder="Enter the Middle Name" autocomplete="off" value="<?php echo $middlename; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter the Email" autocomplete="off" value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Course</label>

                <select name="course" class="form-select" required>

                    <option value="">-- Select Course --</option>

                    <option value="BSCS">Bachelor of Science in Computer Science</option>
                    <option value="BSED">Bachelor of Secondary Education</option>
                    <option value="ACT">Associate in Computer Technology</option>
                    <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                    <option value="BSBA">Bachelor of Science in Business Administration</option>

                </select>
            </div>
            <button type="submit" name="btn" class="btn btn-primary">Update</button>
        </form>

    </div>

</body>

</html>