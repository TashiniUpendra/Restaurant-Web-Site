<?php
session_start();
include "db.php";

/* ======================
   CHECK POST DATA
====================== */
if (!isset($_POST['menu_id'], $_POST['quantity'])) {
    die("No item selected");
}

$menu_id  = (int)$_POST['menu_id'];
$quantity = (int)$_POST['quantity'];

if ($quantity <= 0) {
    die("Invalid quantity");
}

/* ======================
   FETCH MENU ITEM
====================== */
$sql = "SELECT name, price FROM menu WHERE id = $menu_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Menu item not found");
}

$item  = mysqli_fetch_assoc($result);
$total = $item['price'] * $quantity;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Confirm Order</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background:linear-gradient(135deg,#ff9800,#ff5722);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}
.order-card{
    width:500px;
    background:#fff;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
    overflow:hidden;
}
.card-body{
    padding:32px;
    text-align:center;
}
.card-title{
    font-size:1.8rem;
    font-weight:600;
    margin-bottom:20px;
}
.price{
    font-size:1.5rem;
    font-weight:bold;
    color:#2e7d32;
    margin-bottom:20px;
}
.btn{
    padding:12px;
    font-size:1.1rem;
}
</style>
</head>

<body>

<div class="card order-card">
    <div class="card-body">
        <h4 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h4>

        <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>
        <p class="price">Total: LKR <?php echo number_format($total,2); ?></p>

        <form method="post" action="cart.php" class="d-grid gap-3">
            <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
            <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">

            <button class="btn btn-success">✔ Confirm & Add to Cart</button>
            <a href="menu.php" class="btn btn-outline-dark">✖ Cancel</a>
        </form>
    </div>
</div>

</body>
</html>
