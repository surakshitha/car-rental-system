<?php include('userServer.php');
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
	<title>Confirmation</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>

<div class="header" style="width:70%;">
	<h2>
		Confirmation
		<span class="logout-btn">
			<a href="index.php?logout='1'" style="color: white;">
				<i class="fa fa-sign-out"></i>
			</a>
		</span>
	</h2>
</div>
<div class="content" style="width:70%;">
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
		<form method="post" action="confirmation.php" style="width:70%;">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>Total</label>
				<p><?php echo $_SESSION['number_of_days']; ?> days * <?php echo $_SESSION['car_rate']; ?>$/day = <?php echo $_SESSION['total_amount']; ?>$</p>
			</div>
			<div class="header" style="width:90%;">
				<label>Enter Card Details</label>
			</div>
			<div class="input-group">
				<label>Card Number</label>
				<input type="text" name="cardNumber" placeholder="xxxx xxxx xxxx xxxx" value="<?php echo $cardNumber; ?>">
			</div>
			<div class="input-group">
				<label>Card Expiry</label>
				<input type="text" placeholder="MM/yy" name="cardExpiry" value="<?php echo $cardExpiry; ?>">
			</div>
			<div class="input-group">
				<label>CVV</label>
				<input type="text" name="cardCvv" placeholder="xxx" value="<?php echo $cardCvv; ?>">
			</div>
			<div class="input-group">
				<label>Name on the Card</label>
				<input type="text" name="cardName" value="<?php echo $cardName; ?>">
			</div>
			<div class="input-group center-horizontally" style="margin-top: 20px">
				<button type="submit" class="btn" name="confirm">Confirm Payment</button>
			</div>
	  </form>
    <?php endif ?>
</div>
		
</body>
</html>