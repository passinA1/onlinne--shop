<?php
// Initialize shopping cart class
include_once 'Cart_function.php';
$cart = new CartFunction;

// Include the database config file
require_once 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
    <meta charset="utf-8">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/indexStyle.css" rel="stylesheet" media="all">

</head>
</head>
<body>

<div class="topbar">
    <div class="wrapper">
        <a href="index.php" class="logo"></a>
        <div class="nav">
            <ul class="parent">
                <li class="current">
                    <a href="index.php">HOME</a>
                    <span class="lines"></span></li>
                <li class="current"><a href="cart.php">SHOPPING CART</a>
                    <span class="lines"></span></li>
            </ul>

            <ul class="userul">
                <?php if (!empty($_SESSION['user'])) { ?>
                    <li class="userInfo">Welcome, <?php echo $_SESSION['user']; ?></li>
                    <li class="userInfo"><a href="logout.php">Login Out</a></li>

                <?php } else { ?>
                    <li class="userInfo"><a href="login.php">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>


<div class="container">
    <h1>PRODUCTS</h1>

    <!-- Cart basket -->
    <div class="cart-view">
        <a href="viewCart.php" title="View Cart"><i class="icart"></i>
            (<?php echo ($cart->total_items() > 0) ? $cart->total_items() . ' Items' : 'Empty'; ?>)</a>
    </div>

    <!-- Product list -->
    <div class="row col-lg-12">
        <?php
        // Get products from database
        $result = $db->query("SELECT * FROM products ORDER BY product_id DESC LIMIT 10");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card col-lg-4">
                    <div class="card-body">
                        <img
                        <h5 class="card-title"><?php echo $row["product_name"]; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Price: <?php echo '$' . $row["price"] . ' USD'; ?></h6>
                        <p class="card-text"><?php echo $row["description"]; ?></p>
                        <a href="cartAction.php?action=addToCart&id=<?php echo $row["product_id"]; ?>"
                           class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>Product(s) not found.....</p>
        <?php } ?>
    </div>
</div>
</body>
</html>