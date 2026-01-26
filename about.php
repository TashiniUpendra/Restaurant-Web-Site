<?php
// about.php
session_start();
include "db.php"; // include database connection if needed

// Check if user is logged in (optional)
$user_logged_in = isset($_SESSION['user_id']);
$user_name = $user_logged_in ? $_SESSION['name'] : '';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>About Us — SnapEats</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Custom Page Style -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(180deg, #fff8f6, #ffe7e0);
      color: #333;
      overflow-x: hidden;
    }

    .navbar-brand {
      font-size: 28px;
      font-weight: 700;
      color: #ff5733 !important;
    }

    /* Card */
    .about-card {
      background: #ffffff;
      border-radius: 18px;
      padding: 30px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      animation: fadeIn 1.2s ease;
      border-left: 6px solid #ff5733;
    }

    h2, h4 {
      color: #ff5733;
      font-weight: 600;
      animation: slideUp 1s ease;
    }

    .lead {
      animation: fadeIn 1.3s ease;
    }

    ul li {
      margin-bottom: 8px;
      font-size: 15px;
    }

    .about-img {
      border-radius: 18px;
      width: 100%;
      object-fit: cover;
      box-shadow: 0 12px 28px rgba(0,0,0,0.15);
      animation: fadeIn 1.4s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .btn-outline-primary {
      border-color: #ff5733;
      color: #ff5733;
      font-weight: 500;
      border-radius: 25px;
      padding: 8px 18px;
    }
    .btn-outline-primary:hover {
      background: #ff5733;
      color: white;
    }

    .nav-link { font-weight: 500; color: #444 !important; }
    .btn-login { background-color: #ff5733; color:#fff; border-radius:8px; padding:6px 16px; font-weight:600; }
    .btn-login:hover { background-color:#ff6b6b; color:#fff; }
  </style>

</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light px-4">
    <a class="navbar-brand" href="index.php">SnapEats</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
        <?php if($user_logged_in): ?>
          <li class="nav-item"><a class="nav-link" href="employee_dashboard.php">Employee</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin</a></li>
          <li class="nav-item ms-2"><a class="btn btn-login btn-sm" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item ms-2"><a class="btn btn-login btn-sm" href="login.php">Login</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
      </ul>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container py-5">
    <div class="row g-4">
      <!-- TEXT CONTENT -->
      <div class="col-lg-7">
        <div class="about-card">
          <h2>About SnapEats</h2>
          <p class="lead">
            SnapEats is a modern online food ordering & billing platform built to provide
            <strong>fast, fresh, and premium-quality meals</strong> with ultimate convenience.
          </p>

          <h4 class="mt-4">Our Mission</h4>
          <p>
            To deliver high-quality meals quickly while giving customers a smooth,
            enjoyable, and time-saving online ordering experience.
          </p>

          <h4 class="mt-4">Why Choose SnapEats?</h4>
          <ul>
            <li>⚡ Fast & convenient online ordering</li>
            <li>👨‍🍳 Chef-made premium meals</li>
            <li>💳 Accurate digital billing system</li>
            <li>⏱️ Pick-up exactly when your food is ready</li>
            <li>📱 Fully responsive & modern interface</li>
          </ul>

          <h4 class="mt-4">Contact Us</h4>
          <p>
            📧 Email: support@snapeats.com <br>
            📞 Phone: +94 77 123 4567
          </p>

          <a href="index.php" class="btn btn-outline-primary mt-3">Back to Home</a>
        </div>
      </div>

      <!-- IMAGE -->
      <div class="col-lg-5">
        <img 
          src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=900&q=70"
          class="about-img"
          alt="Restaurant Interior">
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
