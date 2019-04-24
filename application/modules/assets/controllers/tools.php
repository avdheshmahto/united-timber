<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class tools extends my_controller {


function __construct()
{
	parent::__construct(); 
	$this->load->library('pagination');
	$this->load->model('model_master_tools');	
	// load Employee Model
	//$this->load->model('Employee_model', 'employee');
}

function get_rack()
{
	
	$data=array(
	'id' => $_GET['con'] 
		);
	$this->load->view('assets/tools/get-rack',$data);
	
}
	


public function manage_tool_map()
{

	if($this->session->userdata('is_logged_in'))
	{
		$data=$this->user_function();// call permission fnctn
		$data = $this->managetoolJoinfun();	
		$this->load->view('tools/manage-tool-map',$data);
	}
	else
	{
		redirect('index');
	}

}

public function getToolSuppliers()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data=array(
		'id' => $_GET['ID'] 
		);	
		$this->load->view('tools/add-tool-Suppliers',$data);
	}
	else
	{
		redirect('index');
	}
}

public function getToolWarranty()
{
	if($this->session->userdata('is_logged_in'))
	{
		$data=array(
		'id' => $_GET['ID'] 
		);	
		$this->load->view('tools/add-tool-warranties',$data);
	}
	else
	{
		redirect('index');
	}
}


public function ajex_toolsecondpageListData()
{
    $data =  $this->managetoolJoinfun();  	
	$this->load->view('tools/edit-tool',$data);
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


public function edit_map_tool()
{

	$data=array(
	'id' => $_GET['id'],
	'type' => $_GET['type']
	);	
		//print_r($data);
	$this->load->view("tools/edit-tool-mapp",$data);	
	
}


public function manage_tools()
{
	
	//$_SERVER['REQUEST_URI'];
	extract($_GET);
	extract($_POST);
	//$tableName='tbl_product_stock';
	 
	if($this->session->userdata('is_logged_in'))
	{
		//$data['result'] = $this->model_master->product_get();
		$data = $this->managetoolJoinfun();	
		$this->load->view('tools/manage-tools',$data);
	}
	else
	{
		redirect('index');
	}
		
}

public function managetoolJoinfun()
{
    
	$table_name='tbl_product_stock';
    $data['result'] = "";
	////Pagination start ///
	$url   = site_url('/assets/tools/manage_tools?');
	$sgmnt = "4";

	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;
		 		 
	$totalData   = $this->model_master_tools->count_alltools($table_name,'A',$this->input->get());

	  
	if($_GET['entries']!="" && $_GET['filter'] == "")
	{
		 $url   = site_url('/assets/tools/manage_tools?entries='.$_GET['entries']);
	}elseif($_GET['filter'] != "")
	{
	  	$url   = site_url('/assets/tools/manage_tools?entries='.$_GET['entries'].'sku_no='.$_GET['sku_no'].'&priority='.$_GET['priority'].'&productname='.$_GET['productname'].'&usages_unit='.$_GET['usages_unit'].'&unitprice_purchase='.$_GET['unitprice_purchase'].'&quantity='.$_GET['quantity'].'&type_of_spare='.$_GET['type_of_spare'].'&filter='.$_GET['filter']);
	  	 // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
	}

	$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
    $data       = $this->user_function();
    //////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']        = $this->pagination->create_links();
	
	if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
		$data['result']          = $this->model_master_tools->filterListtool($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
		$data['result']          = $this->model_master_tools->tool_get($pagination['per_page'],$pagination['page']);

    // call permission fnctn
    return $data;

}


//============================================================================================

public function insert_tools()
{

		@extract($_POST);
		$table_name ='tbl_product_stock';
		$pri_col    = 'Product_id';
	 	$id         = $this->input->post('Product_id');
		$addpro     = $this->input->post('add_new_product');
		
        $data= array(
			 'productname'        => $this->input->post('item_name'),
			 'priority'			  => $this->input->post('priority'),
			 'sku_no'             => $this->input->post('sku_no'),
			 'unitprice_purchase' => $this->input->post('unitprice_purchase'),
			 'usageunit'          => $this->input->post('unit'),
			 'type'				  => 'tool',
			 'type_of_spare'	  => $this->input->post('type_of_spare')
		  );
         $sesio = array(
			'comp_id' => $this->session->userdata('comp_id'),
			'divn_id' => $this->session->userdata('divn_id'),
			'zone_id' => $this->session->userdata('zone_id'),
			'brnh_id' => $this->session->userdata('brnh_id'),
			'maker_date'=> date('y-m-d'),
			'author_date'=> date('y-m-d')
			);
			
		if($id != '')
		{
	 	    //print_r($data);
		    $this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
		    //print_r($qtyy);
		    $a=sizeof($qtyy);
			for($i=0; $i<$a; $i++){
			if($qtyy[$i]!='')
			{
				//echo $new_quantity[$i];die;
				//echo "jkykjy".$qtyy[$i];
             	$selectQuery = "select quantity from tbl_product_serial where product_id='$Product_id' and loc='$location[$i]' and rack_id='$rack[$i]'";
					$selectQuery1=$this->db->query($selectQuery);
			        $num= $selectQuery1->num_rows();
			 	if($num > 0)
			   	{	
                
					$Querylog = "select quantity,serial_number from tbl_product_serial_log where product_id='$Product_id' and loc='$location[$i]' and rack_id='$rack[$i]' AND type='opening stock'";
					$resultlog=$this->db->query($Querylog)->result();
					//print_r($resultlog);
					if($resultlog != ""){
				    foreach($resultlog as $dtlog){
				   	// echo $logqty           = $dtlog->quantity;
				    $logserial_number     = $dtlog->serial_number;
				   	if($logqty != "")
				   	{
				    	$this->db->query("update tbl_product_serial set quantity = quantity-$logqty,module_status='tool' where product_id='".$Product_id."' and loc='$location[$i]' and rack_id='$rack[$i]'");
					
				    }

				 	/////delete serial log/////
					//echo "delete from tbl_product_serial_log where product_id='$Product_id'";
					if($logserial_number !="")
             		$this->db->query("delete from tbl_product_serial_log where serial_number = $logserial_number");    
				 }  	 
				 
				}	
					
				$this->db->query("update tbl_product_serial set quantity = quantity+$qtyy[$i],module_status='tool' where product_id='".$Product_id."' and loc='$location[$i]' and rack_id='$rack[$i]'");

				$p_Q_R=$this->db->query("update tbl_product_stock set quantity =quantity+$qtyy[$i] where Product_id='$Product_id' ");				 
				 
				$sqlProdLoc2="insert into tbl_product_serial_log set quantity ='$qtyy[$i]',loc='$location[$i]' , rack_id='$rack[$i]',product_id='$Product_id',type='opening stock',location_id='1',module_status='tool', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
				$this->db->query($sqlProdLoc2);
			}
			else
			{

				$sqlProdLoc2="insert into tbl_product_serial set product_id='$Product_id', quantity ='$qtyy[$i]', loc='$location[$i]',rack_id='$rack[$i]',module_status='tool', maker_date=NOW(), author_date=now(),location_id='1', author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'"; 
				$this->db->query($sqlProdLoc2);
			
			 	$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qtyy[$i]',loc='$location[$i]' , rack_id='$rack[$i]',product_id='$Product_id',type='opening stock',location_id='1',module_status='tool', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
				$this->db->query($sqlProdLoc1);
				
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
 	 
	
		$dataall = array_merge($data,$sesio);
        $this->Model_admin_login->insert_user($table_name,$dataall);
		 $lastproduct_id=$this->db->insert_id();
		 
		$a=sizeof($qtyy);
		
		for($i=0; $i<$a; $i++){
		
		if($qtyy[$i]!='')
		{
		
			$sqlProdLoc2="insert into tbl_product_serial set product_id='$lastproduct_id', quantity ='$qtyy[$i]', loc='$location[$i]',rack_id='$rack[$i]', maker_date=NOW(), author_date=now(),location_id='1',module_status='tool', author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'"; 
			$this->db->query($sqlProdLoc2);
			
			$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qtyy[$i]',loc='$location[$i]' , rack_id='$rack[$i]',module_status='tool',product_id='$lastproduct_id',type='opening stock',location_id='1', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
				$this->db->query($sqlProdLoc1);
				
			$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity+$qtyy[$i] where Product_id='$lastproduct_id' ");
			
			//$this->session->set_flashdata('flash_msg', 'Record Added Successfully.');
		
		}
 	 }
	echo 1;
  }

}




public function ajax_viewtoolData()
{
    
    // echo $this->input->post('id');
    //$data['result'] = $this->model_master->mod_viewItem($this->input->post('id'));
	//print_r($data['result']);
	$data =array('id' => $this->input->post('id'));
	$this->load->view('tools/viewtoolPages',$data);

}
	

function changesubcatg()
{

	if($this->session->userdata('is_logged_in'))
	{
  		$data['result'] = $this->model_master->get_child_data($this->input->get('ID'));
		$this->load->view('Item/getsubcatg',$data);
  	}
  	else
  	{
    	redirect('index');
  	}

}


//=========================Insert tools warranty====================================

public function insert_tools_warranty()
{
	
	@extract($_GET);
	$table_name='tbl_tools_warranty';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(

			'tools_id' => $_GET['tools_id'],
			'warranty_type' => $_GET['warranty_type'],
			'provider_id' => $_GET['provider'],
			'warranty_usage_term_type'   => $_GET['wrty_term_type'],
			'meter_reading_value_limit'   => $_GET['meter_limit'],
			'meter_reading_units'   => $_GET['meter_reading_units'],
			'expiry_date'   => $_GET['expiry_date'],
			'certificate_number'   => $_GET['certificate_no'],
			'description_name'   => $_GET['desc'],
			'date_added' => $_GET['date_added']
	
		);


	$sesio = array(
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_date'=> date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

	  $this->Model_admin_login->insert_user($table_name,$dataall);
	
	redirect("assets/tools/get_tools_warranty?id=".$_GET['tools_id']);

}


public function get_tools_warranty()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master_tools->getToolsWarrantyData();
	$this->load->view("tools/get-tools-warranty",$data);	
}

/*=========================================================================*/

/*=========================================================================*/

public function insert_tools_suppliers()
{
	@extract($_GET);
	$table_name='tbl_machine_suppliers';
	//$this->db->delete('tbl_machine_spare_map', array('machine_id' => $machine_id)); 
	
	$data=array(
	'machine_id' => $_GET['machine_id'],
	'suppliers_name' => $_GET['supplier_name'],
	'suppliers_type' => $_GET['supplier_type'],
	'supplier_part_number'   => $_GET['Supplier_part_number'],
	'catalog_name'   => $_GET['catelog_id']	
	
	);


	$sesio = array(
					'maker_id' => $this->session->userdata('comp_id'),
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_date'=> date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);



	$this->Model_admin_login->insert_user($table_name,$dataall);
	

redirect("assets/machine/get_machine_suppliers?id=".$_GET['machine_id']);

}


public function get_tools_suppliers()
{
	$data=$this->user_function();// call permission fnctn
	$data['result'] = $this->model_master->getMachineSuppliersData();
	$this->load->view("machine/get-machine-suppliers",$data);	
}

/*=========================================================================*/


/*=========================================================================*/

public function insert_tools_files()
{
	
	@extract($_POST);
	$table_name='tbl_machine_files_uploads';
	
	if($_FILES['image_name']['name']!='')
	{
		$target = "filesimages/toolsfiles/"; 
		$target1 =$target . @date(U)."_".( $_FILES['image_name']['name']);
		$image_name=@date(U)."_".( $_FILES['image_name']['name']);
		move_uploaded_file($_FILES['image_name']['tmp_name'], $target1);
	}	


	$data=array(

			'type'   	 => 'tools',
			'tools_id'   => $tools_id,
			'file_id'    => $image_name,
			'desc_id'    => $desc_id	
			
		);


	$sesio = array(
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_date'=> date('Y-m-d'),
					'author_date'=> date('Y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

	$this->Model_admin_login->insert_user($table_name,$dataall);
	
}


public function get_tools_files()
{
	@extract($_POST);
	$data=$this->user_function();// call permission fnctn	
	$data['id'] = $id;
	$this->load->view("tools/get-tools-uploads-file",$data);	
}

/*=========================================================================*/


} ?>