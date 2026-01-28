<?php
include "db.php";

// Fetch latest 3 featured dishes
$featured = mysqli_query($conn, "SELECT * FROM menu WHERE status='available' ORDER BY id DESC LIMIT 3");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>SnapEats — Home</title>
<meta name="viewport" content="width=device-width,initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; background: linear-gradient(180deg, #fff8f6, #ffe7e0); color:#333; }
.navbar-brand { font-size:28px; font-weight:700; color:#ff5733 !important; }
.nav-link { font-weight:500; color:#444 !important; }
.hero { background: linear-gradient(135deg, #ffe0d6, #fff); border-radius:18px; box-shadow:0 10px 25px rgba(0,0,0,0.1); margin-top:20px; }
.food-card { border-radius:16px; overflow:hidden; box-shadow:0 8px 18px rgba(0,0,0,0.08); transition:0.3s; background:#fff; }
.food-card:hover { transform: translateY(-8px); }
.food-card img { height:200px; width:100%; object-fit:cover; }
.food-title { color:#ff5733; font-weight:600; }
.section-title { font-weight:700; margin-bottom:20px; }
.hero-title {
    font-size: 48px; /* increase font size */
    color: #ff5733;  /* change color to match your theme */
    font-weight: 800; /* optional: make it bold */
}
.btn-order {
    background: linear-gradient(45deg, #ff6b6b, #ff5733); /* gradient color */
    color: #fff;
    font-weight: 700;
    border-radius: 12px;
    padding: 12px 28px;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(255,87,51,0.4);
}

.btn-order:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255,87,51,0.5);
    text-decoration: none;
    color: #fff;
}
.btn-login {
    background-color: #ff5733;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 6px 16px;
    transition: 0.3s;
}

.btn-login:hover {
    background-color: #ff6b6b;
    color: #fff;
    transform: translateY(-2px);
}

</style>
</head>
<body>

<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light px-4">
  <a class="navbar-brand" href="index.php">SnapEats</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="login.php">Menu</a></li>
      <li class="nav-item"><a class="nav-link" href="login.php">Employee</a></li>
      <li class="nav-item"><a class="nav-link" href="login.php">Admin</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li> <!-- Added About Us -->
      <li class="nav-item ms-2">
        <a class="btn btn-primary btn-sm" href="login.php">Login</a>
      </li>
    </ul>
  </div>
</nav>


<!-- Hero Section -->
<div class="container mt-4">
  <div class="hero p-4">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h1 class="hero-title">Fresh Food. Luxury Dining.</h1>

        <p class="text-muted">Chef-crafted meals delivered fresh & fast. Order online and enjoy the taste!</p>
      <a href="login.php" class="btn btn-order btn-lg"><i class="bi bi-bag-plus"></i> Order Now</a>
    </div>
      <div class="col-md-5 text-center">
        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded shadow" alt="Hero Food">
      </div>
    </div>
  </div>

  <!-- Featured Dishes -->
  <div class="mt-5">
    <h3 class="section-title">Featured Dishes</h3>
    <div class="row g-4">
      <?php while($row = mysqli_fetch_assoc($featured)) { 
        $img_url = !empty($row['image']) ? $row['image'] : 'https://via.placeholder.com/400x300.png?text=Food';
      ?>
      <div class="col-md-4">
        <div class="food-card">
          <img src="<?php echo $img_url; ?>" alt="<?php echo $row['name']; ?>">
          <div class="p-3">
            <h5 class="food-title"><?php echo $row['name']; ?></h5>
            <p class="small text-muted"><?php echo $row['description']; ?></p>
            <strong>LKR <?php echo number_format($row['price'],2); ?></strong>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="text-center mt-5 p-3">
  <small>© 2025 SnapEats — Online Food Ordering & Billing System</small>
</footer>

</body>
</html>
