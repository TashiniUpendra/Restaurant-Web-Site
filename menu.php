<?php
session_start();
include "db.php";

// Fetch all available menu items
$menu_items = mysqli_query($conn, "SELECT * FROM menu WHERE status='available' ORDER BY category_id ASC, id ASC");

// Check login status
$user_logged_in = isset($_SESSION['user_id']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>SnapEats — Menu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; background: linear-gradient(180deg, #fff8f6, #ffe7e0); color:#333; }
.navbar-brand { font-size:28px; font-weight:700; color:#ff5733 !important; }
.nav-link { font-weight:500; color:#444 !important; }
.food-card { border-radius:16px; overflow:hidden; box-shadow:0 8px 18px rgba(0,0,0,0.08); transition:0.3s; background:#fff; }
.food-card:hover { transform: translateY(-8px); }
.food-card img { height:200px; width:100%; object-fit:cover; }
.food-title { color:#ff5733; font-weight:600; }
.section-title { font-weight:700; margin-bottom:20px; }
.btn-add { background-color:#ff5733; color:#fff; font-weight:600; border-radius:8px; padding:6px 16px; transition:0.3s; }
.btn-add:hover { background-color:#ff6b6b; color:#fff; transform: translateY(-2px); }
.btn-login { background-color: #ff5733; color:#fff; font-weight:600; border-radius:8px; padding:6px 16px; }
.btn-login:hover { background-color:#ff6b6b; color:#fff; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light px-4">
  <a class="navbar-brand" href="index.php">SnapEats</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
      <li class="nav-item"><a class="nav-link" href="employee_dashboard.php">Employee</a></li>
      <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin</a></li>
      <?php if($user_logged_in): ?>
        <li class="nav-item ms-2"><a class="btn btn-login btn-sm" href="logout.php">Logout</a></li>
      <?php else: ?>
        <li class="nav-item ms-2"><a class="btn btn-login btn-sm" href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="section-title">Our Menu</h3>
  <div class="row g-4">
    <?php 
    if(mysqli_num_rows($menu_items) > 0) {
        while($row = mysqli_fetch_assoc($menu_items)) { 
            $img_url = !empty($row['image']) ? $row['image'] : 'https://via.placeholder.com/400x300.png?text=Food';
    ?>
    <div class="col-md-4">
      <div class="food-card">
        <img src="<?php echo $img_url; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <div class="p-3">
          <h5 class="food-title"><?php echo htmlspecialchars($row['name']); ?></h5>
          <p class="small text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
          <strong>LKR <?php echo number_format($row['price'],2); ?></strong>
          <div class="mt-2">
            <form method="post" action="confirm_order.php">
              <input type="hidden" name="menu_id" value="<?php echo $row['id']; ?>">
              <input type="number" name="quantity" value="1" min="1" style="width:60px;">
              <button type="submit" class="btn btn-add btn-sm">Order Now</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php 
        }
    } else { ?>
      <p class="text-muted">No menu items available at the moment.</p>
    <?php } ?>
  </div>
</div>

<!-- Footer -->
<footer class="text-center mt-5 p-3">
  <small>© 2025 SnapEats — Online Food Ordering & Billing System</small>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
