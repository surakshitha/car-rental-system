<?php include('userServer.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Go Cars</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
	<?php include('companyHeader.php'); ?>
  <div class="header">
  	<h2>
			Remove Car
			<span class="logout-btn">
			<a href="index.php?logout='1'" style="color: white;">
				<i class="fa fa-sign-out"></i>
			</a>
		</span>
		</h2>
  </div>
	
  <form method="post" action="removeCar.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Car Name</label>
  	  <input type="text" name="carName" value="<?php echo $carName; ?>" >
  	</div>

  	<div class="input-group center-horizontally" style="margin-top: 20px">
  	  <button type="submit" class="btn" name="remove_car">Remove Car</button>
  	</div>
  </form>
</body>
</html>