<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT * FROM categories WHERE status='active'");

$error = "";
$success = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $status = $_POST['status'];
    $image = $_POST['image'];

    $insert = mysqli_query($conn, "INSERT INTO menu (category_id,name,description,price,status,image)
                                   VALUES ('$category_id','$name','$description','$price','$status','$image')");
    if($insert){
        $success = "Menu item added successfully!";
    } else {
        $error = "Error: ".mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Menu Item — SnapEats Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* BODY & BACKGROUND */
body {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #ff9800, #ff5722);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* CARD CONTAINER */
.container {
    background: #fff3e0;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.25);
    max-width: 600px;
    width: 100%;
}

/* HEADINGS */
h3 {
    color: #ff5722;
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
}

/* ALERTS */
.alert {
    border-radius: 12px;
    font-weight: 500;
}

/* FORM LABELS */
.form-label, label {
    font-weight: 500;
}

/* INPUTS */
.form-control, .form-select, textarea {
    border-radius: 10px;
    padding: 12px;
    font-size: 1rem;
}

/* BUTTON */
.btn-success {
    background: #ff9800;
    border: none;
    font-weight: 600;
    padding: 12px 25px;
    font-size: 1rem;
    transition: 0.3s;
}
.btn-success:hover {
    background: #ff5722;
}
</style>
</head>
<body>
<div class="container">
    <h3>Add Menu Item</h3>

    <?php if($error){ echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <?php if($success){ echo "<div class='alert alert-success'>$success</div>"; } ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                <?php while($cat = mysqli_fetch_assoc($categories)){ ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Image URL</label>
            <input type="text" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">Add Menu Item</button>
        </div>
    </form>
</div>
</body>
</html>
