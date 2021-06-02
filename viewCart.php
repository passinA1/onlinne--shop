<?php
// Initialize shopping cart class
include_once 'Cart_function.php';
$cart = new CartFunction;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Cart</title>
    <meta charset="utf-8">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/indexStyle.css" rel="stylesheet" media="all">

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <script>
        function updateCartItem(obj, id) {
            $.get("cartAction.php", {action: "updateCartItem", id: id, qty: obj.value}, function (data) {
                if (data == 'ok') {
                    location.reload();
                } else {
                    alert('CartFunction update failed, please try again.');
                }
            });
        }
    </script>
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
    <h1>SHOPPING CART</h1>
    <div class="row">
        <div class="cart">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="45%">Product</th>
                            <th width="10%">Price</th>
                            <th width="15%">Quantity</th>
                            <th class="text-right" width="20%">Total</th>
                            <th width="10%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($cart->total_items() > 0){
                            // Get cart items from session
                            $cartItems = $cart->contents();
                            foreach ($cartItems as $item) {
                                ?>
                                <tr>
                                    <td><?php echo $item["name"]; ?></td>
                                    <td><?php echo '￥' . $item["price"] . ''; ?></td>
                                    <td><input class="form-control" type="number" value="<?php echo $item["qty"]; ?>"
                                               onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')"/></td>
                                    <td class="text-right"><?php echo '￥' . $item["subtotal"] . ''; ?></td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')?window.location.href='cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;">
                                            <i class="itrash"></i></button>
                                    </td>
                                </tr>
                            <?php }
                        }else{ ?>
                        <tr>
                            <td colspan="5"><p>Your cart is empty.....</p></td>
                            <?php } ?>
                            <?php if ($cart->total_items() > 0){ ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>Cart Total</strong></td>
                                <td class="text-right"><strong><?php echo '￥' . $cart->total() . ''; ?></strong>
                                </td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a href="index.php" class="btn btn-block btn-light">Continue Shopping</a>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <?php if ($cart->total_items() > 0) {
                            ?>
                            <a href="checkout.php" class="btn btn-lg btn-block btn-primary">Checkout</a>
                        <?php }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>