<?php
session_start();
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

$sql="select *from products";
$res=mysqli_query($conn,$sql);
$arr=array();

while($row=mysqli_fetch_array($res)){
    $p_id[]=$row["product_id"];
    $p_name[]=$row["product_name"];
    $price[]=$row["price"];
    $pic[]    =$row["pic"];
    $inven[]=$row["inventory"];
    $arr[]=$row;
}

$user=$_SESSION['user'];

?>
<html>
<head>
	<TITLE>main page</TITLE>
	<link href="admin_product.css" rel="stylesheet" media="all">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="all">
</head>
<body>
<div class ="topbar">
    <div class="wrapper">
        <a href="index.php" class="logo"></a>

        <div class="userul">
            <ul >
                <li class="current">
                    <a href="index.php" >HOME</a>
                    <span class="lines"></span></li>

                <li class="userInfo">Welcome, <?php echo $_SESSION['user'];?></li>
                <li	class="userInfo"><a href="logout.php">Login Out</a></li>
            </ul>
        </div>
    </div>
</div>


	<aside class="lt_aside_nav content mCustomScrollbar">
	 <ul>
	  <li>
	   <dl>
	    <dt>Menu</dt>
	    <dd><a href="admin_product.php">Product Lists</a></dd>
	    <dd><a href="admin_user.php">Users</a></dd>
	    <dd><a href="admin_order.php">Orders</a></dd>
	   </dl>
	  </li>
	 </ul>
	</aside>
	<div class = "table table-striped table-hover">
	    <?php
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"admin_product.css\" />";

	    
	    $sql="select *from orders";
	    $res=mysqli_query($conn,$sql);
		echo "<table>
		<tr>
		<th>order_id</th>
		<th>user_id</th>
		<th>first_name</th>
		<th>last_name</th>
		<th>grand_total</th>
		<th>phone</th>
		<th>address</th>

		<th>status</th>
		<th>email</th>

		</tr>";

		while($row = $res->fetch_array())//转成数组，且返回第一条数据,当不是一个对象时候退出
		{
		echo "<tr>";
		echo "<td>" . $row['order_id'] . "</td>";
		echo "<td>" . $row['user_id'] . "</td>";
		echo "<td>" . $row['first_name'] . "</td>";
		echo "<td>" . $row['last_name'] . "</td>";
		echo "<td>" . $row['grand_total'] . "</td>";
		echo "<td>" . $row['phone'] . "</td>";
		echo "<td>" . $row['address'] . "</td>";
		echo "<td>" . $row['status'] . "</td>";
		echo "<td>" . $row['email'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";

		mysqli_close($conn);
		?>
	</div>
</body>
</html>
	