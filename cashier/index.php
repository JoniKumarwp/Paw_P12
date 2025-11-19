<?php
// index.php - Simple Cashier System (focus on function & procedure)

session_start();
require_once __DIR__ . '/function.php';

if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = [];

$action = $_GET['action'] ?? null;

// Add item
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 0);

    if ($name === '' || $price <= 0 || $qty <= 0) {
        $_SESSION['flash'] = 'Name, price, and qty must be filled in correctly.';
    }
    elseif($qty > 100){
         $_SESSION['flash'] = 'Quantity Reached maxium!';
    }
    else {
    
        $_SESSION['cart'][] = ['name' => $name, 'price' => $price, 'qty' => $qty];
        $_SESSION['flash'] = 'Item added to cart.';
    }

    header('Location: index.php');
    exit;
}

// Reset cart
if ($action === 'reset') {
    $_SESSION['cart'] = [];
    $_SESSION['flash'] = 'Cart is empty.';
    header('Location: index.php');
    exit;
}

if($action === 'delete' && isset($_GET['index'])){
    $index = (int)$_GET['index'];
    if(isset($_SESSION['cart'][$index])){
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $_SESSION['flash'] = "Delete sucessfully!";
    }
    header('Location:index.php');
    exit;
}



?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Simple Cashier - Function & Procedure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .wrap { max-width: 920px; margin: auto; }
        input[type="text"], input[type="number"] { padding:6px; width: 260px; }
        table { border-collapse: collapse; width: 100%; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .btn { display:inline-block; padding:6px 12px; border:1px solid #333; background:#fff; text-decoration:none; color:#000; cursor:pointer; }
        .row { display:flex; flex-wrap:wrap; gap:16px; align-items:flex-end; }
        .col { display:flex; flex-direction:column; }
    </style>
</head>
<body>
<div class="wrap">
    <h2>Simple Cashier System (PHP Native)</h2>

    <?php 
    if (!empty($_SESSION['flash'])) { 
        print_alert($_SESSION['flash']); 
        $_SESSION['flash'] = null; 
    } 
    ?>

    <form method="post" action="index.php?action=add" class="row">
        <div class="col">
            <label>Name</label>
            <input type="text" name="name" placeholder="e.g.: Bread" required>
        </div>

        <div class="col">
            <label>Price (Rp)</label>
            <input type="number" name="price" min="0" step="1" placeholder="e.g.: 10000" required>
        </div>

        <div class="col">
            <label>Qty</label>
            <input type="number" name="qty" min="1" step="1" value="1" required>
        </div>

        <div class="col">
            <button type="submit" class="btn">Add</button>
        </div>

        <div class="col">
            <a href="index.php?action=reset" class="btn">Reset</a>
        </div>
    </form>

    <h3>Cart</h3>
    <?php render_table_cart($_SESSION['cart']); ?>

    <h3>Summary</h3>
    <?php render_struk($_SESSION['cart']); ?>
</div>
</body>
</html>
