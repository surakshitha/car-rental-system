<?php
if(session_status() == PHP_SESSION_NONE) {
		session_start(); 
}

// initializing variables
$firstName = "";
$lastName = "";
$email    = "";
$phoneNumber = "";
$state = "";
$city = "";
$carName = "";
$carPhotoURL = "";
$carInfo = "";
$carStock = "";
$carRate = "";
$cardName = "";
$cardCvv = "";
$cardExpiry = "";
$cardNumber = "";
$user_id = "";
$return_date = "";

$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', 'Jenn@1410', 'carrental');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($db, $_POST['lastName']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $phoneNumber = mysqli_real_escape_string($db, $_POST['phoneNumber']);
  $state = mysqli_real_escape_string($db, $_POST['state']);
  $city = mysqli_real_escape_string($db, $_POST['city']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (firstName, lastName, email, phoneNumber, state, city, password) 
  			  VALUES('$firstName', '$lastName', '$email', '$phoneNumber', '$state', '$city', '$password')";
  	mysqli_query($db, $query);
    $_SESSION['userName'] = $firstName;
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

if (isset($_POST['car_add'])) {
  // receive all input values from the form
  $carName = mysqli_real_escape_string($db, $_POST['carName']);
  $carPhotoURL = mysqli_real_escape_string($db, $_POST['carPhotoURL']);
  $carInfo = mysqli_real_escape_string($db, $_POST['carInfo']);
  $carStock = mysqli_real_escape_string($db, $_POST['carStock']);
  $carRate = mysqli_real_escape_string($db, $_POST['carRate']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($carName)) { array_push($errors, "Car Name is required"); }
  if (empty($carRate)) { array_push($errors, "Car Rate is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same email
  $user_check_query = "SELECT * FROM cars WHERE car_name='$carName' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $car = mysqli_fetch_assoc($result);
  
  if ($car) { // if user exists
    if ($car['car_name'] === $carName) {
      array_push($errors, "car name already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  //encrypt the password before saving in the database

  	$query = "INSERT INTO cars (car_name, car_pic, car_info, car_stock, car_rate) 
  			  VALUES('$carName', '$carPhotoURL', '$carInfo', '$carStock', '$carRate')";
  	mysqli_query($db, $query);
  	$_SESSION['success'] = "Car has been added";
  	header('location: adminHome.php');
  }
}


//Rent details
function carDetails($int) {
	$car_id = $int;
	$query = "SELECT * FROM cars WHERE car_id = '$car_id'";
	global $db;
	$results = mysqli_query($db, $query);
	if (mysqli_num_rows($results) == 1) {
		$carDetails = mysqli_fetch_assoc($results);
		$_SESSION['car_name'] = $carDetails['car_name'];
		$_SESSION['car_pic'] = $carDetails['car_pic'];
		$_SESSION['car_info'] = $carDetails['car_info'];
		$_SESSION['car_stock'] = $carDetails['car_stock'];
		$_SESSION['car_rate'] = $carDetails['car_rate'];
		$_SESSION['car_id'] = $car_id;
	}
}

if (isset($_POST['remove_car'])) {
  $carName = mysqli_real_escape_string($db, $_POST['carName']);
  
  if (empty($carName)) { array_push($errors, "Car Name is required"); }
  
	$query = "DELETE from cars where car_name = '$carName'";

  mysqli_query($db, $query);
  $_SESSION['success'] = "Car has been removed";
  header('location: adminHome.php');
}


//Confirmation Page
if (isset($_POST['confirm_rent'])) {
	$return_date = mysqli_real_escape_string($db, $_POST['return_date']);
	$current_date = date_create(date("Y/m/d"));
	$returnDate = date_create($return_date);
	$diff = date_diff($current_date, $returnDate);
	$_SESSION['number_of_days'] = intval($diff->format("%d")) + 1;
	$_SESSION['total_amount'] = $_SESSION['number_of_days'] * $_SESSION['car_rate'];
	$_SESSION['return_date'] = date("Y/m/d",strtotime($return_date));
	header('location: ../confirmation.php');
}

if (isset($_POST['confirm'])) {
	  $cardName = mysqli_real_escape_string($db, $_POST['cardName']);
	  $cardCvv = mysqli_real_escape_string($db, $_POST['cardCvv']);
	  $cardExpiry = mysqli_real_escape_string($db, $_POST['cardExpiry']);
	  $cardNumber = mysqli_real_escape_string($db, $_POST['cardNumber']);
	  $totalAmount = mysqli_real_escape_string($db, $_SESSION['total_amount']);
	  if (empty($cardName)) { array_push($errors, "Card Name is required"); }
	  if (empty($cardNumber)) { array_push($errors, "Card Number is required"); } else if (strlen($cardNumber) != 19) { array_push($errors, "Invalid card number"); }
	  if (empty($cardCvv)) { array_push($errors, "Card CVV is required"); } else if (strlen($cardCvv) != 3) { array_push($errors, "Invalid card cvv"); }
	  if (empty($cardExpiry)) { array_push($errors, "Card Expiry is required"); } else if ((substr($cardExpiry, 0, 2) > 12) || (substr($cardExpiry, 3) < 20)) { array_push($errors, "Invalid expiry"); }
	  
	  $email = $_SESSION['email'];
	  
	  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
	  $result = mysqli_query($db, $user_check_query);
	  $user = mysqli_fetch_assoc($result);
	  
	  if ($user) { // if user exists
		$user_id = $user['id'];
	  } else {
		  array_push($errors, "User ID does not exist");
	  }
	  if (count($errors) == 0) {
		  $car_id = $_SESSION['car_id'];
		  $return_date = $_SESSION['return_date'];
		$query = "INSERT INTO transaction (user_id, car_id, return_date, value) 
				  VALUES('$user_id', '$car_id', '$return_date', '$totalAmount')";
		mysqli_query($db, $query);
		
		header('location: bookingConfirmed.php');
	  }
}

function refreshStock() {
	global $db;
	$query = "SELECT * FROM cars";
	$results = mysqli_query($db, $query);
	$rows = array();
	while($row = $results->fetch_row()) {
		array_push($rows,$row);
	}
	$_SESSION['cars'] = $rows;
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $row = $results->fetch_row();
          $_SESSION['userName'] = $row[1];
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
		  $query = "SELECT * FROM cars";
		  $results = mysqli_query($db, $query);
		  $rows = array();
		  while($row = $results->fetch_row()) {
			 array_push($rows,$row);
		  }
		  $_SESSION['cars'] = $rows;
          header('location: index.php');
        }else {
            array_push($errors, "Wrong email/password combination");
        }
    }
  }


  // ADMIN 
  if (isset($_POST['login_admin'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "admin email is required");
    }
    if (empty($password)) {
        array_push($errors, "admin password is required");
    }
  
    if (count($errors) == 0) {
        $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: adminHome.php');
        }else {
            array_push($errors, "Wrong email/password combination");
        }
    }
  }
  
  ?>
