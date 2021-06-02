<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

include_once  'Cart_function.php';
$cart = new CartFunction;

require_once 'conn.php';

$conn = mysqli_connect('localhost','root','','cps3500_final');
$sql="select *from products";
$res=mysqli_query($conn,$sql);
$login_status=false;
$row=array();
while($row=$res->fetch_array()){
$p_id[]   =$row["product_id"];
$p_name[] =$row["product_name"];
$price[]  =$row["price"];
$pic[]    =$row["pic"];
$arr[]    =$row;
}
if(!empty($_SESSION['user'])){
$user=$_SESSION['user'];
$user_id=$_SESSION['user_id'];
$login_status=true;
}
?>
<html>
<head>
	<TITLE>main page</TITLE>
	<link href="css/indexStyle.css" rel="stylesheet" media="all">
	<link href="css/bootstrap.min.css" rel="stylesheet">
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
                        <a href="viewCart.php" title="View Cart" ><img src="img/cart.jpg" width="30px">
						<?php echo ($cart->total_items() > 0) ? $cart->total_items() . ' Item(s)' : 'Empty'; ?></a>
					<span class="lines"></span></li>
				</ul>

                <div class="userul" style="float: right;padding-top: 20px;">
                    <ul style="width: auto;text-align: right">
                        <?php if(!empty($_SESSION['user'])){?>
                            <li class="userInfo">Welcome, <?php echo $_SESSION['user'];?></li>
                            <li	class="userInfo"><a href="logout.php">Login Out</a></li>

                        <?php }else{?>
                            <li class="userInfo"><a href="login.php">Login</a></li>
                        <?php }?>
                    </ul>
                </div>


			</div>

		</div>
	</div>

	<div class="gradient-color">
	<div class="backgroundpic" onclick="window.open('items/R9000Pintro.php')"></div>
	</div>

	<div class="home">
		<div class="main">
			<ul>
                <div class="row col-lg-12">
                    <?php
                    // Get products from database
                    $result = $db->query("SELECT * FROM products ORDER BY product_id DESC LIMIT 10");
					
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="card col-lg-4">
                                <div class="card-body">
                                    <img src="<?php echo $row["pic"]?>" width="240" height="240">
                                    <h5 class="card-title"><?php echo $row["product_name"]; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Price: <?php echo '￥' . $row["price"] . ''; ?></h6>

                                    <a href="cartAction.php?action=addToCart&id=<?php echo $row["product_id"]; ?>"
                                       class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <p>Product(s) not found.....</p>
                    <?php } ?>
                </div>
            </ul>
		</div>
	</div>
	
</body>
</html>


	

