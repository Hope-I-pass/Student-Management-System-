<?php
include 'connection.php';

$selectedCourse = isset($_GET['course']) ? strtoupper(trim($_GET['course'])) : "";
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Page</title>

    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #fff;">

    <button class="logout-btn" onclick="window.location.href='login_page.php'">
        Logout
    </button>

    <div class="container my-5 mx-8 shadow p-3 mb-5 bg-white rounded">

        <h1 class="text-center shadow p-3 mb-5 bg-white rounded">
            Student Management System
        </h1>

        <h5 class="text-center text-muted" style="font-size: 30px; font-weight: bold;">
            Today: <?php echo date("F d, Y (l)"); ?>
        </h5>

        <div class="d-flex justify-content-between mb-3">

            <form method="GET">
                <select name="course" class="form-select" onchange="this.form.submit()">

                    <option value="">All Courses</option>
                    <option value="BSCS" <?php if ($selectedCourse == "BSCS") echo "selected"; ?>>BSCS</option>
                    <option value="ACT" <?php if ($selectedCourse == "ACT") echo "selected"; ?>>ACT</option>
                    <option value="BSHM" <?php if ($selectedCourse == "BSHM") echo "selected"; ?>>BSHM</option>
                    <option value="BSBA" <?php if ($selectedCourse == "BSBA") echo "selected"; ?>>BSBA</option>
                    <option value="BSED" <?php if ($selectedCourse == "BSED") echo "selected"; ?>>BSED</option>

                </select>
            </form>

        </div>

        <table class="table table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>Num</th>
                    <th>Student ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Attendance</th>
                </tr>
            </thead>

            <tbody>

                <?php

                if (!empty($selectedCourse)) {
                    $stmt = $conn->prepare("
                SELECT * FROM stutbl 
                WHERE UPPER(TRIM(course)) = ?
            ");
                    $stmt->bind_param("s", $selectedCourse);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM stutbl");
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    echo "<tr><td colspan='9' class='text-center'>No students found</td></tr>";
                }

                while ($row = $result->fetch_assoc()) {

                    // ✅ MUST be first
                    $stuid = $row['num'];

                    // ✅ Attendance check
                    $today = date("Y-m-d");

                    $attQuery = $conn->query("
                SELECT status 
                FROM attendance_tbl.attendance
                WHERE student_id = '$stuid'
                AND attendance_date = '$today'
            ");

                    $attData = $attQuery->fetch_assoc();
                    $statusToday = $attData['status'] ?? null;

                    // Student data
                    $id_num = $row['id_num'];
                    $lastname = $row['lastname'];
                    $firstname = $row['firstname'];
                    $middlename = $row['middlename'];
                    $email = $row['email'];
                    $course = $row['course'];

                    echo "
            <tr>
                <th>{$stuid}</th>
                <td><strong>{$id_num}</strong></td>
                <td>{$lastname}</td>
                <td>{$firstname}</td>
                <td>{$middlename}</td>
                <td>{$email}</td>
                <td><strong>{$course}</strong></td>

                

                <td>
            ";

                    // Attendance buttons logic
                    if ($statusToday == null) {

                        echo "
                    <a href='attendance.php?id=$stuid&status=Present' class='btn btn-sm btn-success'>Present</a>
                    <a href='attendance.php?id=$stuid&status=Absent' class='btn btn-sm btn-danger'>Absent</a>
                    <a href='attendance.php?id=$stuid&status=Late' class='btn btn-sm btn-warning'>Late</a>
                ";
                    } elseif ($statusToday == "Present") {
                        echo "<span class='badge bg-success'>Present</span>";
                    } elseif ($statusToday == "Absent") {
                        echo "<span class='badge bg-danger'>Absent</span>";
                    } elseif ($statusToday == "Late") {
                        echo "<span class='badge bg-warning text-dark'>Late</span>";
                    }

                    echo "
                <br>
                <a href='attendance_record2.php' class='btn btn-sm btn-info mt-2'>Records</a>
                </td>
            </tr>
            ";
                }

                ?>

            </tbody>

        </table>

    </div>

</body>

</html>