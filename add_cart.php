<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$conn = mysqli_connect('localhost','root','','cps3500_final');

$uid=$_SESSION['user_id'];
$pid=$_GET['product_id'];
$pname=$_GET['product_name'];
$price=$_GET['price'];
$cart_id;

$sql_pid="select product_id from shopping_cart where product_id='$pid'";
$result=mysqli_query($conn,$sql_pid);
$num=mysqli_num_rows($result);
if($conn){
if($num){
    //购物车存在该商品
    $sql_quantity="select quantity from shopping_cart where product_id='$pid'";
    $qu_result=mysqli_query( $conn,$sql_quantity);
    $quantity= mysqli_fetch_array($qu_result);
    $value=$quantity[0];
    $value+=1;
    
    mysqli_query($conn,"UPDATE shopping_cart SET quantity=$value WHERE product_id=$pid");
    echo "<script> alert('Added to the cart');window.history.go(-1);</script>";
}
else{
    //购物车不存在该商品
     $sql_insert="insert into shopping_cart(user_id,product_name,product_id,price,quantity) values ('$uid','$pname', '$pid', '$price', 1)";
    mysqli_query($conn,$sql_insert);
    echo "<script> alert('Added to the cart');window.history.go(-1);</script>";
}

}
else{
    die('could not connect: '.mysql_error());
}

?>