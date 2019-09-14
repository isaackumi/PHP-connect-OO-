<?php
include "Connection.php";

class Department extends Connection
{

    public $name = null;
    public $note = null;
    public $status = 0;

    public function __construct()
    {
        parent::connect();
    }

    public function createDepartment()
    {
        $stmt_query = "SELECT * FROM " . $this->departmentTable . " WHERE name = '{$this->name}'";
        $check_retval = $this->db->query($stmt_query);
        $check_row = $check_retval->num_rows;

        if ($check_row == 1) {
            $_SESSION['error'] = "Department Name: " . $this->name . ' already exist. !';
        } else {
            $stmt = "INSERT INTO " . $this->departmentTable . "(name, status, note) VALUES('{$this->name}', '{$this->status}', '{$this->note}')";


            $retval = $this->db->query($stmt);

            if ($retval) {
                $_SESSION['success'] = "Department Name was added Successful";
            } else {
                $_SESSION['error'] = "Error: " . $stmt . "<br>" . $this->db->error;
            }
        }
    }

    public function displayDepartment()
    {
        $stmt = "SELECT * FROM " . $this->departmentTable;
        $retval = $this->db->query($stmt);

        $department = array();

        if (!$retval) {
            $_SESSION['error'] = "No table found";
        } else {
            while ($data = $retval->fetch_assoc()) {
                array_push($department, $data);
            }
        }

        return $department;
    }

    public function countDepartment()
    {
        $stmt = "SELECT COUNT(*) AS 'departmentCount' FROM " . $this->departmentTable;
        $retval = $this->db->query($stmt);
        $data = $retval->fetch_assoc();
        return $data['departmentCount'];
    }

}
