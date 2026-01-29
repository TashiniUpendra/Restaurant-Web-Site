<?php
include "db.php";

if(!isset($_GET['order_id'])){
    header("Location: menu.php");
    exit();
}

$order_id = intval($_GET['order_id']);

// Get order details
$order_res = mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id'");
$order = mysqli_fetch_assoc($order_res);

// Get payment method
$payment_res = mysqli_query($conn, "SELECT payment_method FROM payments WHERE order_id='$order_id'");
$payment = mysqli_fetch_assoc($payment_res);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Order Success — SnapEats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg,#ff9800,#ff5722);
    padding: 20px;
}

.card {
    max-width: 500px;
    width: 100%;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.25);
    background: #fff;
    text-align: center;
}

h2 {
    color: #28a745;
    font-weight: 700;
    margin-bottom: 20px;
}

.order-info p {
    font-size: 1.1rem;
    margin: 10px 0;
}

.order-info strong {
    color: #ff5722;
}

.btn-primary {
    background: #ff9800;
    border: none;
    font-weight: 600;
    padding: 12px 25px;
    font-size: 1rem;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #ff5722;
    color: #fff;
}

</style>
</head>

<body>

<div class="card">
    <h2>✔ Thank You!</h2>
    <p style="font-size:1.2rem;">Your order has been successfully placed.</p>

    <div class="order-info mt-4">
        <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
        <p><strong>Total Amount:</strong> LKR <?php echo number_format($order['total_amount'],2); ?></p>
        <p><strong>Payment Method:</strong> <?php echo ucfirst($payment['payment_method']); ?></p>
    </div>

    <a href="menu.php" class="btn btn-primary mt-4">Back to Menu</a>
</div>

</body>
</html>
