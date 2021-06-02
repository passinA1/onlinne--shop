<?php
if (!isset($_REQUEST['id'])) {
    header("Location: index.php");
}

// Include the database config file
require_once 'conn.php';
include_once 'Cart_function.php';
$user_id = $_SESSION['user_id'];
$cart = new CartFunction;
// Fetch order details from database
$result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email, c.phone FROM orders as r LEFT JOIN orders as c ON c.order_id = r.order_id WHERE r.order_id = " . $_REQUEST['id']);
$conn = mysqli_connect('localhost','root','','cps3500_final');
if ($result->num_rows > 0) {
    $orderInfo = $result->fetch_assoc();
} else {
    header("Location: index.php");
}
$sql_balance = "SELECT balance FROM users where id=$user_id";
$result_ba=mysqli_query($conn,$sql_balance);
$bb=mysqli_fetch_array($result_ba);
$balance = $bb[0];


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
                <ul style="width: auto;text-align: right">
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
                <div class="alert alert-success">An email with your order information has been sent!</div>

            <!-- Order status & shipping info -->
            <div class="s">
                <div class="hdr"><h1>Order Info</h1></div>
                <p><b>Reference ID:</b> #<?php echo $orderInfo['order_id']; ?></p>
                <p><b>Total:</b> <?php echo '￥' . $orderInfo['grand_total'] . ''; ?></p>
                <p><b>Placed On:</b> <?php echo $orderInfo['created']; ?></p>
                <p><b>Buyer Name:</b> <?php echo $orderInfo['first_name'] . ' ' . $orderInfo['last_name']; ?></p>
                <p><b>Email:</b> <?php echo $orderInfo['email']; ?></p>
                <p><b>Phone:</b> <?php echo $orderInfo['phone']; ?></p>
                <p><b>Your Balance:</b><?php echo $balance; ?></p>
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
                                <td><?php echo '￥' . $price . ''; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo '￥' . $sub_total . ''; ?></td>
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