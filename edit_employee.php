<?php
session_start();
include "db.php";

// Only admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Get employee ID
if(!isset($_GET['id'])){
    header("Location: manage_employees.php");
    exit();
}

$employee_id = intval($_GET['id']);
$error = "";
$success = "";

// Fetch employee info
$emp_res = mysqli_query($conn, "
    SELECT e.id AS emp_id, e.position, e.salary, u.id AS user_id, u.name, u.email 
    FROM employees e
    JOIN users u ON e.user_id = u.id
    WHERE e.id = $employee_id
");
if(mysqli_num_rows($emp_res) == 0){
    die("Employee not found!");
}
$emp = mysqli_fetch_assoc($emp_res);

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $salary = floatval($_POST['salary']);

    if(empty($name) || empty($email) || empty($position) || $salary <= 0){
        $error = "Please fill all required fields correctly.";
    } else {
        // Check if email exists for another user
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND id != ".$emp['user_id']);
        if(mysqli_num_rows($check) > 0){
            $error = "Email already exists for another user!";
        } else {
            // Update users table
            if(!empty($password)){
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user_sql = "UPDATE users SET name='$name', email='$email', password='$hashed_password' WHERE id=".$emp['user_id'];
            } else {
                $user_sql = "UPDATE users SET name='$name', email='$email' WHERE id=".$emp['user_id'];
            }
            mysqli_query($conn, $user_sql);

            // Update employees table
            $emp_sql = "UPDATE employees SET position='$position', salary='$salary' WHERE id=".$emp['emp_id'];
            mysqli_query($conn, $emp_sql);

            $success = "Employee updated successfully!";
            // Refresh data
            $emp_res = mysqli_query($conn, "
                SELECT e.id AS emp_id, e.position, e.salary, u.id AS user_id, u.name, u.email 
                FROM employees e
                JOIN users u ON e.user_id = u.id
                WHERE e.id = $employee_id
            ");
            $emp = mysqli_fetch_assoc($emp_res);
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Employee — SnapEats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff9800, #ff5722);
    min-height: 100vh;
    padding-bottom: 50px;
}
.container {
    margin-top: 50px;
}
h3 {
    color: #fff;
    margin-bottom: 20px;
}
.card {
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    background: #fff;
    padding: 30px;
}
label { font-weight: 600; }
.btn-submit {
    background:#2e7d32;
    color:#fff;
    border:none;
}
.btn-submit:hover { background:#4caf50; }
.btn-back {
    background:#ff5733;
    color:#fff;
    border:none;
}
.btn-back:hover { background:#ff7961; }
.alert-success { background:#2e7d32; color:#fff; }
.alert-danger { background:#ff4d4d; color:#fff; }
</style>
</head>
<body>

<div class="container">
    <h3>Edit Employee</h3>

    <div class="card">

        <?php if($error){ echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <?php if($success){ echo "<div class='alert alert-success'>$success</div>"; } ?>

        <form method="post">
            <div class="mb-3">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($emp['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($emp['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password">Password (leave blank to keep current)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="position">Position</label>
                <input type="text" name="position" id="position" class="form-control" value="<?php echo htmlspecialchars($emp['position']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="salary">Salary (LKR)</label>
                <input type="number" name="salary" id="salary" class="form-control" step="0.01" value="<?php echo $emp['salary']; ?>" required>
            </div>

            <button type="submit" class="btn btn-submit">Update Employee</button>
            <a href="manage_employees.php" class="btn btn-back">Back</a>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
