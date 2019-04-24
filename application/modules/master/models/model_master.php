<?php
class model_master extends CI_Model {
	
function productCatg_data()
{
	  $this->db->select("*");
	  // $this->db->order_by("prodcatg_id","desc");
      $this->db->from('tbl_prodcatg_mst');  
      $query = $this->db->get();

	  return $result=$query->result();  
}	


function model_spare_productList($val){
	//echo "select * from tbl_product_stock where productname like '%$val%'";
   $qry = $this->db->query("select productname,Product_id from tbl_product_stock where type = 'spare' and productname like '%$val%'")->result_array();
  // print_r($qry);
   return $qry;

}

function product_get($last,$strat)
{
	$query=("select * from tbl_product_stock where status='A' Order by Product_id DESC limit $strat,$last ");
	$getQuery = $this->db->query($query);
	return $result=$getQuery->result();
}

function getSpareData(){
	$this->db->select("*")
	->from("tbl_product_serial")
	->where("status", 'A')
	->where("product_id",$_GET['id']);

	$this->db->order_by("serial_number","desc");
    $query = $this->db->get();
    return $result=$query->result();  
}	

function filterListproduct($perpage,$pages,$get)
{
 	
	$qry ="select * from tbl_product_stock where status='A'";

	if(sizeof($get) > 0)
	{
		if($get['sku_no'] != "")
			$qry .= " AND sku_no LIKE '%".$get['sku_no']."%'";

		if($get['category'] != "")
		{
			$unitQuery2=$this->db->query("select * from  tbl_category where name LIKE '%".$get['category']."%'");
			$getUnit2=$unitQuery2->row();
			$sr_no2=$getUnit2->id;
			
			$qry .= " AND category ='$sr_no2'";
		}

		  if($get['type_of_spare'] != "")
			   {
				   $unitQuery=$this->db->query("select * from tbl_master_data where keyvalue LIKE '%".$get['type_of_spare']."%' and param_id='26'");
				   $getUnit=$unitQuery->row();
				   $sr_no=$getUnit->serial_number;
			 
				   $qry .= " AND type_of_spare ='$sr_no'";
				  
			   }
		
		if($get['productname'] != "")
			$qry .= " AND productname LIKE '%".$get['productname']."%'";


		if($get['usages_unit'] != "")
		{
			$unitQuery=$this->db->query("select * from tbl_master_data where keyvalue LIKE '%".$get['usages_unit']."%'");
			$getUnit=$unitQuery->row();
			$sr_no=$getUnit->serial_number;
		
			$qry .= " AND usageunit ='$sr_no'";
		}

		if($get['purchase_price'] != "")
			$qry .= " AND unitprice_purchase LIKE '%".$get['purchase_price']."%'";

	}
  	
	$qry .= "  limit $pages,$perpage";
   $data =  $this->db->query($qry)->result();
  return $data;

}


function count_allproduct($tableName,$status = 0,$get)
{
    $qry ="select count(*) as countval from tbl_product_stock where status='A'";
    
		if(sizeof($get) > 0)
		 {
			   if($get['sku_no'] != "")
				  $qry .= " AND sku_no LIKE '%".$get['sku_no']."%'";
			   
			   if($get['category'] != "")
			   {
				   $unitQuery2=$this->db->query("select * from  tbl_category where name LIKE '%".$get['category']."%'");
				   $getUnit2=$unitQuery2->row();
				   $sr_no2=$getUnit2->id;
			 
				   $qry .= " AND category ='$sr_no2'";
			   }
			   
			   
			   if($get['type_of_spare'] != "")
			   {
				   $unitQuery=$this->db->query("select * from tbl_master_data where keyvalue LIKE '%".$get['type_of_spare']."%'  and param_id='26'");
				   $getUnit=$unitQuery->row();
				   $sr_no=$getUnit->serial_number;
			 
				   $qry .= " AND type_of_spare ='$sr_no'";
				  
			   }
			   if($get['productname'] != "")
				  $qry .= " AND productname LIKE '%".$get['productname']."%'";
				  
			  
			   if($get['usages_unit'] != "")
			   {
				   $unitQuery=$this->db->query("select * from tbl_master_data where keyvalue LIKE '%".$get['usages_unit']."%'");
				   $getUnit=$unitQuery->row();
				   $sr_no=$getUnit->serial_number;
			 
				   $qry .= " AND usageunit ='$sr_no'";
				  
			   }
			   
				
			  if($get['purchase_price'] != "")
				  $qry .= " AND unitprice_purchase LIKE '%".$get['purchase_price']."%'";
				  
	       }
		   //echo $qry;
		 
	   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}



//****************************************************************************************************

function contact_get($last,$strat)
{
	$query=$this->db->query("select *from tbl_contact_m where status='A' ORDER BY contact_id DESC limit $strat,$last");
    return $result=$query->result();  
}


function filterContactList($perpage,$pages,$get)
{
	
    $qry = "select * from  tbl_contact_m where status = 'A'";

      if(sizeof($get) > 0)
	  {
        
		   if($get['first_namee'] != "")
		   		$qry .= " AND first_name LIKE '%".$get['first_namee']."%'";
			 
			/* if($get['contact_person'] != "")
		   	 $qry .= " AND contact_person LIKE '%".$get['contact_person']."%'";*/
           
		   if($get['phone'] != "")
		   		$qry .= " AND phone LIKE '%".$get['phone']."%'";
			  
		   if($get['mobile'] != "")
		   		$qry .= " AND mobile LIKE '%".$get['mobile']."%'";
			  
		   if($get['emailee'] != "")
		   		$qry .= " AND email LIKE '%".$get['emailee']."%'";
			
		   if($get['maingroupname'] != "")
		   {
				$unitQuery=$this->db->query("select * from tbl_account_mst where account_name LIKE '%".$get['maingroupname']."%'");
		     	$getUnit=$unitQuery->row();
		     	$sr_no=$getUnit->account_id;
		 
			  	$qry .= " AND group_name ='$sr_no'";
      		}
	   }
       
	    $qry .= " ORDER BY contact_id DESC limit $pages,$perpage";
    $data =  $this->db->query($qry)->result();
  return $data;

}

function count_contact($tableName,$status = 0,$get)
{
   $qry ="select count(*) as countval from $tableName where status='A'";
    
       if(sizeof($get) > 0)
	   {
        
		   if($get['first_namee'] != "")
		   		$qry .= " AND first_name LIKE '%".$get['first_namee']."%'";
			
		   /* if($get['contact_person'] != "")
		   	 $qry .= " AND contact_person LIKE '%".$get['contact_person']."%'";*/
           
		   if($get['phone'] != "")
		   		$qry .= " AND phone LIKE '%".$get['phone']."%'";
			  
		   if($get['mobile'] != "")
		  		$qry .= " AND mobile LIKE '%".$get['mobile']."%'";
			  
		   if($get['emailee'] != "")
		   		$qry .= " AND email LIKE '%".$get['emailee']."%'";
			
		   if($get['maingroupname'] != "")
		   {
				$unitQuery=$this->db->query("select * from tbl_account_mst where account_name LIKE '%".$get['maingroupname']."%'");
		   	    $getUnit=$unitQuery->row();
		        $sr_no=$getUnit->account_id;
		 
			    $qry .= " AND group_name ='$sr_no'";
           }
	  
	   }
	  // echo $qry;

	   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}

//*****************************************************************************************************

function category_all($last,$strat){
	$data="";
  /*echo "SELECT  id, name,name as text, inside_cat as parent_id ,create_on FROM tbl_category where status = 1 Order by id ASC limit $strat,$last";*/
  $result = $this->db->query("SELECT  id, name,name as text, inside_cat as parent_id ,create_on FROM tbl_category where status = 1 Order by id DESC limit $strat,$last")->result_array();
  if(sizeof($result ) > 0){
       return $result;
  }


}

 function insert_value($post){
  	 $data = date("Y-m-d"); 
     $sql  = "insert into tbl_category set name = ?,inside_cat = ?,create_on = ?";
    return $this->db->query($sql,array($post['category'],$post['selectCategory'],$data));
  
  }

  function tree_all(){
	   $data="";
       $result = $this->db->query("SELECT  id, name,name as text, inside_cat as parent_id ,create_on FROM tbl_category where status = 1 Order by id ASC")->result_array();
        foreach ($result as $row) {
           $data[] = $row;
       }
     return $data;
  }

function get_child_data($id = 0,$spacing = '',$user_tree_array = ''){
      if (!is_array($user_tree_array))
          $user_tree_array = array(); 

          $sql   = "select * from tbl_category where  inside_cat = $id";
          $query = $this->db->query($sql);
          $data  = $query->result_array();

        if (sizeof($data) > 0) {
         foreach($data as $row) {
            // echo "<option>".$spacing . $row['name']."</option>";
            $user_tree_array[] = array("id" => $row['id'],"name" => $spacing.$row['name']);
            $user_tree_array   = $this->get_child_data($row['id'],$spacing . '&nbsp;&nbsp;&nbsp;&nbsp;',$user_tree_array);
         }
       }

      return $user_tree_array;
    }

     function delete_data($id,$arr){
       foreach ($arr as $key => $value) {
         $qry = "update tbl_category set status = 0  WHERE id = ?";
         $this->db->query($qry,array($value['id']));
       }
         $qry = "update tbl_category set status = 0  WHERE id = $id";
         $this->db->query($qry);

    }

    function categorySelectbox($parent = 0, $spacing = '', $user_tree_array = ''){
      if (!is_array($user_tree_array))
        $user_tree_array = array();
   
        $sql = "select * from tbl_category where status = 1 AND inside_cat = $parent";
        $query = $this->db->query($sql);
        $data  = $query->result_array();
         if (sizeof($data) > 0) {
           foreach($data as $row) {
             // echo "<option>".$spacing . $row['name']."</option>";
             $user_tree_array[] = array("id" => $row['id'], "name" => $spacing . $row['name'],'praent' => $row['inside_cat']);
             $user_tree_array = $this->categorySelectbox($row['id'],$spacing . '&nbsp;&nbsp;&nbsp;&nbsp;',$user_tree_array);
           }
         }
       return $user_tree_array;
     }

     function treeGetParentid($id = 0, $user_tree_array = ''){

        if (!is_array($user_tree_array))
            $user_tree_array = array(); 

            $sql   = "select * from tbl_category where  id = $id";
            $query = $this->db->query($sql);
            $data  = $query->result_array();
        if (sizeof($data) > 0) {
           foreach($data as $row) {
             $user_tree_array   = $this->treeGetParentid($row['inside_cat']);
             if($row['inside_cat'] == 0){
              return $row['id'];  
             }
           }
        }
       return $user_tree_array;
    } 

   function treeGetParentValue($id = 0, $user_tree_array = ''){
       if (!is_array($user_tree_array))
            $user_tree_array = array(); 

            $sql   = "select * from tbl_category where  id =$id";
            $query = $this->db->query($sql);
            $data  = $query->result_array();

          if (sizeof($data) > 0) {
           foreach($data as $row) {
              $user_tree_array[] = array("id" => $row['inside_cat'],'name'=>$row['name']);
              $user_tree_array   = $this->treeGetParentValue($row['inside_cat'],$user_tree_array);
           }
         }
       return $user_tree_array;
    }

 function count_allCat($tableName,$status = 0,$get){
   $qry ="select count(*) as countval from $tableName where status= ?";
    if($get['filtername']!="" || $get['filterdate']!="" ){
      if($get['filtername']!="")
         $qry .= " AND name LIKE '%".$get['filtername']."%'";

      if($get['filterdate']!="")
         $qry .= " AND create_on ='".$get['filterdate']."'";
  }
   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];
}

 function fetch_sparePriceMapping(){
   $qry = "select * from tbl_vendor_spare_price_map VM, tbl_product_stock S where  S.Product_id = VM.spare_id  AND S.status= 'A'";
   return $query=$this->db->query($qry)->result_array();
 }

  function edit_Category($post){
          $qry = "update tbl_category set name = ?,inside_cat=?  WHERE id = ?";
          $this->db->query($qry,array($post['category'],$post['selectCategory'],$post['edit']));
    }



function count_product($tableName,$status = 0,$get)
{

   $qry ="select count(*) as countval from $tableName where status='A'";
    
		if(sizeof($get) > 0)
		 {
			   if($get['sku_no'] != "")
			   		$qry .= " AND sku_no LIKE '%".$get['sku_no']."%'";
			   
			   if($get['type'] != "")
			   {
				   $unitQuery=$this->db->query("select * from tbl_master_data where keyvalue LIKE '%".$get['type']."%'");
				   $getUnit=$unitQuery->row();
				   $sr_no=$getUnit->serial_number;
			 
				   $qry .= " AND type ='$sr_no'";
			   }
				 
			   if($get['category'] != "")
			   {
				   $unitQuery2=$this->db->query("select * from tbl_prodcatg_mst where prodcatg_name LIKE '%".$get['category']."%'");
				   $getUnit2=$unitQuery2->row();
				   $sr_no2=$getUnit2->prodcatg_id;
			 
				   $qry .= " AND category ='$sr_no2'";
			   }
			   
			   if($get['productname'] != "")
				   $qry .= " AND productname LIKE '%".$get['productname']."%'";
				  
			   
			   if($get['usages_unit'] != "")
			   {
				   $unitQuery=$this->db->query("select * from tbl_master_data where keyvalue LIKE '%".$get['usages_unit']."%'");
				   $getUnit=$unitQuery->row();
				   $sr_no=$getUnit->serial_number;
			 
				   $qry .= " AND usageunit ='$sr_no'";
			   }
				
			   if($get['purchase_price'] != "")
				   $qry .= " AND unitprice_purchase LIKE '%".$get['purchase_price']."%'";
				  
			   if($get['sale_price'] != "")
				   $qry .= " AND unitprice_sale LIKE '%".$get['sale_price']."%'";
				  
	     }
		 
	   $query=$this->db->query($qry,array($status))->result_array();
   return $query[0]['countval'];

}

function mod_productmapData($id){ 
    echo $qry   = "select * from tbl_vendor_spare_price_map where vendor_id = $id"; 
	$query = $this->db->query($qry,array($id))->result_array();
	print_r($query);
	return $query;
}



function mod_viewItem($id){ ///tbl_master_data L  find_in_set(M.location,L.serial_number)
	   //echo "select * from tbl_product_mapping M,tbl_product_stock S where S.Product_id = M.product_id AND S.Product_id = $id";
       $query     = $this->db->query("select * from tbl_machine_spare_map where status = 'A'");
       $resultHdr = $query->row_array();
       if(sizeof($resultHdr) > 0){
        // echo "<pre>";
        //   print_r($resultHdr);
        // echo  "</pre>";
     	return $resultHdr;
      }

      return "";

	}


function getPartsWarrantyData()
{

	$this->db->select("*")
	->from("tbl_machine_warranty")
	->where("module_type", 'Parts_Supplies')
	->where("warranty_log_id",$_GET['id']);

	$this->db->order_by("warranty_id","desc");
    $query = $this->db->get();
    return $result=$query->result();  

}


} ?>