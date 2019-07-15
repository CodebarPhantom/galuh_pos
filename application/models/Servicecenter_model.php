<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class servicecenter_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function record_service_count()
    {
        $this->db->order_by('id_service', 'DESC');
        $query = $this->db->get('service_center');
        $this->db->save_queries = false;

        return $query->num_rows();
    }

    public function fetch_service_data($limit, $start)
    {
        $this->db->order_by('id_service', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_center');

        $result = $query->result();

        $this->db->save_queries = false;

        return $result;
    }

    public function updateData($table, $upd_data, $id_service)
    {
        $this->db->where('id_service', $id_service);
        $this->db->update("$table", $upd_data);

        return true;
    }

    function SET_idservice() {
        $cek = $this->db->query("SELECT RIGHT(id_service,6) AS kode FROM service_center ORDER BY id_service DESC LIMIT 1");
        if($cek->num_rows() > 0) {
           foreach($cek->result() as $query) {
              $kode = ((int)$query->kode)+1;
           } 
        } else {
            $kode = 1;
        }

       $kodeunik = str_pad($kode,6,"0",STR_PAD_LEFT);
       
           return "SR".$kodeunik; 
       
    }

    public function deleteData($table, $id_service)
    {
        $this->db->where('id_service', $id_service);
        $this->db->delete("$table");

        return true;
    }

    public function invoice_print($id_service)
    {
        return $query = $this->db->query("SELECT sc.id_service, cu.fullname, sc.created_datetime, sc.updated_datetime, cu.mobile, sc.technician, sc.qty, sc.remark, sc.price, sc.status
        FROM service_center as sc join customers as cu on sc.id_customer = cu.id
     
        where sc.id_service = '$id_service'       
        ")->result();
    }
}
