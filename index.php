<?php 
  session_start(); 

  if (!isset($_SESSION['email'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }

    // Connect to the database
	include 'dbconnect.php';
  
	$email = $_SESSION['email'];
	// Query to retrieve information from the database
	$query = "SELECT * FROM user WHERE email='$email'";
	$result = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($result);
	
	// Assign the retrieved information to session variables
	$_SESSION['first_Name'] = $user['First_Name'];
	$_SESSION['last_Name'] = $user['Last_Name'];

	$sql2 = "SELECT User_ID FROM user WHERE Email='".$_SESSION['email']."'";
	$result = mysqli_query($db, $sql2);
	$row = mysqli_fetch_assoc($result);
	$UserID = $row['User_ID'];

	$_SESSION['User_ID'] = $UserID;

	$sql = "SELECT * FROM contacts WHERE user_id='".$_SESSION['User_ID']."'";
	$result2 = mysqli_query($db, $sql);


  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['email']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Kontaktų Valdymo Sistema</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Apie mane</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo "Sėkmingai prisijungėte"; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['email'])) : ?>
    	<p>Sveiki, <strong><?php echo $_SESSION['first_Name']; echo " "; echo $_SESSION['last_Name']; ?></strong>.</p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

	<div class="header">
	<h2>Pridėti kontaktą</h2>
</div>

<div class="content" class="box">

		<form method="post" action="add_contact.php">
	<div class="input-container">
    	<input type="text" id="name" name="name" required="">
		<label for="name">Vardas</label>
	</div>

	<div class="input-container">
    	<input type="email" id="email" name="email" required="">
		<label for="email">El. Paštas</label>
	</div>

	<div class="input-container">
    	<input type="tel" id="phone" name="phone" required="">
		<label for="phone">Telefono numeris</label>
	</div>

	<div class="input-container">
    	<input type="text" id="address" name="address" required="">
		<label for="address">Adresas</label>
	</div>

    	<input type="submit" class="btn" value="Pridėti kontaktą">
  		</form>
</div>

  <div class="header">
	<h2>Mano kontaktai</h2>
</div>
<div class="content">
    <!-- logged in user information -->
    <?php  if (isset($_SESSION['email'])) : ?>
		<table>
    <tr>
      <th>Vardas</th>
      <th>El. Paštas</th>
      <th>Telefono numeris</th>
      <th>Adresas</th>
    </tr>
    <?php while($row = mysqli_fetch_array($result2)): ?>
    <tr>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['phone']; ?></td>
      <td><?php echo $row['address']; ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
    <?php endif ?>
	</div>






</body>
</html>