<?php
class model_master extends CI_Model
{
    
    // function getSpareData()
    // {
    
    //     $this->db->select("*")
    //     ->from("tbl_machine_spare_map")
    //     ->where("status", 'A')
    //     ->where("machine_id",$_GET['id']);
    
    //     $this->db->order_by("id","desc");
    //     $query = $this->db->get();
    //     return $result=$query->result();  
    
    // }    
    
    function getMachineWarrantyData()
    {
        
        $this->db->select("*")->from("tbl_machine_warranty")->where("module_type", 'Machine')->where("warranty_log_id", $_GET['id']);
        
        $this->db->order_by("warranty_id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
        
    }
    
    function getMachineSuppliersData()
    {
        
        $this->db->select("*")->from("tbl_machine_suppliers")->where("status", 'A')->where("machine_id", $_GET['id']);
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
        
    }
    
    function getSpareDataunit()
    {
        
        $this->db->select("*")->from("tbl_machine_reading")->where("status", 'A')->where("machine_id", $_GET['id']);
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
        
    }
    
    
    public function count_machine1($table_name, $status, $get)
    {
        $query    = ("select count(*) as countval from $table_name where status='A'");
        $getQuery = $this->db->query($query);
        $result   = $getQuery->row_array();
        return $result['countval'];
    }
    
    
    function mod_productList($val)
    {
        
        //echo "select * from tbl_product_stock where productname like '%$val%'";
        $qry = $this->db->query("select productname,Product_id from tbl_product_stock where via_type='Spare' AND productname like '%$val%'")->result_array();
        // print_r($qry);
        return $qry;
        
    }
    
    //************************************************************************************
    
    
    function getMachineData($last, $strat)
    {
        
        /* $this->db->select("*")
        ->from("tbl_machine")
        ->where("status", 'A');
        $this->db->order_by("id", "desc");
        
        $query = $this->db->get();
        
        return $result=$query->result(); */
        
        $query    = ("select *from tbl_machine where status='A' Order by id DESC limit $strat,$last ");
        $getQuery = $this->db->query($query);
        return $result = $getQuery->result();
        
    }
    
    
    function filterMachine($last, $strat, $get)
    {
        
        $qry = "select * from tbl_machine where status = 'A'";
        
        if (sizeof($_GET) > 0) {
            
            if ($get['codee'] != "")
                $qry .= " AND code LIKE '%" . $get['codee'] . "%'";
            
            if ($get['m_type'] != "") {
                
                $unitQuery2 = $this->db->query("select * from  tbl_facilities where fac_name LIKE '%" . $get['m_type'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->id;
                
                $qry .= " AND m_type ='$sr_no2'";
                
            }
            
            if ($get['machine_name'] != "")
                $qry .= " AND machine_name LIKE '%" . $get['machine_name'] . "%'";
            
            if ($get['machine_description'] != "")
                $qry .= " AND machine_des LIKE '%" . $get['machine_description'] . "%'";
            
            if ($get['capacity'] != "")
                $qry .= " AND capacity LIKE '%" . $get['capacity'] . "%'";
            
        }
        
        $qry .= " Order by id DESC limit $strat,$last";
        
        $data = $this->db->query($qry)->result();
        return $data;
        
    }
    
    
    function count_machine($tableName, $status = 0, $get)
    {
        
        $qry = "select count(*) as countval from tbl_machine where status='A'";
        
        if (sizeof($_GET) > 0) {
            
            if ($get['codee'] != "")
                $qry .= " AND code LIKE '%" . $get['codee'] . "%'";
            
            if ($get['m_type'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_facilities where fac_name LIKE '%" . $get['m_type'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->id;
                
                $qry .= " AND m_type ='$sr_no2'";
                
            }
            
            if ($get['machine_name'] != "")
                $qry .= " AND machine_name LIKE '%" . $get['machine_name'] . "%'";
            
            if ($get['machine_description'] != "")
                $qry .= " AND machine_des LIKE '%" . $get['machine_description'] . "%'";
            
            if ($get['capacity'] != "")
                $qry .= " AND capacity LIKE '%" . $get['capacity'] . "%'";
            
        }
        
        $query = $this->db->query($qry, array(
            $status
        ))->result_array();
        return $query[0]['countval'];
        
    }
    
    
    function categorySelectbox($parent = 0, $spacing = '', $user_tree_array = '')
    {
        if (!is_array($user_tree_array))
            $user_tree_array = array();
        
        $sql   = "select * from tbl_category where status = 1 AND inside_cat = $parent";
        $query = $this->db->query($sql);
        $data  = $query->result_array();
        if (sizeof($data) > 0) {
            foreach ($data as $row) {
                // echo "<option>".$spacing . $row['name']."</option>";
                $user_tree_array[] = array(
                    "id" => $row['id'],
                    "name" => $spacing . $row['name'],
                    'praent' => $row['inside_cat']
                );
                $user_tree_array   = $this->categorySelectbox($row['id'], $spacing . '&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
            }
        }
        return $user_tree_array;
    }
    
    
}
?>