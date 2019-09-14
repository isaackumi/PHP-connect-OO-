<?php
/**
 * Created by PhpStorm.
 * User: cyber
 * Date: 11/21/2018
 * Time: 6:28 AM
 */
include_once 'Connection.php';

class PaymentType extends Connection
{
    public $name = null;
    public $note = null;
//    public $status = null;
    public $paymentTypeTable = "tbl_types";

    public function __construct()
    {
        parent::connect();
    }

    public function createPayment()
    {

        $stmt_query = "SELECT * FROM " . $this->paymentTypeTable . " WHERE name = '{$this->name}'";
        $check_retval = $this->db->query($stmt_query);
        $check_row = $check_retval->num_rows;

        if ($check_row == 1) {
            $_SESSION['error'] = "Payment Type: " . $this->name . ' already exist. !';
        } else {
            $stmt = "INSERT INTO " . $this->paymentTypeTable . "(name, note) VALUES('{$this->name}', '{$this->note}')";


            $retval = $this->db->query($stmt);

            if ($retval) {
                $_SESSION['success'] = "Payment Type was added Successful";
            } else {
                $_SESSION['error'] = "Error: " . $stmt . "<br>" . $this->db->error;
                //'Failed adding Payment Type, something went wrong';
            }
        }
    }

    public function countPaymentType()
    {
        $stmt = "SELECT COUNT(*) AS 'paymentTypeCount' FROM " . $this->paymentTypeTable;
        $retval = $this->db->query($stmt);
        $data = $retval->fetch_assoc();
        return $data['paymentTypeCount'];
    }

    public function find($limit = null)
    {
        if ($limit == null) {
            $query_stmt = "SELECT * FROM " . $this->paymentTypeTable;
        } else {
            $query_stmt = "SELECT * FROM " . $this->paymentTypeTable . " LIMIT " . $limit;
        }

        $retval = $this->db->query($query_stmt);

        $users = array();

        if (!$retval) {
            echo "No Payment Table found";
        } else {
            while ($data = $retval->fetch_assoc()) {
                array_push($users, $data);
            }
        }

        return $users;

    }
}
