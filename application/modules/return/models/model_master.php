<?php
class model_master extends CI_Model
{
    
    
    
    function product_get($last, $strat)
    {
        
        //echo "select *from tbl_spare_return_hdr where status='A' Order by rflhdrid DESC limit $strat,$last ";
        $query = ("select *from tbl_spare_return_hdr where status='A' Order by rflhdrid DESC limit $strat,$last ");
        
        $getQuery = $this->db->query($query);
        return $result = $getQuery->result();
        
    }
    
    
    
    
    function filterListproduct($perpage, $pages, $get)
    {
        
        $qry = "select * from tbl_spare_return_hdr where status='A'";
        
        if (sizeof($get) > 0) {
            if ($get['rflhdrid'] != "")
                $qry .= " AND rflhdrid LIKE '%" . $get['rflhdrid'] . "%'";
            
            
            
            if ($get['return_date'] != "")
                $qry .= " AND return_date LIKE '%" . $get['return_date'] . "%'";
            
            if ($get['vendor_id'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%" . $get['vendor_id'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->contact_id;
                
                $qry .= " AND vendor_id ='$sr_no2'";
                
            }
            
            if ($get['po_no'] != "")
                $qry .= " AND po_no LIKE '%" . $get['po_no'] . "%'";
            
            if ($get['po_date'] != "")
                $qry .= " AND po_date LIKE '%" . $get['po_date'] . "%'";
            
            
            
            
        }
        $qry .= "  limit $pages,$perpage";
        
        $data = $this->db->query($qry)->result();
        return $data;
    }
    
    
    function count_allproduct($tableName, $status = 0, $get)
    {
        $qry = "select count(*) as countval from tbl_spare_return_hdr where status='A'";
        
        if (sizeof($get) > 0) {
            if ($get['rflhdrid'] != "")
                $qry .= " AND rflhdrid LIKE '%" . $get['rflhdrid'] . "%'";
            
            
            
            if ($get['return_date'] != "")
                $qry .= " AND return_date LIKE '%" . $get['return_date'] . "%'";
            
            
            if ($get['vendor_id'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_contact_m where first_name LIKE '%" . $get['vendor_id'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->contact_id;
                
                $qry .= " AND vendor_id ='$sr_no2'";
                
            }
            
            if ($get['po_no'] != "")
                $qry .= " AND po_no LIKE '%" . $get['po_no'] . "%'";
            
            if ($get['po_date'] != "")
                $qry .= " AND po_date LIKE '%" . $get['po_date'] . "%'";
            
            
            
            
        }
        $query = $this->db->query($qry, array(
            $status
        ))->result_array();
        return $query[0]['countval'];
        
    }
    
        
    
}
?>