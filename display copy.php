<?php
include 'connection.php';


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Page</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background: #fff;">
    <button class="top-right-btn" onclick="window.location.href='login_page.php'">Logout</button>
    <div class="container my-5 mx-8 shadow p-3 mb-5 bg-white rounded">
        <h1 class=" text-center shadow p-3 mb-5 bg-white rounded">Student Management System</h1>
        <button class="btn btn-primary"><a href="Home.php" class="text-white text-decoration-none">Add Student</a></button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Num. Students</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Middle Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Course</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM stutbl";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $stuid = $row['num'];
                        $id_num = $row['id_num'];
                        $lastname = $row['lastname'];
                        $firstname = $row['firstname'];
                        $middlename = $row['middlename'];
                        $email = $row['email'];
                        $course = $row['course'];
                        echo '  <tr>
                    <th scope="row">' . $stuid . '</th>
                    <td><strong>' . $id_num . '</strong></td>
                    <td>' . $lastname . '</td>
                    <td>' . $firstname . '</td>
                    <td>' . $middlename . '</td>
                    <td>' . $email . '</td>
                    <td><strong>' . $course . '</strong></td>
                    <td>
                    <button class="btn btn-sm btn-primary"><a href="update.php ? updateid=' . $stuid . '" class="text-white text-decoration-none">Update</a></button>
                    <button class="btn btn-sm btn-danger"><a href="delete.php ? deleteid=' . $stuid . '" class="text-white text-decoration-none">Delete</a></button>
                    </td>
                </tr>';
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>