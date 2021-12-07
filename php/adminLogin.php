<?php include('userServer.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Adming Login</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
	<?php include('companyHeader.php'); ?>

  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Admin Email</label>
  		<input type="email" name="email" >
  	</div>
  	<div class="input-group">
  		<label>Admin Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group center-horizontally" style="margin-top: 20px">
  		<button type="submit" class="btn" name="login_admin">Login</button>
  	</div>
  </form>
</body>
</html>