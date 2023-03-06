<?php
// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get the values from the form
    $id = $_POST["ContactsID"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    include 'dbconnect.php';

    // check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // update the contact in the database
    $sql = "UPDATE contacts SET name='$name', email='$email', phone='$phone' WHERE ContactsID=$id";

    if ($db->query($sql) === TRUE) {
        echo $id;
        echo $name;
        echo $email;
        echo $phone;
    } else {
        echo "Error updating contact: " . $db->error;
    }

    // close database connection
    $db->close();
}
?>