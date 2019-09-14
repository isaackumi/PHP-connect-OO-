<?php
/**
 * Created by PhpStorm.
 * User: cyber
 * Date: 11/20/2018
 * Time: 4:19 PM
 */

require_once 'Connection.php';

class UserPayment extends Connection
{
    public $created_at = null;
    public $id = null;
    public $payment_type_id = null;
    public $date = null;
    public $amount = null;
    public $note = null;
    public $endPaymentDate = null;




    public function __construct()
    {
        parent::connect();
    }

    public function find($today = null)
    {
//        SELECT tbl_members.*, tbl_payments.*,
// tbl_types.name as pay_type
// FROM tbl_members INNER JOIN tbl_payments ON tbl_members.id = tbl_payments.user_id
//  INNER JOIN tbl_types ON tbl_types.id = tbl_payments.payment_type_id
// WHERE tbl_members.id=tbl_payments.user_id AND tbl_payments.created_at='2018-11-23'


        if ($today == null) {
            $query_stmt = "SELECT " . $this->membersTable . ".*, ".$this->paymentTypeTable.".name as paytype, " . $this->paymentTable . ".* FROM " . $this->membersTable . " INNER JOIN " . $this->paymentTable . " ON " . $this->membersTable . ".id = " . $this->paymentTable . ".user_id INNER JOIN ".$this->paymentTypeTable." ON ".$this->paymentTypeTable.".id = ".$this->paymentTable.".payment_type_id WHERE " . $this->membersTable . ".id=" . $this->paymentTable . ".user_id";
        } else {
            $query_stmt = "SELECT " . $this->membersTable . ".*, ".$this->paymentTypeTable.".name as paytype, " . $this->paymentTable . ".* FROM " . $this->membersTable . " INNER JOIN " . $this->paymentTable . " ON " . $this->membersTable . ".id = " . $this->paymentTable . ".user_id INNER JOIN ".$this->paymentTypeTable." ON ".$this->paymentTypeTable.".id = ".$this->paymentTable.".payment_type_id WHERE " . $this->membersTable . ".id=" . $this->paymentTable . ".user_id AND " . $this->paymentTable . ".created_at='{$today}'";
        }

        $retval = $this->db->query($query_stmt);

        $users = array();

        if (!$retval) {
            echo "No Table found";
        } else {
            while ($data = $retval->fetch_assoc()) {
                array_push($users, $data);
            }
        }

        return $users;

    }


    public function createPayment()
    {
        $now = new DateTime();
        $today = $now->format('Y-m-d');

        $stmt2 = "INSERT INTO " . $this->paymentTable . "(user_id, payment_date, note, payment_type_id, amount,end_Payment_date, created_at)
                  VALUES( '{$this->id}' , '{$this->date}', '{$this->note}','{$this->payment_type_id}','{$this->amount}','{$this->endPaymentDate}' , '{$today}')";

        $val = $this->db->query($stmt2);

        if ($val) {
            $_SESSION['success'] = "New Payment Made";
        } else {
            $_SESSION['error'] = "Failed adding a new payment";
//                    echo "Error: " . $stmt2 . "<br>" . $this->db->error;
        }
    }

}
