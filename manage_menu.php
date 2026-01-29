<?php
session_start();
include "db.php";

// Only admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Delete menu
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM menu WHERE id='$id'");
    header("Location: manage_menu.php");
    exit();
}

// Fetch menu items
$menu_items = mysqli_query($conn, "SELECT menu.*, categories.category_name 
                                   FROM menu 
                                   LEFT JOIN categories ON menu.category_id = categories.id 
                                   ORDER BY menu.id DESC");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Menu — SnapEats Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* BODY & BACKGROUND */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff9800, #ff5722);
    min-height: 100vh;
    padding: 20px;
}

/* CONTAINER CARD */
.container {
    background: #fff3e0;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.25);
}

/* HEADINGS */
h3 {
    color: #ff5722;
    font-weight: 700;
    margin-bottom: 25px;
    text-align: center;
}

/* ADD BUTTON */
.btn-success {
    background: #ff9800;
    border: none;
    font-weight: 600;
    margin-bottom: 15px;
}
.btn-success:hover {
    background: #ff5722;
}

/* TABLE */
.table {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
}
.table thead th {
    background: #ff9800;
    color: #fff;
    font-weight: 600;
}
.table tbody tr:hover {
    background: #fff2e6;
}

/* ACTION BUTTONS */
.btn-edit, .btn-delete {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.9rem;
    transition: 0.3s;
}
.btn-edit {
    background: #ff5722;
    color: #fff;
    border: none;
}
.btn-edit:hover {
    background: #e64a19;
}
.btn-delete {
    background: #ff4d4d;
    color: #fff;
    border: none;
}
.btn-delete:hover {
    background: #e53935;
}
</style>
</head>
<body>

<div class="container mt-4">
    <h3>Manage Menu</h3>
    <a href="add_menu.php" class="btn btn-success">+ Add Menu Item</a>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (LKR)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($menu_items)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><?php echo number_format($row['price'],2); ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <a href="edit_menu.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="manage_menu.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
                <?php if(mysqli_num_rows($menu_items) == 0){ ?>
                <tr>
                    <td colspan="6">No menu items found.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
