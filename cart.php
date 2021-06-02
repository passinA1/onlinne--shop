<?php
session_start();
?>
<html>
<head>
	<TITLE>main page</TITLE>
	<link href="admin_product.css" rel="stylesheet" media="all">
</head>
<body>
	<div class ="topbar">
		<div class="wrapper">
			<a href="index.php" class="logo"></a>
			<div class="nav">
				<ul class="parent">
					<li class="current">
					<a href="index.php" >HOME</a>
					<span class="lines"></span></li>
					<li class="current"><a href="shopcart.php">SHOPPING CART</a>
					<span class="lines"></span></li>
					<li class="userInfo">
					<a href="index.php" >Welcome, <?php echo $_SESSION['user']?></a>
				</ul>
			</div>
		</div>
	</div>
    <div class="table">
    <?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"admin_product.css\" />";
header('Content-type: admin_product/css');
header("Content-Type: text/html; charset=utf-8");
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "cps3500_final" ;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbName);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());}
  $sql="select *from shopping_cart";

  $res=mysqli_query($conn,$sql);
echo "<table>
		<tr>
		<th>Cart id</th>
		<th>User id</th>
		<th>Product name</th>
		<th>Product id</th>
		<th>Price</th>
		<th>Quantity</th>
        <th>Total Price</th>
		
		</tr>";

		while($row = $res->fetch_array())//转成数组，且返回第一条数据,当不是一个对象时候退出
		{
		echo "<tr>";
		echo "<td>" . $row['cart_id'] . "</td>";
		echo "<td>" . $row['user_id'] . "</td>";
		echo "<td>" . $row['product_name'] . "</td>";
		echo "<td>" . $row['product_id'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['price']*$row['quantity'] ."</td>";
		
		echo "</tr>";
		}
		echo "</table>";

		mysqli_close($conn);
?>
		</div>
        </body>
        </html>
    