<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if($password !== $confirm){
        $error = "Passwords do not match!";
    } else {
        $hashed = password_hash($password,PASSWORD_DEFAULT);
        $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check)>0){
            $error = "Email already exists!";
        } else {
            $insert = mysqli_query($conn,"INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$hashed','admin')");
            if($insert){ $success="Admin added successfully!"; } 
            else { $error = "Error: ".mysqli_error($conn); }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Admin — SnapEats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg, #ff9800, #ff5722);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.card {
    max-width: 500px;
    width: 100%;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    padding: 30px;
}
h3 {
    color: #ff5733;
    text-align: center;
    margin-bottom: 25px;
}
label {
    font-weight: 600;
}
.btn-submit {
    background: #2e7d32;
    color: #fff;
    border: none;
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
}
.btn-submit:hover { background: #4caf50; }
.alert-success { background:#2e7d32; color:#fff; }
.alert-danger { background:#ff4d4d; color:#fff; }
</style>
</head>
<body>

<div class="card">
    <h3>Add Admin</h3>

    <?php if($error){ echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <?php if($success){ echo "<div class='alert alert-success'>$success</div>"; } ?>

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

        <button type="submit" class="btn btn-submit">Add Admin</button>
    </form>
</div>

</body>
</html>
