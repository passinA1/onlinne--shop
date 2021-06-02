<?php
// Include the database config file
require_once 'conn.php';

// Initialize shopping cart class
include_once 'Cart_function.php';
$cart = new CartFunction;
$user_id = $_SESSION['user_id'];
ob_start();
// If the cart is empty, redirect to the products page
if ($cart->total_items() <= 0) {
    header("Location: index.php");
}

// Get posted data from session
$postData = !empty($_SESSION['postData']) ? $_SESSION['postData'] : array();
unset($_SESSION['postData']);

// Get status message from session
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
if(!$user_id){

    header("Refresh:0;url=index.php");
    echo "<script>alert('please login first')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
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

        <form action="search.php" method="post" style="margin-top:25px">
					<div style="float:left">
					<input type="text" name="searchbar"  placeholder="Search">
					</div>
					<div style="float:left">
					<input type="image" src="img/search.png" >
					</div>
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
    <h1>CHECKOUT</h1>
    <div class="col-12">
        <div class="checkout">
            <div class="row">
                <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
                    <div class="col-md-12">
                        <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                    </div>
                <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                    </div>
                <?php } ?>

                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your Cart</span>
                        <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php
                        if ($cart->total_items() > 0) {
                            //get cart items from session
                            $cartItems = $cart->contents();
                            foreach ($cartItems as $item) {
                                ?>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0"><?php echo $item["name"]; ?></h6>
                                        <small class="text-muted"><?php echo '￥' . $item["price"]; ?>
                                            (<?php echo $item["qty"]; ?>)</small>
                                    </div>
                                    <span class="text-muted"><?php echo '￥' . $item["subtotal"]; ?></span>
                                </li>
                            <?php }
                        } ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (CNY)</span>
                            <strong><?php echo '￥' . $cart->total(); ?></strong>
                        </li>
                    </ul>
                    <a href="Shopping.php" class="btn btn-block btn-info">Add Items</a>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Contact Details</h4>
                    <form method="post" action="cartAction.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name"
                                       value="<?php echo !empty($postData['first_name']) ? $postData['first_name'] : ''; ?>"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                       value="<?php echo !empty($postData['last_name']) ? $postData['last_name'] : ''; ?>"
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="<?php echo !empty($postData['email']) ? $postData['email'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                   value="<?php echo !empty($postData['phone']) ? $postData['phone'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name">Address</label>
                            <input type="text" class="form-control" name="address"
                                   value="<?php echo !empty($postData['address']) ? $postData['address'] : ''; ?>"
                                   required>
                        </div>
                        <input type="hidden" name="action" value="placeOrder"/>
                        <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit"
                               value="Place Order">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>