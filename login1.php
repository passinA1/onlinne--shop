<?php
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbName = "cps3500_final" ;
	
	$conn = mysqli_connect($servername, $username, $password, $dbName);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());}
	
	mysqli_select_db($conn,'cps3500_final');
	mysqli_set_charset($conn,'utf8');
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	 
	$sql="select * from users where user_name='$username' AND password='$password'";
	
	$result=mysqli_query($conn,$sql);


	if($result->num_rows!=0){

	$sql_user="select id,authority from users where user_name='$username'";
	$id_result=mysqli_query( $conn,$sql_user);
    $userInfo= mysqli_fetch_array($id_result);
	$user_id=$userInfo[0];
	$user_authority=$userInfo[1];
	$_SESSION['user']=$username;
	$_SESSION['user_id']=$user_id;
	mysqli_close($conn);
		if($user_authority==1){
			header("location:admin_user.php");
			
		}
		else 
			header("Location: index.php");//登录跳转
			
	}else{
		echo "<script> alert('Incorrect account or password!');window.history.go(-1);</script>";
	}
	
	
?>









