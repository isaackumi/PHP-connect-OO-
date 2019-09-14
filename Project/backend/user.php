<?php 
include_once 'connection.php';

class user extends connection
{
    
    public $username=null;
   // public $email=null;
    public $password=null;

  
public function __construct(){
    parent::__construct();
}

public function create(){
    echo $this->username;
  //  echo $this->email;
    echo $this->password;
}


}
?>