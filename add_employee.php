<?php
session_start();
include "db.php";

// Only admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $salary = floatval($_POST['salary']);

    if(empty($name) || empty($email) || empty($password) || empty($position) || $salary <= 0){
        $error = "Please fill all required fields correctly.";
    } else {
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "Email already exists!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into users table
            $insert_user_sql = "
                INSERT INTO users (name, email, password, role, status)
                VALUES ('$name','$email','$hashed_password','employee','active')
            ";
            $insert_user = mysqli_query($conn, $insert_user_sql);

            if(!$insert_user){
                die("User creation failed: " . mysqli_error($conn));
            }

            $user_id = mysqli_insert_id($conn);

            // Insert into employees table
            $insert_emp_sql = "
                INSERT INTO employees (user_id, position, salary)
                VALUES ('$user_id','$position','$salary')
            ";
            $insert_emp = mysqli_query($conn, $insert_emp_sql);

            if(!$insert_emp){
                die("Employee creation failed: " . mysqli_error($conn));
            }

            $success = "Employee added successfully!";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Employee — SnapEats</title>
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
    <h3>Add Employee</h3>

    <div class="card">

        <?php if($error){ echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <?php if($success){ echo "<div class='alert alert-success'>$success</div>"; } ?>

        <form method="post">
            <div class="mb-3">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="position">Position</label>
                <input type="text" name="position" id="position" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="salary">Salary (LKR)</label>
                <input type="number" name="salary" id="salary" class="form-control" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-submit">Add Employee</button>
            <a href="manage_employees.php" class="btn btn-back">Back</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
