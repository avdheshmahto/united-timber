<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Item extends my_controller {


function __construct()
{
  		parent::__construct(); 
  		$this->load->library('pagination');
    	$this->load->model('model_master');	
		// load Employee Model
    	//$this->load->model('Employee_model', 'employee');
}

function get_rack()
{
	
	$data=array(
	'id' => $_GET['con'] 
	);
	$this->load->view('Item/get-rack',$data);
	
}
	
public function manage_item_map()
{
	
	if($this->session->userdata('is_logged_in'))
	{
		$data=$this->user_function();// call permission fnctn
		$data['result'] = $this->model_master->getSpareData();
		$this->load->view('Item/manage-item-map',$data);
	}
	else
	{
		redirect('index');
	}

}


public function updateItem()
{

	if($this->session->userdata('is_logged_in'))
	{
		$data['ID'] = $_GET['ID'];
		$this->load->view('/Item/edit-item',$data);
	}
	else
	{
	redirect('index');
	}

}

public function edit_map_item()
{
	
	$data=array(
	'id' => $_GET['id'],
	'type' => $_GET['type']
	);	
	//print_r($data);
	$this->load->view("Item/edit-item-mapp",$data);	
	
}


public function manage_item()
{

	 if($this->session->userdata('is_logged_in'))
	 {		
		$data = $this->manageItemJoinfun();	
		$this->load->view('Item/manage-item',$data);
	}
	else
	{
		redirect('index');
	}
		
}

public function manageItemJoinfun()
{
    
	  $table_name='tbl_product_stock';
	  $data['result'] = "";
	  ////Pagination start ///
	  $url   = site_url('/master/Item/manage_item?');
	  $sgmnt = "4";

	  if($_GET['entries']!="")
	  	$showEntries = $_GET['entries'];
	  else
	  	$showEntries = 10;
	 
	 
	 $totalData   = $this->model_master->count_allproduct($table_name,'A',$this->input->get());

	  
	  if($_GET['entries']!="" && $_GET['filter'] == ""){
		 $url   = site_url('/master/Item/manage_item?entries='.$_GET['entries']);
	  }elseif($_GET['filter'] != ""){
	  	 $url   = site_url('/master/Item/manage_item?entries='.$_GET['entries'].'&sku_no='.$_GET['sku_no'].'&category='.$_GET['category'].'&type_of_spare='.$_GET['type_of_spare'].'&productname='.$_GET['productname'].'&usages_unit='.$_GET['usages_unit'].'&purchase_price='.$_GET['purchase_price'].'&filter='.$_GET['filter']);
	  	 // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
	  }

	  $pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
      $data       = $this->user_function();
      //////Pagination end ///
		  $data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	  $data['pagination']        = $this->pagination->create_links();
	
	  if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
		$data['result']          = $this->model_master->filterListproduct($pagination['per_page'],$pagination['page'],$this->input->get());
	  else	
		$data['result']          = $this->model_master->product_get($pagination['per_page'],$pagination['page']);

      // call permission fnctn
      return $data;

}



//============================================================================================

public function insert_item()
{
	
		@extract($_POST);
		
		$table_name = 'tbl_product_stock';
		$pri_col    = 'Product_id';
	 	$id         = $this->input->post('Product_id');
		
		$supp_name  = $this->input->post('vendor_name');
		$via_type   = $this->input->post('sub_type');
		$price      = $this->input->post('unitprice_purchase');
		/*echo "id=".$id;die;*/		
        
        $data= array(
        	 'sku_no'             => $this->input->post('sku_no'),
			 'productname'        => $this->input->post('item_name'),
			 'type_of_spare'	  => $this->input->post('type_of_spare'),
			 'priority'			  => $this->input->post('priority'),
			 'usageunit'          => $this->input->post('unit'),
			 'unitprice_purchase' => $this->input->post('unitprice_purchase'),
			 'supp_name'          => $this->input->post('vendor_name'),
			 'via_type'			  => $this->input->post('sub_type'),
			 'min_order'		  => $this->input->post('min_order'),
			 'min_re_order_level' => $this->input->post('min_re_order_level'),
		  );
         
         $sesio = array(
         	'maker_id'    => $this->session->userdata('user_id'),
         	'author_id'   => $this->session->userdata('user_id'),
			'comp_id'     => $this->session->userdata('comp_id'),
			'divn_id'     => $this->session->userdata('divn_id'),
			'zone_id'     => $this->session->userdata('zone_id'),
			'brnh_id'     => $this->session->userdata('brnh_id'),
			'maker_date'  => date('y-m-d'),
			'author_date' => date('y-m-d')
			);
			
		if($id != '')
		{
	 	    //print_r($data);
		    // echo "id=".$id;die;
		    $this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
		    //print_r($qtyy);
		    $a=sizeof($qtyy);
		    for($i=0; $i<$a; $i++){
			if($qtyy[$i]!='')
			{
			 	//echo $new_quantity[$i];die;
				//echo "jkykjy".$qtyy[$i];
			   	$logloc;$lograck;$logqty;
            	$Querylog = "select quantity,serial_number from tbl_product_serial_log where product_id='$Product_id' and serial_number='$pr_id[$i]' AND type='opening stock'";            
				$selectQuery1=$this->db->query($Querylog);
			    $num = $selectQuery1->num_rows();

			 	if($num > 0)
			    {	
                
				$Querylog = "select quantity,loc,rack_id,serial_number from tbl_product_serial_log where product_id='$Product_id' and serial_number='$pr_id[$i]' AND type='opening stock'";
				$resultlog=$this->db->query($Querylog)->result();
				//print_r($resultlog);
				if($resultlog != "")
				{
				    foreach($resultlog as $dtlog)
				    {
				  	  	$logloc           = $dtlog->loc;	
				    	$lograck          = $dtlog->rack_id;
				    	$logqty           = $dtlog->quantity;
				     	$logserial_number = $dtlog->serial_number;
				   		//if($logqty != ""){
				    
				    if($qtyy[$i]!=$logqty || $location[$i]!=$logloc || $rack[$i]!=$lograck)
				    { 

				   	 	$this->db->query("update tbl_product_serial set quantity = '$qtyy[$i]',purchase_price='$price',loc='$location[$i]',rack_id='$rack[$i]',module_status='$via_type',supp_name='$supp_name' where product_id='".$Product_id."' and loc='".$logloc."' and rack_id='".$lograck."'");
				   	 	

					   	$datavalss=($qtyy[$i]-$logqty);
					   	//(quantity-$logqty)+$qtyy[$i]
					    $p_Q_R=$this->db->query("update tbl_product_stock set quantity =quantity+$datavalss
					     where Product_id='$Product_id' ");
				  
					}
				  
					if($logserial_number !="")
             			$this->db->query("delete from tbl_product_serial_log where serial_number = $logserial_number");    
					}  	 
				 
				}	
													
				$sqlProdLoc2="insert into tbl_product_serial_log set product_id='$Product_id',supp_name='$supp_name',quantity ='$qtyy[$i]',purchase_price='$price',loc='$location[$i]',rack_id='$rack[$i]',module_status='$via_type',name_role='product opening stock',type='opening stock',maker_date=NOW(),author_date=now(),author_id='".$this->session->userdata('user_id')."',maker_id='".$this->session->userdata('user_id')."',divn_id='".$this->session->userdata('divn_id')."',comp_id='".$this->session->userdata('comp_id')."',zone_id='".$this->session->userdata('zone_id')."',brnh_id='".$this->session->userdata('brnh_id')."' ";
					$this->db->query($sqlProdLoc2);

			}
			else
			{

				$sqlProdLoc2="insert into tbl_product_serial set product_id='$Product_id',supp_name='$supp_name',quantity ='$qtyy[$i]',purchase_price='$price',loc='$location[$i]',rack_id='$rack[$i]',module_status='$via_type',maker_date=NOW(),author_date=now(),author_id='".$this->session->userdata('user_id')."',maker_id='".$this->session->userdata('user_id')."',divn_id='".$this->session->userdata('divn_id')."',comp_id='".$this->session->userdata('comp_id')."',zone_id='".$this->session->userdata('zone_id')."',brnh_id='".$this->session->userdata('brnh_id')."'"; 
				$this->db->query($sqlProdLoc2);
			
				$sqlProdLoc1="insert into tbl_product_serial_log set product_id='$Product_id',supp_name='$supp_name',quantity ='$qtyy[$i]',purchase_price='$price',loc='$location[$i]',rack_id='$rack[$i]',module_status='$via_type',name_role='product opening stock',type='opening stock',maker_date=NOW(),author_date=now(),author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."',divn_id='".$this->session->userdata('divn_id')."',comp_id='".$this->session->userdata('comp_id')."',zone_id='".$this->session->userdata('zone_id')."',brnh_id='".$this->session->userdata('brnh_id')."' ";
				$this->db->query($sqlProdLoc1);
				
				// echo $qtyy[$i]."insert";

				$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity+$qtyy[$i] where Product_id='$Product_id' ");
			
			}

 		}
		
	    //$this->session->set_flashdata('flash_msg', 'Record Updated Successfully.');
	}
	
	//die;	//redirect('master/Item/manage_item');
	
	echo 2;
	
	}
	
	else 
	{	
 	 	
		//$id="insert id=".$id;
		$dataall = array_merge($data,$sesio);
        $this->Model_admin_login->insert_user($table_name,$dataall);
		$lastproduct_id=$this->db->insert_id();
		 
		$a=sizeof($qtyy);
		
		for($i=0; $i<$a; $i++){
		
		if($qtyy[$i]!='')
		{
		
			$sqlProdLoc2="insert into tbl_product_serial set product_id='$lastproduct_id',supp_name='$supp_name', quantity ='$qtyy[$i]',purchase_price='$price',loc='$location[$i]',rack_id='$rack[$i]',module_status='$via_type',maker_date=NOW(),author_date=now(),author_id='".$this->session->userdata('user_id')."',maker_id='".$this->session->userdata('user_id')."',divn_id='".$this->session->userdata('divn_id')."',comp_id='".$this->session->userdata('comp_id')."',zone_id='".$this->session->userdata('zone_id')."',brnh_id='".$this->session->userdata('brnh_id')."'"; 
			$this->db->query($sqlProdLoc2);
			
			$sqlProdLoc1="insert into tbl_product_serial_log set product_id='$lastproduct_id',supp_name='$supp_name',quantity='$qtyy[$i]',purchase_price='$price',loc='$location[$i]',rack_id='$rack[$i]',module_status='$via_type',name_role='product opening stock',type='opening stock',maker_date=NOW(),author_date=now(),author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."',divn_id='".$this->session->userdata('divn_id')."',comp_id='".$this->session->userdata('comp_id')."',zone_id='".$this->session->userdata('zone_id')."',brnh_id='".$this->session->userdata('brnh_id')."' ";
				$this->db->query($sqlProdLoc1);
				
			$p_Q=$this->db->query("update tbl_product_stock set quantity=quantity+$qtyy[$i] where Product_id='$lastproduct_id' ");
			
		
		//$this->session->set_flashdata('flash_msg', 'Record Added Successfully.');
		
		}
	  }

	echo 1;
  }

}




public function ajax_viewItemData()
{

    // echo $this->input->post('id');
    //$data['result'] = $this->model_master->mod_viewItem($this->input->post('id'));
	//print_r($data['result']);
	$data =array('id' => $this->input->post('id'));
	$this->load->view('Item/viewItemPages',$data);

}

public function ajex_ItemListData()
{
    $data =  $this->manageItemJoinfun();  	
    $this->load->view('Item/edit-item',$data);
} 
	

function changesubcatg()
{
  if($this->session->userdata('is_logged_in'))
  {
  	$data['result'] = $this->model_master->get_child_data($this->input->get('ID'));
	$this->load->view('Item/getsubcatg',$data);
  }else{
    redirect('index');
  }
}



function deletephpdata()
{
	$serial_id=$_POST['s_id'];
	
	$qres=$this->db->query("select * from tbl_product_serial_log where serial_number='".$serial_id."'");
	//echo "select * from tbl_product_serial_log where serial_number='".$serial_id."'";die;
	$qresres=$qres->row();
	echo $qresres->rack_id; 
}



/*=========================================================================*/

public function insert_parts_supplies_files()
{
	
	@extract($_POST);
	$table_name='tbl_machine_files_uploads';
	
	if($_FILES['image_name']['name']!='')
	{
		$target = "filesimages/parts_supplies_files/"; 
		$target1 =$target . @date(U)."_".( $_FILES['image_name']['name']);
		$imageName=@date(U)."_".( $_FILES['image_name']['name']);
		move_uploaded_file($_FILES['image_name']['tmp_name'], $target1);
	}	


	$data=array(

			'module_type'  => 'Parts_Supplies',
			'file_log_id'  => $parts_supplies_id,
			'file_name'    => $imageName,
			'desc_id'      => $desc_id	
			
			);


	$sesio = array(
					'maker_id'  => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'comp_id'   => $this->session->userdata('comp_id'),
					'divn_id'   => $this->session->userdata('divn_id'),
					'zone_id'   => $this->session->userdata('zone_id'),
					'brnh_id'   => $this->session->userdata('brnh_id'),
					'maker_date'  => date('Y-m-d'),
					'author_date' => date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

	$this->Model_admin_login->insert_user($table_name,$dataall);

	//redirect("master/Item/get_spare_files");
	
}


public function get_spare_files()
{
	@extract($_POST);
	$data=$this->user_function();// call permission fnctn	
	$data['id'] = $id;
	$this->load->view("Item/get-spare-uploads-file",$data);	
}

/*=========================================================================*/


public function getPartsWarranties()
{
	
	$data=array(
					'id' => $_GET['ID']
			   );			
	$this->load->view("master/Item/add-parts-warranties",$data);	
		
}

public function insert_parts_supplies_warranty()
{
	
	@extract($_GET);
	$table_name='tbl_machine_warranty';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(

		'module_type'				=> 'Parts_Supplies',
		'warranty_log_id' 			=> $_GET['parts_supllies_id'],
		'warranty_type' 		    => $_GET['warranty_type'],
		'provider_id' 				=> $_GET['provider'],
		'warranty_usage_term_type'  => $_GET['wrty_term_type'],
		'meter_reading_value_limit' => $_GET['meter_limit'],
		'meter_reading_units'   	=> $_GET['meter_reading_units'],
		'expiry_date'   			=> $_GET['expiry_date'],
		'certificate_number'   		=> $_GET['certificate_no'],
		'description_name'   		=> $_GET['desc'],
		'date_added' 				=> $_GET['date_added']
	
	);


	$sesio = array(
					'maker_id' => $this->session->userdata('user_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'comp_id'  => $this->session->userdata('comp_id'),
					'divn_id'  => $this->session->userdata('divn_id'),
					'zone_id'  => $this->session->userdata('zone_id'),
					'brnh_id'  => $this->session->userdata('brnh_id'),
					'maker_date' => date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);



	$this->Model_admin_login->insert_user($table_name,$dataall);
	

redirect("master/Item/get_parts_warranty?id=".$_GET['parts_supllies_id']);

}


public function get_parts_warranty()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getPartsWarrantyData();
	$this->load->view("Item/get-parts-warranties",$data);	
}



function check_sku_no()
{
	
	$sku_no=$this->input->post('skuno');
	$sku=$this->db->query("select * from tbl_product_stock where sku_no='$sku_no'")->result_array();

	if(sizeof($sku) > 0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

}
}?>