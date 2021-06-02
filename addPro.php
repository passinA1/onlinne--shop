<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$conn = mysqli_connect('localhost','root','','cps3500_final');

$pid=$_GET['product_id'];
$inv=$_GET['invento'];

$sql_pid="select product_id from products where product_id='$pid'";
$result=mysqli_query($conn,$sql_pid);
$num=mysqli_num_rows($result);
if($conn){
if($num){
    //购物车存在该商品
   
   mysqli_query($conn,"UPDATE products SET inventory=$inv WHERE product_id=$pid");
    echo "<script> alert('Change Successfully');window.history.go(-1);</script>";
}

}
else{
    die('could not connect: '.mysql_error());
}

?> 