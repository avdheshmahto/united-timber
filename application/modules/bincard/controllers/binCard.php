<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);

class binCard extends my_controller {

function __construct()
{
    parent::__construct(); 
    $this->load->library('pagination');
    $this->load->model('model_master');	
    $this->load->model('Model_admin_login');
}     


public function manage_bin_card()
{
	
	if($this->session->userdata('is_logged_in'))
	{
		$data = $this->manageItemJoinfun();
		$this->load->view('manage-bin-card',$data);
	}

	else
	{
		redirect('index');
	}

}

public function manageItemJoinfun()
{
    
	$table_name='tbl_bin_card_hdr';
	$data['result'] = "";
	////Pagination start ///
	$url   = site_url('/binCard/manage_bin_card?');
	$sgmnt = "4";

	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;


	$totalData   = $this->model_master->count_allproduct($table_name,'A',$this->input->get());


	if($_GET['entries']!="" && $_GET['filter'] == ""){
	$url   = site_url('/binCard/manage_bin_card?entries='.$_GET['entries']);
	}elseif($_GET['filter'] != ""){
	$url   = site_url('/binCard/manage_bin_card?entries='.$_GET['entries'].'&code='.$_GET['code'].'&bin_card_type='.$_GET['bin_card_type'].'&machine_id='.$_GET['machine_id'].'&vendor_id='.$_GET['vendor_id'].'&rdate='.$_GET['rdate'].'&grn_no='.$_GET['grn_no'].'&grn_date='.$_GET['grn_date'].'&remarks='.$_GET['remarks'].'&filter='.$_GET['filter']);
	// sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
	}


	$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data       = $this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']        = $this->pagination->create_links();

	if($this->input->get('filter') == 'filter' || $_GET['entries']!='' )   ////filter start ////
	$data['result']          = $this->model_master->filterListproduct($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result']          = $this->model_master->product_get($pagination['per_page'],$pagination['page']);

	// call permission fnctn
	return $data;

}



public function edit_bin_card()
{

	if($this->session->userdata('is_logged_in'))
	{
		$this->load->view('edit-bin-card');
	}
	else
	{
		redirect('index');
	}		

}


public function add_bin_card()
{
	
	if($this->session->userdata('is_logged_in'))
	{	
		$this->load->view('add-bin-card');
	}
	else
	{
		redirect('index');
	}

}


public function getproduct()
{

	if($this->session->userdata('is_logged_in'))
	{
		//$this->getSelect();
		$this->load->view('getproduct');
	}
	else
	{
		redirect('index');
	}

}

//--
public function insertBinCard()
{
		
	extract($_POST);
	$table_name ='tbl_bin_card_hdr';
	$table_name_dtl ='tbl_bin_card_dtl';
	$pri_col ='rflhdrid';
	$pri_col_dtl ='refillhdr';
	$rows = $this->input->post('rows');
	
	$sess = array(
				
				'maker_id' => $this->session->userdata('user_id'),
				'author_id' => $this->session->userdata('user_id'),
				'maker_date' => date('y-m-d'),
				'author_date' => date('y-m-d'),
				'status' => 'A',
				'comp_id' => $this->session->userdata('comp_id'),
				'zone_id' => $this->session->userdata('zone_id'),
				'brnh_id' => $this->session->userdata('brnh_id'),
				'divn_id' => $this->session->userdata('divn_id')
	);

	$data = array(

				'bin_card_type' => $this->input->post('bin_card_type'),
				'vendor_id' => $this->input->post('vendor_id'),
				//'date' => $this->input->post('rdate'),
				//'type' => $this->input->post('type'),
				'grn_no' => $this->input->post('grn_no'),
				'grn_date' => $this->input->post('grn_date'),
				'po_no' => $this->input->post('po_no'),
				'po_date' => $this->input->post('po_date'),
				'remarks' => $this->input->post('remarks'),				
				'stock_status' => "Pending",
				
				);
		
		$data_merge = array_merge($data,$sess);					
	    //$this->load->model('Model_admin_login');	
	    $this->Model_admin_login->insert_user($table_name,$data_merge);
		$lastHdrId11=$this->db->insert_id();
					
		for($i=0; $i<$rows; $i++)
		{
		
			if($new_quantity[$i]!='')
			{

				$data_dtl=array(
									'refillhdr'      => $lastHdrId11,
									'product_id'     => $product_id[$i],
									'type' 			 => $type[$i],
									'main_loc'       => $main_loc[$i],
									'loc' 		     => $locs[$i],
									'rack_id' 	     => $rack_ids[$i],				 
									'quantity'       => $new_quantity[$i],
									'purchase_price' => $purchase_price[$i],
									
									'maker_id'    => $this->session->userdata('user_id'),
									'author_id'   => $this->session->userdata('user_id'),
									'maker_date'  => date('y-m-d'),
									'author_date' => date('y-m-d'),
									'status'  => 'A',
									'comp_id' => $this->session->userdata('comp_id'),
									'zone_id' => $this->session->userdata('zone_id'),
									'brnh_id' => $this->session->userdata('brnh_id'),
									'divn_id' => $this->session->userdata('divn_id')
								);

				$this->software_stock_log_insert($lastHdrId11,$bin_card_type,$vendor_id,$product_id[$i],$new_quantity[$i],$purchase_price[$i]);

				$this->stock_refill_qty($new_quantity[$i],$product_id[$i],$main_loc[$i],$locs[$i],$rack_ids[$i],$bin_card_type,$vendor_id,$type[$i],$purchase_price[$i]);
				$this->Model_admin_login->insert_user($table_name_dtl,$data_dtl);
			
			}
				//print_r($data_dtl);die;
		}
			
		redirect('/bincard/binCard/manage_bin_card');
}

//****************************************************************************************************


public function stock_refill_qty($qty,$main_id,$main_loc,$loc,$rack_id,$bin_card_type,$vendor_id,$type,$purchase_price)
{
		
	$this->db->select('*');
	$array = array('loc' => $loc, 'rack_id' => $rack_id,'product_id' => $main_id, 'supp_name' => $vendor_id,'purchase_price' => $purchase_price);
	$this->db->where($array);
	$query = $this->db->get('tbl_product_serial');
	//print_r($array);die;
	$num = $query->num_rows();

	
	if($bin_card_type=='Receipt')
	{
		
		if($num>0)
		{
                	
	 		//$this->db->query("update tbl_product_serial_log set quantity = quantity+$qty where product_id='".$main_id."' and loc='".$loc."' and rack_id='".$rack_id."' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");

			$this->db->query("update tbl_product_serial set quantity = quantity+$qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price'");

			$p_Q_R=$this->db->query("update tbl_product_stock set quantity =quantity+$qty
				     where Product_id='$main_id' ");

			$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='opening stock',name_role='bincard opening stock',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
			$this->db->query($sqlProdLoc1);
				  
										
		}
	
		else
		{
			
			$this->db->query("insert into tbl_product_serial set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'");

			$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity+$qty where Product_id='".$main_id."' ");
		
			$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='opening stock',name_role='bincard opening stock',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
			$this->db->query($sqlProdLoc1);
			
		}
	
	}
	
}



//****************************************************************************************************

public function updateBinCard()
{
		
	extract($_POST);
	$table_name ='tbl_bin_card_hdr';
	$table_name_dtl ='tbl_bin_card_dtl';
	$pri_col ='rflhdrid';
	$pri_col_dtl ='refillhdr';
	//$rows = $this->input->post('rows');
	//echo $id = $this->input->post('id');die;

	$this->db->query("delete from tbl_bin_card_dtl where refillhdr='$id'");	
			
	$sess = array(
				
				'maker_id' => $this->session->userdata('user_id'),
				'maker_date' => date('y-m-d'),
				'status' => 'A',
				'comp_id' => $this->session->userdata('comp_id'),
				'zone_id' => $this->session->userdata('zone_id'),
				'brnh_id' => $this->session->userdata('brnh_id'),
				'divn_id' => $this->session->userdata('divn_id')
	);

	$data = array(
								 
				
				'remarks' => $this->input->post('remarks'),
				'date' => $this->input->post('rdate'),
				'vendor_id' => $this->input->post('vendor_id_spare'),
				'grn_no' => $this->input->post('grn_no'),
				'grn_date' => $this->input->post('grn_date'),
				'stock_status' => "Pending",
				
				);
		
	$data_merge = array_merge($data,$sess);					
	   
	$this->load->model('Model_admin_login');	
	$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data_merge);

		
	for($i=0; $i<=$rows; $i++)
	{
				
		if($new_quantity[$i]!='')
		{

		$data_dtl=array(
				 'refillhdr' => $id,
				 'main_loc' => $main_loc[$i],
				 'loc' => $loc[$i],
				 'rack_id' => $rack_id[$i],
				 'product_id' => $product_id[$i],				 
				 //$data_dtl['list_price']=$this->input->post('list_price')[$i];
				 'quantity' => $new_quantity[$i],
				 'maker_id' => $this->session->userdata('user_id'),
				 'maker_date' => date('y-m-d'),
				 'comp_id' => $this->session->userdata('comp_id'),
				 'zone_id' =>$this->session->userdata('zone_id'),
				 'brnh_id' =>$this->session->userdata('brnh_id')
				);
				
				$this->stock_refill_qty_edit($new_quantity[$i],$product_id[$i],$main_loc[$i],$loc[$i],$rack_id[$i],$bin_card_type);
				$this->Model_admin_login->insert_user($table_name_dtl,$data_dtl);		
				
		}
	}
					
					
	echo "<script type='text/javascript'>";
	echo "window.close();";
	echo "window.opener.location.reload();";
	echo "</script>";

}
	


//******************************************************************************************



public function stock_refill_qty_edit($qty,$main_id,$main_loc,$loc,$rack_id,$bin_card_type)
{
		
	$this->db->select('*');
	$array = array('location_id' => $main_loc, 'loc' => $loc, 'rack_id' => $rack_id,'product_id' => $main_id);
	$this->db->where($array);
	$query = $this->db->get('tbl_product_serial');
	//print_r($array);die;
	$num = $query->num_rows();

	/*$rah = "select * from tbl_product_serial_log where product_id='$main_id' and location_id = '$main_loc' and loc = '$loc' and rack_id = '$rack_id'";
	$num =$this->db->query($rah)->num_rows();
	*/

	if($bin_card_type=='Receipt')
	{
		if($num>0)
		{

		$this->db->query("update tbl_product_serial_log set quantity = quantity+$qty,loc='$loc',rack_id='$rack_id' where product_id='".$main_id."' and loc='".$loc."' and rack_id='".$rack_id."' ");


		$this->db->query("update tbl_product_serial set quantity = quantity+$qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id'");

		$p_Q_R=$this->db->query("update tbl_product_stock set quantity =quantity+$qty
			     where Product_id='$main_id' ");
			  
		}
		else
		{
		
		$this->db->query("insert into tbl_product_serial set quantity ='$qty' ,location_id='$main_loc',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='spare', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'");

		$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity+$qty where Product_id='".$main_id."' ");
	
		$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',location_id='$main_loc',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='spare',type='opening stock',name_role='bincard opening stock', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
		$this->db->query($sqlProdLoc1);
		
		}
	
	}
	
	else
	{
		
	if($num>0)
	{
		//echo "hello";die;
	$this->db->query("update tbl_product_serial set quantity =quantity-$qty where product_id='$main_id' and location_id='$main_loc' and loc='$loc' and rack_id='$rack_id'");
	$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity-$qty[$i] where Product_id='$main_id[$i]' ");
	$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',location_id='$main_loc',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='spare',type='Issue', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."',color='$color[$i]' ";
	$this->db->query($sqlProdLoc1);
	}
	else
	{
	
	$this->db->query("insert into tbl_product_serial set quantity ='$qty' ,location_id='$main_loc',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='spare', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'");

	$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity-$qty where Product_id='".$main_id."' ");

	$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',location_id='$main_loc',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='spare',type='Issue', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
	$this->db->query($sqlProdLoc1);
		
	}
	
 }

}



//*****************************************************************************************************

public function get_rack()
{
	if($this->session->userdata('is_logged_in'))
	{
				
		$data=array(
			'loc' => $_GET['loc'],
			'rack_id' => $_GET['rack_id'],
			'main_loc' => $_GET['main_loc']
			);
			//$data['$loc']=$_GET["proPall"];
			$this->load->view('get-rack',$data);
	}
	else
	{
		redirect('index');
	}		
}	


public function getPalletQty()
{
 
	$qtySerial=$this->db->query("select * from tbl_product_serial where loc='".$_GET['loc']."' and product_id='".$_GET['pri_id']."'");
	$getData1=$qtySerial->row();
	$numCnt=$qtySerial->num_rows();
	
	if($numCnt>0)
	{
	foreach($qtySerial->result() as $getData){

	$queryLocation=$this->db->query("select * from tbl_location_rack where id='$getData->rack_id'");
	$getLocation=$queryLocation->row();
	$numCnt=$queryLocation->num_rows();
	//echo $numCnt;
	$sum=$getData->quantity;
	$abc=$abc+$sum;
	//echo "select * from tbl_product_serial where main_location_id='".$_GET['main_loc']."' and location_id='".$_GET['loc']."' and product_id='".$_GET['pri_id']."'";
	//if($numCnt>0)
	//{
	echo "Rack Name Is:-".$getLocation->rack_name." and Qty is:-".$sum."<br>";

	//}
	//else
	//{
	//echo "No Record found";	
	//}
	}
	echo "Total Quantity Is :-".$abc;
	}
	else
	{
	echo "No Record found";	
	}

	//$this->load->view('get-rack');
}

public function print_bincard()
{
	
	$data=array(
	'id' => $_GET['id']
	);
	$this->load->view("bin-card-print",$data);	
	
}


public function check_rack_qty()
{

	$pid=$this->input->post('pid');
	$loc=$this->input->post('loc');
	$rack=$this->input->post('rack');
	$etqty=$this->input->post('eqty');

	$PrdQty=$this->db->query("select * from tbl_product_serial where product_id='$pid' AND loc='$loc' AND rack_id='$rack'");
	$count=$PrdQty->num_rows();
	$getQty=$PrdQty->row();

		if($etqty > $getQty->quantity)
			echo "0";
		else
			echo "1";

}



public function ajex_nextIncrementId()
{
 		
    $query    = $this->db->query("SELECT auto_increment FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'tbl_bin_card_hdr' ");
	$result   = $query->row_array();

	if(sizeof($result) > 0)
	{
		 echo '00'.$result['auto_increment'];
    }
}


}
?>