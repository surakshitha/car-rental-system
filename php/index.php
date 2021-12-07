<?php 
	if(session_status() == PHP_SESSION_NONE) {
		session_start(); 
	}
  if (!isset($_SESSION['email'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  } else {
	  include('userServer.php');
	  refreshStock();
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
	unset($_SESSION['userName']);
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
<div class="header" style="width:70%;">
	<h2>
		Home
		<span class="logout-btn">
			<a href="index.php?logout='1'" style="color: white;">
				<i class="fa fa-sign-out"></i>
			</a>
		</span>
	</h2>
</div>
<div class="content" style="width:70%; margin-bottom: 50px">
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
    <?php  if (isset($_SESSION['userName'])) : ?>
    	<p class="center-horizontally">Welcome &nbsp;<strong><?php echo $_SESSION['userName']; ?>!</strong></p>
			<br />
		<p class="center-horizontally"><strong>Select any of the cars from below to rent</strong></p>
		<br />
		<div class="row car-details-wrapper">
			<?php $cars = $_SESSION['cars']; ?>
			<?php foreach ($cars as $car) { ?>
				<div class="car-details">
					<div>
						<div>
							<h4 class="center-horizontally" style="margin-top: 20px"><?=  $car[1] ?></h4>
							<img src="<?= $car[2] ?>" class="car-image center-horizontally" style="height: 160px;"/>
							
							<?php
							$carInfo = $car[3];
							$stock = $car[4];
							$rate = $car[5];
							?>

							<?= "<p class=\"center-horizontally\"> $carInfo </p>"; ?>

							<?= "<p class=\"center-horizontally\"><strong>Stock :</strong> $stock </p>"; ?>
						
							<?= "<p class=\"center-horizontally\"><strong>Rate : </strong> $rate </p>"; ?>
							</br>
							<?php if ($stock == 0) $disable = "disabled"; else $disable = ""; ?>

							<a href="./carRent.php/<?= $car[0] ?>" class="btn btn-<?= $disable?> center-horizontally" style="margin: 0px auto;">Rent</a>
							</br>
							</br>
							<hr>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
    <?php endif ?>
</div>
		
</body>
</html>