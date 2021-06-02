<?php


session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "cps3500_final" ;
$user=$_SESSION['user'];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbName);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());}

$sql="select *from users";
$res=mysqli_query($conn,$sql);

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
	<div class = "table table-striped table table-hover" style="float: left;">
	    <?php
        header('Content-type: admin_product/css');
        header("Content-Type: text/html; charset=utf-8");

        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"admin_product.css\" />";
		echo "<table class=\"\" style=\"border-color: grey\">
		<tr>
		<th>user id</th>
		<th>user name</th>
		<th>password</th>
		<th>email</th>
		<th>authority</th>
		</tr>";

		while($row = $res->fetch_array())//转成数组，且返回第一条数据,当不是一个对象时候退出
		{
		echo "<tr>";
		echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['user_name'] . "</td>";
		echo "<td>" . $row['password'] . "</td>";
		echo "<td>" . $row['email'] . "</td>";
		echo "<td>" . $row['authority'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";

		mysqli_close($conn);
		?>
	</div>
</body>
</html>
	