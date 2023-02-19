<?php
session_start(); 
include 'dbconnect.php';

$sql2 = "SELECT User_ID FROM user WHERE Email='".$_SESSION['email']."'";
$result = mysqli_query($db, $sql2);
$row = mysqli_fetch_assoc($result);
$UserID = $row['User_ID'];



// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  // Get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  
  
  // Insert the new contact into the database
  $sql = "INSERT INTO contacts (name, email, phone, address, user_id) VALUES ('$name', '$email', '$phone', '$address', '$UserID')";
  
  if (mysqli_query($db, $sql)) {
    echo "New contact added successfully!";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
  }
  
  // Close the connection
  mysqli_close($db);
?>
