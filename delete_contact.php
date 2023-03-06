<?php

include 'dbconnect.php';

// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// Get ID of contact to be deleted
$id = $_GET['ContactsID'];

// Delete contact from database
$sql = "DELETE FROM contacts WHERE ContactsID = $id";
if ($db->query($sql) === TRUE) {
  echo "Contact deleted successfully";
} else {
  echo "Error deleting contact: " . $db->error;
}

// Close database connection
header('Location: index.php');
$db->close();
?>
