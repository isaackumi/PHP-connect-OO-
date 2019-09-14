<?php 

class connection
{
//  property of the class 

public $db;

// method in the connection class
// constructor 
public function __construct(){
    $this->connect();
}


public function connect(){
$this->db=new mysqli('localhost','root','','dbname');

if ($this->db){
   // echo "Connected";

   return true;
}
else{
    //echo "Not connected";
    return false;
}

}

}


// sql to create table

$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($this->db->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $this->db->error;
}

$this->db->close();


?>