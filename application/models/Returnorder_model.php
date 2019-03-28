<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Returnorder_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function item_return($sales_id){
        return $query = $this->db->query("SELECT oi.product_name, oi.product_code, oi.qty
        from order_items as oi inner join orders as o on oi.order_id=o.id
        where o.id = '$sales_id'")->result();
    }
}
