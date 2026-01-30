<?php
session_start();
include "db.php";

$error = "";
$success = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm  = mysqli_real_escape_string($conn, $_POST['confirm']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']); // new

    // Validate role
    if(!in_array($role, ['customer','employee','admin'])){
        $error = "Invalid role selected!";
    }
    // Check password match
    elseif ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            // Insert new user with role
            $insert = mysqli_query($conn, "INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$hashed_password','$role')");
            if ($insert) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";

                // If role is employee, also insert into employees table
                if($role == 'employee'){
                    $user_id = mysqli_insert_id($conn);
                    mysqli_query($conn, "INSERT INTO employees (user_id) VALUES ('$user_id')");
                }
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>SnapEats — Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; background: #fff8f6; }
.card { border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,0.1); }
.btn-register { background-color:#ff5733; color:#fff; font-weight:600; border-radius:8px; padding:10px 20px; }
.btn-register:hover { background-color:#ff6b6b; color:#fff; }
</style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card p-4" style="width:400px;">
        <div class="text-center mb-3">
            <img src="https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=100&q=80" class="login-logo mb-3" alt="SnapEats Logo">
        </div>
        <h3 class="mb-3 text-center" style="color:#ff5733;">Register</h3>
        
        <?php if($error) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        
        <?php if($success) { ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Select Role --</option>
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-register w-100">Register</button>
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
