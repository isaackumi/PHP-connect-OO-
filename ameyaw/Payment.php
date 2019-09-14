<?php
/**
 * Created by PhpStorm.
 * User: cyber
 * Date: 11/20/2018
 * Time: 4:19 PM
 */

require_once 'Connection.php';

class Payment extends Connection
{

    public function __construct()
    {
        parent::connect();
    }

    public function sumPayment($today = null)
    {
        if ($today == null){
            $stmt = "SELECT SUM(amount) AS 'paymentAmount' FROM " . $this->paymentTable;
        }else {
            $stmt = "SELECT SUM(amount) AS 'paymentAmount' FROM " . $this->paymentTable . " WHERE created_at= '{$today}'";
        }

        $retval = $this->db->query($stmt);
        $data = $retval->fetch_assoc();
        return $data['paymentAmount'];
    }

}
