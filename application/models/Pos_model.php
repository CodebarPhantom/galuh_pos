<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function invoice_print($order_id)
    {
        return $query = $this->db->query("SELECT
        o.ordered_datetime,o.customer_name,o.customer_mobile,o.outlet_id,o.subtotal,o.discount_total,o.tax,o.grandtotal,
        o.payment_method,o.payment_method_name,o.paid_amt,o.return_change,o.cheque_number,
        o.discount_percentage,o.outlet_name,o.outlet_address,o.outlet_contact,
        o.gift_card,o.card_number,o.outlet_receipt_footer,o.remark,u.fullname as cashier
        FROM orders as o 
        INNER JOIN users as u ON o.created_user_id = u.id
        where o.id = '$order_id'       
        ")->result();
    }

    public function tab_category(){
        return $query = $this->db->query("SELECT * FROM category where status = '1'
        ORDER BY name + 0 ASC ")->result();
    }
}
