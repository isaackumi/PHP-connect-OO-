<?php
/**
 * Created by PhpStorm.
 * User: cyber
 * Date: 11/20/2018
 * Time: 4:18 PM
 */

require_once 'Connection.php';

class User extends Connection
{
    /**
     * @var null
     */
    public $member_id = null;
    public $image = null;
    public $firstname = null;
    public $middlename = null;
    public $lastname = null;
    public $department_id = null;
    public $status = null;
    public $path = null;
    public $note = null;

    public $newAvatarPath = null;

    //for admin login
    public $username = null;
    public $password = null;
    public $rpassword = null;


    public function __construct()
    {
        parent::__construct();
    }

    //================== ADMIN ======================//

    /**
     * @return bool
     * Login the Admin
     */
    public function login()
    {
        $password = md5($this->password);
        $query_stmt = "SELECT * FROM {$this->adminTable} WHERE username = '{$this->username}' AND password = '{$password}'";

        $retval = $this->db->query($query_stmt);
        $data = $retval->fetch_assoc();
        $row = $retval->num_rows; //did we find any ?

        if ($row == 1) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $data['username'];
            $this->redirect('templates/index.php');
        } else {
            $_SESSION['error'] = "Authentication Failed";
        }
    }

    public function countUsers()
    {
        $stmt = "SELECT COUNT(*) AS 'userCount' FROM " . $this->membersTable;
        $retval = $this->db->query($stmt);
        $data = $retval->fetch_assoc();
        return $data['userCount'];
    }

    public function countNewUsers($today = null)
    {
        if ($today == null) {
            $stmt = "SELECT COUNT(*) AS 'userCount' FROM " . $this->membersTable;
        } else {
            $stmt = "SELECT COUNT(*) AS 'userCount' FROM " . $this->membersTable . " WHERE created_at='{$today}'";
        }
        $retval = $this->db->query($stmt);
        $data = $retval->fetch_assoc();
        return $data['userCount'];
    }

    /**
     * Register the Admin
     */
    public function register()
    {
        $password = md5($this->password);
        $rpassword = md5($this->rpassword);
        if ($password == $rpassword) {

            $stmt_query = "SELECT * FROM " . $this->adminTable . " WHERE name = '{$this->username}'";
//            $check_retval = $this->db->query($stmt_query);
//            $check_row    = $check_retval->num_rows;
//
//            if ($check_row == 1) {
//                $this->error = $this->username. ' already exist. !';
////                echo $this->username ."  already exist ...!!!";
//            }else {
//                $stmt   = "INSERT INTO ".$this->adminTable."(name) VALUES('{$this->username}')";
//                $retval = $this->db->query($stmt);
//
//                if ($retval) {
////                    echo "Registration was Successful";
//                    $this->success = 'Registration was Successful';
//                } else {
//                    $this->error = 'Password dont match, else contact developer for help...';
////                    echo "Password dont match, else contact developer for help... ";
//                    // echo "Error: " . $stmt . "<br>" . $this->conn->error;
//                }
//            }
        } else {
            $_SESSION['error'] = "Mandatory field(s) are required";
        }
    }

    /**
     * logout method
     */
    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * @return bool
     * check if Admin is logged in
     */
    public function isLoggedIn()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            return true;
        }
    }


    //====================MEMBERS=====================//

    /**
     * @param null $limit
     * @return array
     * select the member with optional limit val
     */
    public function find($limit = null)
    {
        if ($limit == null) {
            $query_stmt = "SELECT * FROM " . $this->membersTable;
        } else {
            $query_stmt = "SELECT * FROM " . $this->membersTable . " LIMIT " . $limit;
        }

        $retval = $this->db->query($query_stmt);

        $users = array();

        if (!$retval) {
            echo "No memberTable found";
        } else {
            while ($data = $retval->fetch_assoc()) {
                array_push($users, $data);
            }
        }

        return $users;

    }

    /**
     * @return mixed
     * find a member by id;
     */
    public function findOne()
    {
        $query_stmt = "SELECT * FROM " . $this->memberTable . " WHERE id = '$this->member_id'";

        $retval = $this->db->query($query_stmt);

        if (!$retval) {
            echo "No memberTable found";
        } else {
            $data = $retval->fetch_assoc();
        }
        return $data;
    }


    public function createMember()
    {
        $now = new DateTime();
        $today = $now->format('Y-m-d');

        #check to see
        $stmt = "SELECT * FROM " . $this->membersTable . " WHERE lastname = '{$this->lastname}' AND id = '{$this->member_id}'";
        $retval = $this->db->query($stmt);
        $row = $retval->num_rows;
        if ($row == 1) {
            $_SESSION['error'] = "we can't add this member,already exist...";
        } else {

            if ($this->ImageUpload() == true) {
                $stmt2 = "INSERT INTO " . $this->membersTable . "(id,firstname,middlename,lastname,path,note,department_id, created_at)
                                              VALUES( '{$this->member_id}' , '{$this->firstname}', '{$this->middlename}','{$this->lastname}','{$this->newAvatarPath}', '{$this->note}','{$this->department_id}', '{$today}')";
                $val = $this->db->query($stmt2);

                if ($val) {
                    $_SESSION['success'] = "New Member was created";
                } else {
                    $_SESSION['error'] = "Failed adding a new user";
//                    echo "Error: " . $stmt2 . "<br>" . $this->db->error;
                }
            } else {
                $this->ImageUpload();
            }
        }
    }

    public function ImageUpload()
    {
        $allowedExts = array(
            "jpeg",
            "png",
            "jpg"
        );
        $allowedMimeTypes = array(
            'image/jpg',
            'image/jpeg'
        );

        $file_ext = explode(".", $this->path["name"]);
        $extension = strtolower(end($file_ext));


        if (($this->path["size"] <= 500000)) {
            if (in_array($extension, $allowedExts)) {
                // echo "file type with extension  <strong>" .$extension . "</strong>  is supported" ."<br>";
                if (file_exists("../public/images/avatar/" . $this->path["name"])) {
                    $_SESSION['error'] = $this->path["name"] . "  already exists";
                } else {

                    if (in_array($this->path["type"], $allowedMimeTypes)) {
                        $path = "../public/images/avatar/";

                        $path = $path . basename($this->path["name"]);
                        $this->newAvatarPath = $path;

                        if (move_uploaded_file($this->path['tmp_name'], $path)) {
                            return true;
                        }
                    } else {
                        $_SESSION['error'] = $this->path["name"] . " with extension " . $extension . " is not supported";
                    }
                }
            }
        } else {
            $_SESSION['error'] = $this->path["name"] . " is more than 5MB";
        }
    }


}
