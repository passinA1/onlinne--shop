<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

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
	<TITLE>R9000P</TITLE>
	<link href="item.css" rel="stylesheet" media="all">
	<link href="../bootstrap.min.css" rel="stylesheet">
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
					<input type="image" src="../img/search.png" >
					</div>
				</form>

				<ul class="parent">
					<li class="current">
					<a href="../index.php" >HOME</a>
					<span class="lines"></span></li>
					<li class="current"><a href="../cart.php">SHOPPING CART</a>
					<span class="lines"></span></li>
				</ul>

                <div class="userul" style="float: right;padding-top: 20px;">
                    <ul style="width: auto;text-align: right">
                        <?php if(!empty($_SESSION['user'])){?>
                            <li class="userInfo">Welcome, <?php echo $_SESSION['user'];?></li>
                            <li	class="userInfo"><a href="../logout.php">Login Out</a></li>

                        <?php }else{?>
                            <li class="userInfo"><a href="../login.php">Login</a></li>
                        <?php }?>
                    </ul>
                </div>
			</div>
		</div>
	</div>
    <div class="body">
        <div class="background-pic">
        </div>

        <div class="div-video">
            <iframe width="100%" class="video-attri" src="https://www.youtube.com/embed/Q2wibcNSShU" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>
	</div>
</body>
</html>