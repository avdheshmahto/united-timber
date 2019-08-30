<?php
class model_admin extends CI_Model
{
    
    function master_data($last, $strat)
    {
        
        // $this->db->select("*");      
        //    $this->db->from('tbl_master_data');
        //    $this->db->order_by("serial_number","desc");
        //    $this->db->limit($strat, $last);  
        //    $query = $this->db->get();
        
        $query = $this->db->query("select * from tbl_master_data where status='A' AND param_id!='21' order by serial_number desc limit $strat,$last");
        
        return $result = $query->result();
    }
    
    function countMasterData($tableName, $status, $get)
    {
        //$this->db->select("count(*) as countval");      
        //$this->db->from('tbl_master_data');
        // $this->db->order_by("serial_number","desc");
        // $this->db->limit($strat, $last);  
        //$query = $this->db->get();
        $qry = "select count(*) as countval from tbl_master_data where status='A' AND param_id!='21'";
        
        $query = $this->db->query($qry, array(
            $status
        ))->result_array();
        return $query[0]['countval'];
        //return $result=$query->num_rows();  
    }
    
    
    function product_get()
    {
        
        $query = $this->db->query("select * from tbl_product_stock where status='A'");
        return $result = $query->result();
    }
    
    
}