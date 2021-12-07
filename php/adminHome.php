<?php 
  session_start(); 
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
    	<p>Welcome <strong><?php echo $_SESSION['email']; ?></strong> </p>
			<br />
			<p>Choose from any of the below options</p>
			<div class="admin-view-btn-wrapper center-horizontally">
        <a class="btn admin-view-btn" href= "addCar.php"> Add Car</a>
        <a class="btn admin-view-btn" href= "removeCar.php"> Remove Car</a>
			</div>
    <?php endif ?>
</div>
		
</body>
</html>