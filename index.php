<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

$conn = mysqli_connect('localhost','root','','cps3500_final');
$sql="select *from products";
$res=mysqli_query($conn,$sql);

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

				<form action="search.php" method="post" style="padding-top: 20px">
					<input type="text" name="searchbar"  placeholder="Search">
					<input type="submit" value="Search">
				</form>

				<ul class="parent">
					<li class="current">
					<a href="index.php" >HOME</a>
					<span class="lines"></span></li>
					<li class="current"><a href="cart.php">SHOPPING CART</a>
					<span class="lines"></span></li>
				</ul>

                <div class="userul" style="float: right;padding-top: 20px">
                    <ul style="width: 50px;text-align: right">
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
	
	<div class="home">
		<div id="main">
			<ul>
<?php

			foreach($arr  as $key => $value){ ?>
				<li>
					<div class="item">
						<div class="item-pic"><a>
						<img alt="item 1" src="<?php echo $pic[$key]?>" title="" width="240" height="240"></a>
						</div>
						<div class="item-name"><a title=""><?php echo $p_name[$key];?></a>
						</div>
						<div class="item-price"><strong>￥<?php echo $price[$key];?></strong><span id="p200"></span>
						</div>
						<div class="col-sm-12 col-md-6 text-right">
							<form method="post" href="">
							<a href="add_cart.php?user_id=<?php echo $_SESSION['user_id'] ?>&product_id=<?php echo $p_id[$key]?>&product_name=<?php echo $p_name[$key]?>&price=<?php echo $price[$key]?>" class="btn btn-lg btn-block btn-primary" style="font-size:15px;width:80%;margin-left:-15px;">Add to Cart</a>
							</form>
							
						</div>
					</div>
				</li>
<?php } ?>
				

			</ul>
		</div>
	</div>

</body>
</html>


	

