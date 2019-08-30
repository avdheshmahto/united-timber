<?php
class model_master_facilities extends CI_Model
{
    
    function getfacilityData($last, $strat)
    {
        //echo "select *from tbl_machine_breakdown where status='A' Order by id DESC limit $strat,$last ";
        $query    = ("select *from tbl_facilities where status='A' Order by id DESC limit $strat,$last ");
        $getQuery = $this->db->query($query);
        
        return $result = $getQuery->result();
        //echo $result;
    }
    
    
    function filterListfacility($perpage, $pages, $get)
    {
        
        $qry = "select * from tbl_facilities where status='A'";
        
        if (sizeof($get) > 0) {
            
            if ($get['fac_loc'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['fac_loc'] . "%'  and param_id='21'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND fac_loc ='$sr_no2'";
                
            }
            
            if ($get['fac_code'] != "")
                $qry .= " AND fac_code LIKE '%" . $get['fac_code'] . "%'";
            
            
            if ($get['fac_name'] != "")
                $qry .= " AND fac_name LIKE '%" . $get['fac_name'] . "%'";
            
        }
        
        $qry .= "  limit $pages,$perpage";
        $data = $this->db->query($qry)->result();
        return $data;
        
    }
    
    
    
    function count_allfacility($tableName, $status = 0, $get)
    {
        
        $qry = "select count(*) as countval from tbl_facilities where status='A'";
        
        if (sizeof($get) > 0) {
            
            if ($get['fac_loc'] != "") {
                
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['fac_loc'] . "%'  and param_id='21'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND fac_loc ='$sr_no2'";
                
            }
            
            
            if ($get['fac_code'] != "")
                $qry .= " AND fac_code LIKE '%" . $get['fac_code'] . "%'";
            
            
            if ($get['fac_name'] != "")
                $qry .= " AND fac_name LIKE '%" . $get['fac_name'] . "%'";
            
        }
        
        $query = $this->db->query($qry, array(
            $status
        ))->result_array();
        return $query[0]['countval'];
        
    }
    
    
    
    
    
    
    function getSpareData()
    {
        
        $this->db->select("*")->from("tbl_machine_spare_map")->where("status", 'A')->where("machine_id", $_GET['id']);
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
        
    }
    
    public function count_machine($table_name, $status, $get)
    {
        $query    = ("select count(*) as countval from $table_name where status='A'");
        $getQuery = $this->db->query($query);
        $result   = $getQuery->row_array();
        return $result['countval'];
    }
    
    
    function mod_productList($val)
    {
        
        //echo "select * from tbl_product_stock where productname like '%$val%'";
        $qry = $this->db->query("select productname,Product_id from tbl_product_stock where productname like '%$val%'")->result_array();
        // print_r($qry);
        return $qry;
        
    }
    
    
    function filterMachine($last, $strat, $get)
    {
        
        $qry = "select * from tbl_machine where status = 'A'";
        
        if (sizeof($get) > 0) {
            
            if ($get['Code'] != "")
                $qry .= " AND Code LIKE '%" . $get['Code'] . "%'";
            
            if ($get['m_type'] != "")
                $qry .= " AND m_type LIKE '%" . $get['m_type'] . "%'";
            
            if ($get['machine_name'] != "")
                $qry .= " AND machine_name LIKE '%" . $get['machine_name'] . "%'";
            
            if ($get['machine_description'] != "")
                $qry .= " AND machine_des LIKE '%" . $get['machine_description'] . "%'";
            
            if ($get['capacity'] != "")
                $qry .= " AND capacity LIKE '%" . $get['capacity'] . "%'";
            
        }
        
        $qry .= " limit $strat,$last";
        
        $data = $this->db->query($qry)->result();
        return $data;
        
    }
    
    
    
}
?>