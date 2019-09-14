<html>

<body>
	  <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phoneDb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, firstname, lastname FROM MyGuests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();

/*
$x = 75; 
$y = 25;
 
function addition() { 
    $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y']; 
}
 
addition(); 
echo" $z <br/>"; 
echo $_SERVER["PHP_SELF"];
		
$friends= array("kofi","Ama","Micky");
	echo "Hey! $friends[2] .<br/>" ;
	if($friends[1]=="Ama"){
		echo strtoupper("I found Ama");
	}
		else{
			echo "I didn't see Ama.<br><br><br>";
		}	*/
 

//  $cars = array
//   (
//   array("Volvo",22,18),
//   array("BMW",15,13),
//   array("Saab",5,2),
//   array("Land Rover",17,15)
//   );

// echo $cars[0][0].": In stock: ".$cars[0][1].", sold: ".$cars[0][2].".<br>";
// echo $cars[1][0].": In stock: ".$cars[1][1].", sold: ".$cars[1][2].".<br>";
// echo $cars[2][0].": In stock: ".$cars[2][1].", sold: ".$cars[2][2].".<br>";
// echo $cars[3][0].": In stock: ".$cars[3][1].", sold: ".$cars[3][2].".<br>";
 
?>
 
<form method="post" action="welcome.php">

	
Name :	<input type="text" name="name" required=""><br>
E_mail :	<input type="text" name="email" required=""><br> 
comment
 <textarea name="comment" required=""></textarea>
 <input  class="btn btn-btn primary" type="submit">
	
	</form> 
	
</body>

</html>
