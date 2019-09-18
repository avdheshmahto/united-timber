<?php
class model_master_breakdown extends CI_Model
{
    
    
    
    function getScheduledData()
    {
        
        $this->db->select("*")->from("tbl_schedule_triggering")->where("status", 'A')->where("schedule_id", $_GET['id']);
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
    }
    
    
    function getmeter_currentData()
    {
        
        $this->db->select("*")->from("tbl_machine_spare_unit_map")->where("status", 'A')->where("machine_id", $_GET['pri_id_meter']);
        
        $this->db->order_by("pri_id_meter", "desc");
        $query = $this->db->get();
        return $result = $query->result();
    }
    
    
    function getScheduledmeterData()
    {
        
        $this->db->select("*")->from("tbl_schedule_triggering")->where("status", 'A')->where("schedule_id", $_GET['id']);
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
    }
    
    function get_spare_trigger_code()
    {
        $query    = ("select *from tbl_schedule_spare_triggeringwhere schedule_id = '$schedule_id' and status = 'A' GROUP BY trigger_code ");
        $getQuery = $this->db->query($query);
        return $result = $getQuery->result();
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
        $qry = $this->db->query("select productname,Product_id from tbl_product_stock where productname like '%$val%'")->result_array();
        // print_r($qry);
        return $qry;
        
    }
    
    
    function getbreakdownData()
    {
        
        $this->db->select("*")->from("tbl_work_order_maintain")->where("status", 'A')->where("schedule_id", $_GET['id'])->where("id", $_GET['id']);
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $result = $query->result();
    }
    
    
    //*********************************************************************************************************************************************************************************************
    
    
    function getScheduleData($last, $strat)
    {
        
        
        $query    = ("select *from tbl_work_order_maintain where status='A' Order by id DESC limit $strat,$last ");
        $getQuery = $this->db->query($query);
        return $result = $getQuery->result();
    }
    
    
    
    
    function filterSchedule($last, $strat, $get)
    {
        $qry = "select * from tbl_work_order_maintain where status = 'A'";
        if (sizeof($_GET) > 0) {
            
            if ($get['codee'] != "")
                $qry .= " AND code LIKE '%" . $get['codee'] . "%'";
            
            if ($get['m_type'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_facilities where fac_name LIKE '%" . $get['m_type'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->id;
                
                $qry .= " AND m_type ='$sr_no2'";
                
            }
            
            
            if ($get['machine_namee'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_machine where machine_name LIKE '%" . $get['machine_namee'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->id;
                
                $qry .= " AND machine_name ='$sr_no2'";
                
            }
            
            if ($get['wostatus'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['wostatus'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND wostatus ='$sr_no2'";
                
            }
            
            if ($get['priority'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['priority'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND priority ='$sr_no2'";
                
            }
            
            
            if ($get['maintyp'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['maintyp'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND maintyp ='$sr_no2'";
                
            }
        }
        $qry .= " limit $strat,$last";
        
        $data = $this->db->query($qry)->result();
        return $data;
        
    }
    function count_schedule($tableName, $status = 0, $get)
    {
        $qry = "select count(*) as countval from tbl_work_order_maintain where status='A'";
        
        
        if (sizeof($_GET) > 0) {
            
            if ($get['codee'] != "")
                $qry .= " AND code LIKE '%" . $get['codee'] . "%'";
            
            if ($get['m_type'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_facilities where fac_name LIKE '%" . $get['m_type'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->id;
                
                $qry .= " AND m_type ='$sr_no2'";
                
            }
            
            
            if ($get['machine_namee'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_machine where machine_name LIKE '%" . $get['machine_namee'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->id;
                
                $qry .= " AND machine_name ='$sr_no2'";
                
            }
            
            if ($get['wostatus'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['wostatus'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND wostatus ='$sr_no2'";
                
            }
            
            if ($get['priority'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['priority'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND priority ='$sr_no2'";
                
            }
            
            
            if ($get['maintyp'] != "") {
                $unitQuery2 = $this->db->query("select * from  tbl_master_data where keyvalue LIKE '%" . $get['maintyp'] . "%'");
                $getUnit2   = $unitQuery2->row();
                $sr_no2     = $getUnit2->serial_number;
                
                $qry .= " AND maintyp ='$sr_no2'";
                
            }
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