

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Login2</title>
</head>
<body>
	<form action = "login1.php" method = "post">
		<div class="login-wrapper">
		  <div class="header">Login</div>
		  <div class="form-wrapper">
			<input type="text" name="username" placeholder="username" class="input-item">
			<input type="password" name="password" placeholder="password" class="input-item">
			<div>
				<button class = "btn">Login</button>
			</div>
		  </div>
		  <div class="msg">
			Don`t have account? <a href="signup.php">Sign up</a>
		  </div>
		</div>
	</form>
</body>
</html>