<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
        public function category_asc(){
            return $query = $this->db->query("SELECT * FROM category where status = '1'
            ORDER BY name ASC ")->result();
        }
    
}
