<?php include('userServer.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Car Rental Agency</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
	<div style="margin-top: 10%">
		<?php include('companyHeader.php'); ?>
		<div class="header">
			<h2>Login</h2>
		</div>
		
		<form method="post" action="login.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" >
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div class="input-group login-signup-btn center-horizontally">
				<button type="submit" class="btn" name="login_user">Login</button>

				<a class="btn" href="signUp.php">Sign up</a>
			</div>
			<p class="center-horizontally admin-btn-wrapper">
				Car company -> <span>&nbsp;</span>
					<a class="btn" href="adminLogin.php">
						Admin Login
					</a>
			</p>
		</form>
	</div>

	<?php include('carAnimation.php'); ?>
</body>
</html>