<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function record_promotion_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('promotion');
        $this->db->save_queries = false;

        return $query->num_rows();
    }

    public function fetch_promotion_data($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('promotion');

        $result = $query->result();

        $this->db->save_queries = false;

        return $result;
    }

    public function updateData($table, $upd_data, $id_promo)
    {
        $this->db->where('id', $id_promo);
        $this->db->update("$table", $upd_data);

        return true;
    }
}
