<?php 
  include('userServer.php'); 
  if (!isset($_SESSION['email'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['email']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>

<?php include('companyHeader.php'); ?>

<div class="header">
	<h2>
		Home Page
		<span class="logout-btn">
			<a href="index.php?logout='1'" style="color: white;">
				<i class="fa fa-sign-out"></i>
			</a>
		</span>
	</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['email'])) : ?>
    	<p>Congrats <strong><?php echo $_SESSION['email']; ?></strong></p>
		<p>Booking Confirmed</p>
		<p class="center-horizontally" style="margin-top: 20px"> 
			<a href="index.php" class="btn">Home</a>
		</p>
    <?php endif ?>
</div>
		
</body>
</html>
