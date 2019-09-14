<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "phonedb";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	


	$email = $_GET['email'];
	$password = $_GET['password'];

	$sql = "SELECT * FROM user where email = '$email' and password = '$password'";
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {
	    echo "yes";
	} else {
	    echo "no";
	}
	
	$conn->close();
 ?>