<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$employees = mysqli_query($conn,"SELECT employees.*, users.name, users.email FROM employees 
                                 JOIN users ON employees.user_id = users.id");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Employees — SnapEats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff9800, #ff5722);
    min-height: 100vh;
    padding-bottom: 50px;
}
.container {
    margin-top: 40px;
}
h3 {
    color: #fff;
    margin-bottom: 20px;
}

/* Card wrapper */
.card {
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    background: #fff;
    padding: 25px;
}

/* Table styles */
.table {
    margin-top: 20px;
}
.table thead {
    background: #ff9800;
    color: #fff;
    font-weight: 600;
}
.table tbody tr:hover {
    background: #fff3e0;
}
.table td, .table th {
    vertical-align: middle;
}

/* Buttons */
.btn-edit {
    background:#ff9800;
    color:#fff;
    border:none;
}
.btn-edit:hover { background:#ffb74d; }
.btn-delete {
    background:#ff4d4d;
    color:#fff;
    border:none;
}
.btn-delete:hover { background:#ff7961; }
.btn-add {
    background:#2e7d32;
    color:#fff;
    border:none;
}
.btn-add:hover { background:#4caf50; }

</style>
</head>
<body>

<div class="container">
    <h3>Manage Employees</h3>

    <div class="card">
        <a href="add_employee.php" class="btn btn-add mb-3"><i class="bi bi-plus-circle"></i> Add Employee</a>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Salary (LKR)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($e=mysqli_fetch_assoc($employees)){ ?>
                    <tr>
                        <td><?php echo $e['id']; ?></td>
                        <td><?php echo htmlspecialchars($e['name']); ?></td>
                        <td><?php echo htmlspecialchars($e['email']); ?></td>
                        <td><?php echo htmlspecialchars($e['position']); ?></td>
                        <td><?php echo number_format($e['salary'],2); ?></td>
                        <td>
                            <a href="edit_employee.php?id=<?php echo $e['id']; ?>" class="btn btn-edit btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            <a href="delete_employee.php?id=<?php echo $e['id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
