<?php
class model_locationrack extends CI_Model
{
    
    function locationrack($last, $strat)
    {
        
        $query = $this->db->query("select * from tbl_location_rack where status='A' Order by id desc limit $strat,$last ");
        return $result = $query->result();
        
    }
    
    function locationracks()
    {
        
        $query = $this->db->query("select * from tbl_location_rack where status='A' Order by id desc");
        return $result = $query->result();
        
    }
    
    
    function filterListproduct($perpage, $pages, $get)
    {
        
        $qry = "select * from tbl_location_rack where status='A'";
        
        if (sizeof($get) > 0) {
            if ($get['location_rack_id'] != "") {
                
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue ='" . $get['location_rack_id'] . "'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND location_rack_id ='$sr_no2'";
                
            }
            
            if ($get['rack_name'] != "")
                $qry .= " AND rack_name LIKE '%" . $get['rack_name'] . "%'";
            
            
        }
        $qry .= " order by id desc limit $pages,$perpage";
        
        $data = $this->db->query($qry)->result();
        return $data;
        
    }
    
    
    function count_allproduct($tableName, $status = 0, $get)
    {
        $qry = "select count(*) as countval from tbl_location_rack where status='A'";
        
        if (sizeof($get) > 0) {
            if ($get['location_rack_id'] != "") {
                
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue ='" . $get['location_rack_id'] . "'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND location_rack_id ='$sr_no2'";
                
            }
            
            if ($get['rack_name'] != "")
                $qry .= " AND rack_name LIKE '%" . $get['rack_name'] . "%'";
            
        }
        
        $query = $this->db->query($qry, array(
            $status
        ))->result_array();
        return $query[0]['countval'];
        
    }
    
    
    
    
    
}
?>