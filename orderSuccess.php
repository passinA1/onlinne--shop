<?php
if (!isset($_REQUEST['id'])) {
    header("Location: index.php");
}

// Include the database config file
require_once 'conn.php';
include_once 'Cart_function.php';
$cart = new CartFunction;
// Fetch order details from database
$result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email, c.phone FROM orders as r LEFT JOIN orders as c ON c.order_id = r.order_id WHERE r.order_id = " . $_REQUEST['id']);

if ($result->num_rows > 0) {
    $orderInfo = $result->fetch_assoc();
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Status</title>
    <meta charset="utf-8">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/indexStyle.css" rel="stylesheet" media="all">
</head>
<body>


<div class ="topbar">
    <div class="wrapper">
        <a href="index.php" class="logo"></a>
        <div class="nav">

            <form action="search.php" method="post" style="padding-top: 20px">
                <input type="text" name="searchbar"  placeholder="Search">
                <input type="submit" value="Search">
            </form>

            <ul class="parent">
                <li class="current">
                    <a href="index.php" >HOME</a>
                    <span class="lines"></span></li>


                <li class="current" style="float: left">
                    <a href="viewCart.php" title="View Cart" ><img src="img/cart.jpg" width="30px"><?php echo ($cart->total_items() > 0) ? $cart->total_items() . ' Item(s)' : 'Empty'; ?></a>



                    <span class="lines"></span></li>
            </ul>

            <div class="userul" style="float: right;padding-top: 20px">
                <ul style="width: 50px;text-align: right">
                    <?php if(!empty($_SESSION['user'])){?>
                        <li class="userInfo">Welcome, <?php echo $_SESSION['user'];?></li>
                        <li	class="userInfo"><a href="logout.php">Log Out</a></li>

                    <?php }else{?>
                        <li class="userInfo"><a href="login.php">Login</a></li>
                    <?php }?>
                </ul>
            </div>


        </div>

    </div>
</div>

<div class="container">
    <h1>ORDER STATUS</h1>
    <div class="col-12">
        <?php if (!empty($orderInfo)) { ?>
            <div class="col-md-12">
                <div class="alert alert-success">Your order has been placed successfully.</div>
            </div>

            <!-- Order status & shipping info -->
            <div class="s">
                <div class="hdr">Order Info</div>
                <p><b>Reference ID:</b> #<?php echo $orderInfo['order_id']; ?></p><br>
                <p><b>Total:</b> <?php echo '$' . $orderInfo['grand_total'] . ' USD'; ?></p><br>
                <p><b>Placed On:</b> <?php echo $orderInfo['created']; ?></p><br>
                <p><b>Buyer Name:</b> <?php echo $orderInfo['first_name'] . ' ' . $orderInfo['last_name']; ?></p><br>
                <p><b>Email:</b> <?php echo $orderInfo['email']; ?></p><br>
                <p><b>Phone:</b> <?php echo $orderInfo['phone']; ?></p><br>
            </div>

            <!-- Order items -->
            <div class="row col-lg-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>QTY</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Get order items from the database
                    $result = $db->query("SELECT i.*, p.product_name, p.price FROM product_orders as i LEFT JOIN products as p ON p.product_id = i.product_id WHERE i.order_id = " . $orderInfo['order_id']);
                    if ($result->num_rows > 0) {
                        while ($item = $result->fetch_assoc()) {
                            $price = $item["price"];
                            $quantity = $item["quantity"];
                            $sub_total = ($price * $quantity);
                            ?>
                            <tr>
                                <td><?php echo $item["product_name"]; ?></td>
                                <td><?php echo '$' . $price . ' USD'; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo '$' . $sub_total . ' USD'; ?></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="col-md-12">
                <div class="alert alert-danger">Your order submission failed.</div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>