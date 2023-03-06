<?php
session_start();

// initializing variables
$first_Name = "";
$last_Name = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'kontaktusisema');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $first_Name = mysqli_real_escape_string($db, $_POST['first_Name']);
  $last_Name = mysqli_real_escape_string($db, $_POST['last_Name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($first_Name)) { array_push($errors, "First name is required"); }
  if (empty($last_Name)) { array_push($errors, "Last name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

  // first check the database to make sure 
  // a user does not already exist with the same first_Name and/or email
  $user_check_query = "SELECT email FROM user where email = '$email'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

    if(!empty($user)) {
      array_push($errors, "Email already exists");
    }




  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO user (first_Name, last_Name, email, password) 
  			  VALUES('$first_Name', '$last_Name', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['first_Name'] = $first_Name;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: index.php');
        }else {
            array_push($errors, "Wrong email/password combination");
        }
    }
  }
  
  ?>