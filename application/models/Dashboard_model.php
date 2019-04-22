<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function pie_chart(){		
		$month = date('m');
		return $query = $this->db->query("SELECT o.product_name, sum(o.qty) as total 
		FROM order_items as o inner join products as p on o.product_code = p.code left join orders as r on o.order_id = r.id
        WHERE MONTH(r.ordered_datetime) = '$month'
        GROUP by o.product_name 
        order by total desc
        LIMIT 10")->result();	
    }
    
    public function pie_chart1(){		
		$month = date('m');
		return $query = $this->db->query("SELECT o.product_name, sum(o.qty)*o.price as total
        FROM order_items as o inner join products as p on o.product_code = p.code left join orders as r on o.order_id = r.id
                WHERE MONTH(r.ordered_datetime) = '$month'
                GROUP by o.product_name 
                order by total desc
                LIMIT 10")->result();	
    }
    
    public function todays_sales(){
        $today_date = date('Y-m-d');        
        return $query = $this->db->query("SELECT ifnull(sum(grandtotal),0) as todays_sales 
            FROM orders
            WHERE created_datetime >= '$today_date 00:00:00' AND created_datetime <= '$today_date 23:59:59'")->result();
    }

    public function todays_transaction(){
        $today_date = date('Y-m-d');        
        return $query = $this->db->query("SELECT count(id) as total_transaction
            FROM orders
            WHERE created_datetime >= '$today_date 00:00:00' AND created_datetime <= '$today_date 23:59:59'")->result();
    }
}
