<?php
include 'attendance_connection.php';

$id = $_GET['id'];
$date = $_GET['date'];

$result = $conn->query("
    SELECT * FROM attendance_tbl.attendance
    WHERE student_id='$id' AND attendance_date='$date'
");

if (!$result || $result->num_rows == 0) {
    die("Attendance record not found.");
}

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $status = $_POST['status'];
    $new_date = $_POST['attendance_date'];

    $conn->query("
        UPDATE attendance_tbl.attendance
        SET status='$status',
            attendance_date='$new_date'
        WHERE student_id='$id' AND attendance_date='$date'
    ");

    header("Location: attendance_record.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0">Edit Attendance</h4>
                    </div>

                    <div class="card-body p-4">

                        <form method="post">

                            <!-- STATUS -->
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select mb-3">
                                <option value="Present" <?php if ($row['status'] == "Present") echo "selected"; ?>>Present</option>
                                <option value="Absent" <?php if ($row['status'] == "Absent") echo "selected"; ?>>Absent</option>
                                <option value="Late" <?php if ($row['status'] == "Late") echo "selected"; ?>>Late</option>
                            </select>

                            <!-- DATE -->
                            <label class="form-label fw-bold">Attendance Date</label>
                            <input type="date"
                                name="attendance_date"
                                value="<?php echo $row['attendance_date']; ?>"
                                class="form-control mb-4">

                            <button type="submit"
                                name="update"
                                class="btn btn-success w-100 py-2 fw-bold">
                                Update Attendance
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>