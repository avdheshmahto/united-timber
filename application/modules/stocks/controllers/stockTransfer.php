<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);

class stockTransfer extends my_controller {
function __construct()
{
	parent::__construct(); 
	$this->load->library('pagination');
	$this->load->model('model_stock_transfer');	
}     

/*=================================Start Spare Current Stock ================================*/

function manage_stock_transfer() 
{
	
	extract($_POST);
    if($this->session->userdata('is_logged_in'))
    {
		$data = $this->manageItemJoinfunSearch();
    	$this->load->view('manage-stock-transfer',$data);
	}
	else
	{
		redirect('index');
	}

}

public function manageItemJoinfunSearch()
{
    
	$table_name='tbl_product_serial';
	$data['result'] = "";
	////Pagination start ///
	//$url   = site_url('/stocks/stockTransfer/manage_stock_transfer?');
	$sgmnt = "4";

	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;


	$totalData   = $this->model_stock_transfer->count_allproduct_spare($table_name,'A',$this->input->get());


	if($_GET['entries']!="" && $_GET['filter'] != 'filter'){
	$url   = site_url('/stocks/stockTransfer/manage_stock_transfer?entries='.$_GET['entries'].'&code='.$_GET['code'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']);
	}elseif($_GET['filter'] == 'filter' || $_GET['entries'] != ''){
	$url   = site_url('/stocks/stockTransfer/manage_stock_transfer?entries='.$_GET['entries'].'&code='.$_GET['code'].'&sp_name='.$_GET['sp_name'].'&filter='.$_GET['filter']);


	}
	else
	{
	$url = site_url('/stocks/stockTransfer/manage_stock_transfer?');
	}


	$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data       = $this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']  = $this->pagination->create_links();

	if($_GET['filter'] != "")   ////filter start ////
	$data['result']  = $this->model_stock_transfer->filterListproduct_spare($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result']  = $this->model_stock_transfer->product_spare_get($pagination['per_page'],$pagination['page']);

	// call permission fnctn
	return $data;

}

//******************************************************************************************

function stock_transfer_map()
{
	
	if($this->session->userdata('is_logged_in'))
    {
    	$this->load->view('stock-transfer-map');
	}
	else
	{
		redirect('index');
	}

}

	
function stock_transfer()
{

	$data['sno']=$_GET['SNO'];
	$data['pid']=$_GET['PID'];
	$data['typ']=$_GET['TYP'];
	//print_r($data);
	$this->load->view('transfer-stock',$data);

}


function getRack()
{
	$data['id'] = $_GET['location_rack_id'];
	$this->load->view('getRack',$data);
}


public function getRackQty()
{
	$rackQty=$this->db->query("select SUM(quantity) as qty from tbl_product_serial where rack_id='".$_GET['location_rack_id']."' and product_id='".$_GET['pid']."'");
	$getQty=$rackQty->row();
	echo $getQty->qty;
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

public function get_vendor_list()
{
	$prdct_id=$this->input->post('pid');
    $loct=$this->input->post('loc');
    $rackid=$this->input->post('rack');

    //print_r($_POST);

	//$vndr=$this->db->query("select * from tbl_product_serial where product_id='$prdct_id' AND loc='$loct' AND rack_id='$rackid'");
	$vndr=$this->db->query("select * from tbl_product_serial where product_id='$prdct_id'");
	//$getVndr=$vndr->result();
	$v_array=array();
	foreach ($vndr->result() as $getVndr) 
	{
		array_push($v_array, $getVndr->supp_name);
	}
	//print_r($v_array);
	$cntid=implode(",", $v_array);
	$cnt=$this->db->query("select * from tbl_contact_m where contact_id IN ($cntid) ");

	  echo "<option value=''>----Select ----</option> ";
	foreach ($cnt->result() as $getCnt) 
	{
		echo "<option value=".$getCnt->contact_id.">".$getCnt->first_name."</option>";
	}

}


public function get_price_list()
{
	
	$prd_id=$this->input->post('prid');
	$locs=$this->input->post('loc');
	$racks=$this->input->post('rack');
	$vndrid=$this->input->post('vid');

    $price=$this->db->query("select distinct(purchase_price) from tbl_product_serial where product_id='$prd_id' AND loc='$locs' AND rack_id='$racks' AND supp_name='$vndrid' ");

	echo "<option value=''>----Select ----</option> ";
	foreach ($price->result() as $getprice) 
	{
		echo "<option value=".$getprice->purchase_price.">".$getprice->purchase_price."</option>";
	}
}



public function stock_transfer_qty()
{

	//print_r($_POST);die;

	
	$main_id1=$this->input->post('product_id1'); 
	$type1=$this->input->post('via_type1');
	$loc1=$this->input->post('location_id1');
	$rack_id1=$this->input->post('rack_id1');
	$qty1=$this->input->post('stock_qty1');
	$vendor_id1=$this->input->post('vendor_id1');
	$purchase_price1=$this->input->post('purchase_price1');

	$main_id=$this->input->post('product_id'); 
	$type=$this->input->post('via_type');
	$loc=$this->input->post('location_id');
	$rack_id=$this->input->post('rack_id');
	$qty=$this->input->post('qtyid');
	$vendor_id=$this->input->post('vendor_id');
	$purchase_price=$this->input->post('purchase_price');
		
	$this->db->select('*');
	$array = array('product_id' => $main_id,'module_status' => $type,'loc' => $loc, 'rack_id' => $rack_id,'supp_name' => $vendor_id,'purchase_price' => $purchase_price);
	$this->db->where($array);
	$query = $this->db->get('tbl_product_serial');
	//print_r($array);die;
	$num = $query->num_rows();

			
		if($num > 0)
		{
                	
	 		//$this->db->query("update tbl_product_serial_log set quantity = quantity+$qty where product_id='".$main_id."' and loc='".$loc."' and rack_id='".$rack_id."' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");

			$this->db->query("update tbl_product_serial set quantity = quantity - $qty where product_id='$main_id1' and loc='$loc1' and rack_id='$rack_id1' and supp_name='$vendor_id1' and purchase_price='$purchase_price1' and module_status='$type1' ");
			
			//$p_Q_R=$this->db->query("update tbl_product_stock set quantity =quantity+$qty where Product_id='$main_id' ");
			$this->db->query("update tbl_product_serial set quantity = quantity + $qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' and module_status='$type' ");


			
			$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='stock transfer',name_role='current stock transfer',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
			$this->db->query($sqlProdLoc1);


							//==========stock tranfer log===========

			$this->db->query("insert into tbl_stock_transfer_log set quantity ='$qty1',product_id='$main_id1',loc='$loc1',rack_id='$rack_id1',type='stock transfer',name_role='stock transfer from',module_status='$type1',supp_name='$vendor_id1',purchase_price='$purchase_price1', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ");

			$this->db->query("insert into tbl_stock_transfer_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='stock transfer',name_role='stock transfer to',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ");


				  
										
		}
	
		else
		{
			

			$this->db->query("update tbl_product_serial set quantity = quantity - $qty where product_id='$main_id1' and loc='$loc1' and rack_id='$rack_id1' and supp_name='$vendor_id1' and purchase_price='$purchase_price1' and module_status='$type1' ");

			$this->db->query("insert into tbl_product_serial set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."'");

			//$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity+$qty where Product_id='".$main_id."' ");
		
			$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='stock transfer',name_role='current stock transfer',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
			$this->db->query($sqlProdLoc1);

							//==========stock tranfer log===========

			$this->db->query("insert into tbl_stock_transfer_log set quantity ='$qty1',product_id='$main_id1',loc='$loc1',rack_id='$rack_id1',type='stock transfer',name_role='stock transfer from',module_status='$type1',supp_name='$vendor_id1',purchase_price='$purchase_price1', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ");

			$this->db->query("insert into tbl_stock_transfer_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='stock transfer',name_role='stock transfer to',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=now(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ");
			
		}
		echo $main_id;
	
	
}


function ajax_TransferStock()
{
	
	$data['id'] = $this->input->post('ids');
	//print_r($data);
	$this->load->view('load-stock-transfer-map',$data);

}

}
?>