<?php
class model_master_section extends CI_Model
{
    
    function category_all($last, $strat)
    {
        $data   = "";
        $result = $this->db->query("SELECT  id, name,name as text, inside_cat as parent_id ,create_on,type,grade FROM tbl_category where status = 1 Order by id DESC limit $strat,$last")->result_array();
        if (sizeof($result) > 0) {
            return $result;
        }
    }
    
    
    function insert_value($post)
    {
        
        //print_r($post);die;
        $data = date('Y-m-d');
        $sql  = "insert into tbl_category set name = ?,inside_cat = ?,create_on = ?";
        $this->db->query($sql, array(
            $post['category'],
            $post['selectCategory'],
            $data
        ));

        $lastId=$this->db->insert_id();
        $this->software_log_insert($lastId, 'Section Created');
        
    }
    
    
    function tree_all()
    {
        $data   = array();
        $result = $this->db->query("SELECT  id, name,name as text, inside_cat as parent_id ,create_on FROM tbl_category where status = 1 Order by id ASC")->result_array();
        foreach ($result as $row) {
            $data = $row;
        }
        return $data;
    }
    
    function edit_Category($post)
    {
        $qry = "update tbl_category set name = ?,inside_cat=?,type = ?,grade = ?  WHERE id = ?";
        $this->db->query($qry, array(
            $post['category'],
            $post['selectCategory'],
            $post['typeid'],
            $post['grade'],
            $post['edit']
        ));
    }
    
    function get_child_data($id = 0, $spacing = '', $user_tree_array = '')
    {
        if (!is_array($user_tree_array))
            $user_tree_array = array();
        
        $sql   = "select * from tbl_category where  inside_cat = $id";
        $query = $this->db->query($sql);
        $data  = $query->result_array();
        
        if (sizeof($data) > 0) {
            foreach ($data as $row) {
                // echo "<option>".$spacing . $row['name']."</option>";
                $user_tree_array[] = array(
                    "id" => $row['id'],
                    "name" => $spacing . $row['name']
                );
                $user_tree_array   = $this->get_child_data($row['id'], $spacing . '&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
            }
        }
        
        return $user_tree_array;
    }
    
    function delete_data($id, $arr)
    {
        foreach ($arr as $key => $value) {
            $qry = "update tbl_category set status = 0  WHERE id = ?";
            $this->db->query($qry, array(
                $value['id']
            ));
        }
        $qry = "update tbl_category set status = 0  WHERE id = $id";
        $this->db->query($qry);
        
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
    
    
    function treeGetParentid($id = 0, $user_tree_array = '')
    {
        
        if (!is_array($user_tree_array))
            $user_tree_array = array();
        
        $sql   = "select * from tbl_category where  id = $id";
        $query = $this->db->query($sql);
        $data  = $query->result_array();
        if (sizeof($data) > 0) {
            foreach ($data as $row) {
                $user_tree_array = $this->treeGetParentid($row['inside_cat']);
                if ($row['inside_cat'] == 0) {
                    return $row['id'];
                }
            }
        }
        return $user_tree_array;
    }
    
    
    function treeGetParentValue($id = 0, $user_tree_array = '')
    {
        
        if (!is_array($user_tree_array))
            $user_tree_array = array();
        
        $sql   = "select * from tbl_category where  id =$id";
        $query = $this->db->query($sql);
        $data  = $query->result_array();
        
        if (sizeof($data) > 0) {
            foreach ($data as $row) {
                $user_tree_array[] = array(
                    "id" => $row['inside_cat'],
                    'name' => $row['name']
                );
                $user_tree_array   = $this->treeGetParentValue($row['inside_cat'], $user_tree_array);
            }
        }
        return $user_tree_array;
    }
    
    function count_all($tableName, $status = 0, $get)
    {
        
        $qry = "select count(*) as countval from $tableName where status= ?";
        
        if ($get['filtername'] != "" || $get['filterdate'] != "" || $get['filtertype'] != '') {
            if ($get['filtername'] != "")
                $qry .= " AND name LIKE '%" . $get['filtername'] . "%'";
            
            if ($get['filterdate'] != "")
                $qry .= " AND create_on ='" . $get['filterdate'] . "'";
            
            if ($get['filtertype'] != "")
                $qry .= " AND type ='" . $get['filtertype'] . "'";
            
        }
        
        $query = $this->db->query($qry, array(
            $status
        ))->result_array();
        return $query[0]['countval'];
    }
    
  
public function software_log_insert($log_id,$log_type)
{

    $table_name='tbl_software_log';
    date_default_timezone_set("Asia/Kolkata");
    $dtTime = date('Y-m-d G:i:s');

        $data=array(
            
            'log_id'      => $log_id,
            'log_type'    => $log_type,

        );

        $sess = array(
                    
                    'maker_id'    => $this->session->userdata('user_id'),
                    'maker_date'  => $dtTime,
                    'author_id'   => $this->session->userdata('user_id'),
                    'author_date' => date('Y-m-d'),
                    
                    'status'  => 'A',
                    'comp_id' => $this->session->userdata('comp_id'),
                    'zone_id' => $this->session->userdata('zone_id'),
                    'brnh_id' => $this->session->userdata('brnh_id'),
                    'divn_id' => $this->session->userdata('divn_id')
        );

        $data_merge = array_merge($data,$sess); 
        $this->Model_admin_login->insert_user($table_name,$data_merge);
        return;

} 



   
    
} /// End Class ///
?>