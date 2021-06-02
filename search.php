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
  die("Connection failed: " . mysqli_connect_error());
}

$key=$_POST["searchbar"];

  $sql="select * from products where product_name like '%$key%'";
  $res=mysqli_query($conn,$sql);

  $p_id=array();
  $p_name=array();
  $price=array();
  $pic=array();
  $arr=array();

//查询结果不为0  
if($res){
    while($row=$res->fetch_array()){
        $p_id[]   =$row["product_id"];
        $p_name[] =$row["product_name"];
        $price[]  =$row["price"];
        $pic[]    =$row["pic"];
        $arr[]    =$row;
        }
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
                        <li class="current"><a href="cart.php">SHOPPING CART</a>
                        <span class="lines"></span></li>
                    </ul>
    
                    <ul class="userul" style="float: right;padding-top: 20px;width: auto;text-align: right;">
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
        
        <div class="home">
            <div class="main">
                <ul>
<?php

if(!empty($arr)){
        foreach($arr  as $key => $value){ ?>
        <li>
            <div class="card-body">
                <div class="item-pic"><a>
                <img alt="item 1" src="<?php echo $pic[$key]?>" title="" width="240" height="240"></a>
                </div>
                <div class="item-name"><a title=""><?php echo $p_name[$key];?></a>
                </div>
                <div class="item-price"><strong>￥<?php echo $price[$key];?></strong><span id="p200"></span>
                </div>
                <div>
                    <form method="post" href="">
                    <a id="tiao" href="add_cart.php?user_id=<?php echo $_SESSION['user_id'] ?>&product_id=<?php echo $p_id[$key]?>&product_name=<?php echo $p_name[$key]?>&price=<?php echo $price[$key]?>"
                    class="btn btn-primary">Add to Cart</a>
                    </form>
                    
                </div>
            </div>
        </li>
<?php }} ?>

    </ul>
    </div>
</div>

</body>
</html>