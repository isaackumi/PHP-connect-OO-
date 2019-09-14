<?php
/**
 * Created by PhpStorm.
 * User: cyber
 * Date: 11/20/2018
 * Time: 3:59 PM
 */

class Connection
{
    /**
     * @var null
     * property  db to keep mysql object
     */
    public $db = null;
    public $departmentTable = "tbl_departments";
    public $adminTable = "tbl_admins";
    public $membersTable = "tbl_members";
    public $paymentTable = "tbl_payments";
    public $paymentTypeTable = "tbl_types";
    public $error = [];
    public $success = [];


    /**
     * Connection constructor.
     * call the connect() automatically when class is instantiated
     */
    public function __construct()
    {
        $this->connect();
        session_start();
    }

    /**
     * @param $statement
     */
    public function toSQL($statement)
    {
        echo $statement;
    }


    /**
     * @return bool
     * algorithm to connect to database server
     */
    public function connect()
    {
        // connect to server
        $this->db = new mysqli('localhost', 'root', '', 'church_io');

        // return true or false in connected to database server
        return ($this->db) ? true : false;
    }

    /**
     * @param null $url
     * redirect method
     */
    public function redirect($url = null)
    {
        if (!headers_sent()) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location:' . $url); //redirect to intended;
            header('Connection: close');
            exit;
        } else {
            echo "Location replace('.$url.');";
        }
        exit;
    }

    //you can write your own method to disconnect to database;
}
