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
}
