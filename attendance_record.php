<?php
include 'connection.php';

/* FILTERS */
$filterDate = $_GET['filter_date'] ?? "";
$filterStatus = $_GET['filter_status'] ?? "";

/* WHERE CONDITIONS */
$where = [];

if (!empty($filterDate)) {
    $where[] = "attendance_tbl.attendance.attendance_date = '$filterDate'";
}

if (!empty($filterStatus)) {
    $where[] = "attendance_tbl.attendance.status = '$filterStatus'";
}

$whereSQL = "";

if (count($where) > 0) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

/* QUERY */
$sql = "
SELECT 
    studentdb.stutbl.id_num,
    studentdb.stutbl.lastname,
    studentdb.stutbl.firstname,
    studentdb.stutbl.course,
    attendance_tbl.attendance.student_id,
    attendance_tbl.attendance.status,
    attendance_tbl.attendance.attendance_date

FROM attendance_tbl.attendance

JOIN studentdb.stutbl 
ON studentdb.stutbl.num = attendance_tbl.attendance.student_id

$whereSQL

ORDER BY attendance_tbl.attendance.attendance_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Attendance Records</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">

        <div class="card shadow-lg border-0">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Attendance Records</h3>
            </div>

            <div class="card-body">

                <!-- FILTER FORM -->
                <form method="GET" class="row mb-4">

                    <!-- DATE FILTER -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Filter by Date
                        </label>

                        <input type="date"
                            name="filter_date"
                            class="form-control"
                            value="<?php echo $filterDate; ?>">
                    </div>

                    <!-- STATUS FILTER -->
                    <div class="col-md-4">

                        <label class="form-label fw-bold">
                            Filter by Status
                        </label>

                        <select name="filter_status" class="form-select">

                            <option value="">All Status</option>

                            <option value="Present"
                                <?php if ($filterStatus == "Present") echo "selected"; ?>>
                                Present
                            </option>

                            <option value="Absent"
                                <?php if ($filterStatus == "Absent") echo "selected"; ?>>
                                Absent
                            </option>

                            <option value="Late"
                                <?php if ($filterStatus == "Late") echo "selected"; ?>>
                                Late
                            </option>

                        </select>

                    </div>

                    <!-- BUTTONS -->
                    <div class="col-md-4 d-flex align-items-end">

                        <button type="submit" class="btn btn-primary me-2">
                            Filter
                        </button>

                        <a href="attendance_record2.php" class="btn btn-secondary">
                            Reset
                        </a>

                    </div>

                </form>

                <!-- TABLE -->
                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Operation</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if ($result->num_rows > 0) { ?>

                            <?php while ($row = $result->fetch_assoc()) { ?>

                                <tr>

                                    <td><?php echo $row['id_num']; ?></td>

                                    <td>
                                        <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                    </td>

                                    <td><?php echo $row['course']; ?></td>

                                    <td>

                                        <?php
                                        if ($row['status'] == "Present") {
                                            echo "<span class='badge bg-success'>Present</span>";
                                        } elseif ($row['status'] == "Absent") {
                                            echo "<span class='badge bg-danger'>Absent</span>";
                                        } else {
                                            echo "<span class='badge bg-warning text-dark'>Late</span>";
                                        }
                                        ?>

                                    </td>

                                    <td><?php echo $row['attendance_date']; ?></td>

                                    <td class="text-center">

                                        <a href="attendance_edit.php?id=<?php echo $row['student_id']; ?>&date=<?php echo $row['attendance_date']; ?>"
                                            class="btn btn-sm btn-primary px-3">

                                            Edit

                                        </a>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No attendance records found
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>