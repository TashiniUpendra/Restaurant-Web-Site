<?php
session_start();
include "db.php";

// Check if cart is empty
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "<script>alert('Your cart is empty.'); window.location='menu.php';</script>";
    exit();
}

// Default user (replace with logged-in user ID later)
$user_id = 1;  

// Calculate total amount
$total_amount = 0;
foreach($_SESSION['cart'] as $menu_id => $qty){
    $menu_id = intval($menu_id);
    $result = mysqli_query($conn, "SELECT price FROM menu WHERE id='$menu_id'");
    $item = mysqli_fetch_assoc($result);
    $total_amount += $item['price'] * $qty;
}

// Handle payment form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method'])){
    $payment_method = $_POST['payment_method'];

    // Insert into orders
    $order_sql = "INSERT INTO orders (user_id, total_amount, order_status) VALUES ('$user_id', '$total_amount', 'pending')";
    if(mysqli_query($conn, $order_sql)){
        $order_id = mysqli_insert_id($conn);

        // Insert each cart item into order_items
        foreach($_SESSION['cart'] as $menu_id => $qty){
            $menu_id = intval($menu_id);
            $result = mysqli_query($conn, "SELECT price FROM menu WHERE id='$menu_id'");
            $item = mysqli_fetch_assoc($result);
            $price = $item['price'];

            mysqli_query($conn, "INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES ('$order_id','$menu_id','$qty','$price')");
        }

        // Insert into payments
        mysqli_query($conn, "INSERT INTO payments (order_id, payment_method, payment_status) VALUES ('$order_id','$payment_method','paid')");

        // Clear cart
        $_SESSION['cart'] = [];

        // Redirect to thank you page
        header("Location: order_success.php?order_id=$order_id");
        exit();

    } else {
        die("Error placing order: " . mysqli_error($conn));
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Checkout — SnapEats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* BODY AND BACKGROUND */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff9800, #ff5722);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* CONTAINER CARD */
.checkout-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 30px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 15px 50px rgba(0,0,0,0.25);
}

/* HEADER */
.checkout-card h3 {
    color: #ff5733;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

/* TOTAL AMOUNT */
.total-amount {
    background: #fff3e0;
    color: #ff5722;
    font-weight: 700;
    font-size: 1.5rem;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* FORM STYLING */
.form-label {
    font-weight: 500;
}
.form-select {
    border-radius: 10px;
    padding: 12px;
    font-size: 1rem;
}

/* BUTTONS */
.btn-success {
    background: #ff9800;
    border: none;
    font-weight: 600;
    transition: 0.3s;
}
.btn-success:hover {
    background: #ff5722;
}
.btn-secondary {
    background: #fff;
    color: #ff5722;
    border: 2px solid #ff5722;
    font-weight: 600;
    transition: 0.3s;
}
.btn-secondary:hover {
    background: #ff5722;
    color: #fff;
    border: none;
}

/* GAP BETWEEN BUTTONS */
.d-grid.gap-2 {
    margin-top: 20px;
}
</style>
</head>

<body>
<div class="checkout-card">
    <h3>Checkout</h3>

    <div class="total-amount">
        Total Amount: LKR <?php echo number_format($total_amount,2); ?>
    </div>

    <form method="post">
        <div class="mb-3">
            <label for="payment" class="form-label">Select Payment Method</label>
            <select class="form-select" name="payment_method" id="payment" required>
                <option value="">-- Choose Payment Method --</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="online">Online</option>
            </select>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Place Order & Pay</button>
            <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
        </div>
    </form>
</div>
</body>
</html>
