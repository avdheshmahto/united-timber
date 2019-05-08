<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);

class SpareIssue extends my_controller {

function __construct()
{
	parent::__construct(); 
	$this->load->library('pagination');
	$this->load->model('model_issue');	
}     

/*=================================Start Spare Parts ================================*/

function manage_spare_issue() 
{

    if($this->session->userdata('is_logged_in'))
    {	
    	$data=$this->manageSpareJoinfun();
    	$this->load->view('spare/manage-spare-issue',$data);
	}
	else
	{
		redirect('index');
	}

}


public function manageSpareJoinfun()
{
    
		  $table_name='tbl_work_order_maintain';
    	  $data['result'] = "";
		  ////Pagination start ///
		  $url   = site_url('/issue/SpareIssue/manage_spare_issue?');
		  $sgmnt = "4";

		  if($_GET['entries']!="")
		  	$showEntries = $_GET['entries'];
		  else
		  	$showEntries = 10;
		 
		 
		 $totalData   = $this->model_issue->count_allSpare($table_name,'A',$this->input->get());

		  
		  if($_GET['entries']!="" && $_GET['filter'] == ""){
			 $url   = site_url('/issue/SpareIssue/manage_spare_issue?entries='.$_GET['entries']);
		  }elseif($_GET['filter'] != ""){
		  	 $url   = site_url('/issue/SpareIssue/manage_spare_issue?entries='.$_GET['entries'].'&location_rack_id='.$_GET['location_rack_id'].'&rack_name='.$_GET['rack_name'].'&filter='.$_GET['filter']);
		  	 // sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
		  }



		  $pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
          $data       = $this->user_function();
	      //////Pagination end ///
 		  $data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
		  $data['pagination']        = $this->pagination->create_links();
		
		  if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
			$data['result']          = $this->model_issue->filterSpareList($pagination['per_page'],$pagination['page'],$this->input->get());
		  else	
			$data['result']          = $this->model_issue->getSpare($pagination['per_page'],$pagination['page']);

          // call permission fnctn
	      return $data;

}

function view_spare_issue()
{

	if($this->session->userdata('is_logged_in'))
	{
		$this->load->view('spare/view-product-issue');
	}
	else
	{
		redirect('index');
	}
}

function view_spare_sm_issue()
{

	if($this->session->userdata('is_logged_in'))
	{
		$this->load->view('spare/view-product-sm-issue');
	}
	else
	{
		redirect('index');
	}
}

function issue_spare_sm()
{

	$data['pid'] = $_GET['PID'];
	$data['hid'] = $_GET['HID'];
	$data['wid'] = $_GET['WID'];
	//print_r($data);die;
	$this->load->view('spare/issue-spare-sm',$data);

}

function issue_spare()
{

	$data['pid'] = $_GET['PID'];
	$data['hid'] = $_GET['HID'];
	$data['wid'] = $_GET['WID'];
	//print_r($data);die;
	$this->load->view('spare/issue-spare',$data);

}

function add_spare_issue()
{
	//$this->load->view('add-spare-issue');
	if($this->session->userdata('is_logged_in'))
    {
    	$this->load->view('spare/add-spare-issue');
	}
	else
	{
		redirect('index');
	}
}


function add_spare_sm_issue()
{
	//$this->load->view('add-spare-sm-issue');
	if($this->session->userdata('is_logged_in'))
    {
    	$this->load->view('spare/add-spare-sm-issue');
	}
	else
	{
		redirect('index');
	}
}


/*function product_spare_issue()
{

	if($this->session->userdata('is_logged_in'))
    {
    	$this->load->view('product-spare-issue');
	}
	else
	{
		redirect('index');
	}
}

function product_spare_sm_issue()
{

	if($this->session->userdata('is_logged_in'))
    {
    	$this->load->view('product-spare-sm-issue');
	}
	else
	{
		redirect('index');
	}
}*/

function getRack()
{
	$data['id'] = $_GET['location_rack_id'];
	$this->load->view('spare/getRack',$data);
}


public function getRackQty()
{
	$rackQty=$this->db->query("select SUM(quantity) as s from tbl_product_serial where rack_id='".$_GET['location_rack_id']."' and product_id='".$_GET['pid']."'");
	$getQty=$rackQty->row();
	echo $getQty->s;
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


function insert_spare_issue_data()
{

	
	@extract($_POST);
	$table_name='tbl_spare_issue_hdr';

	$rows=$this->input->post('cntVal');

	$maker_id    = $this->session->userdata('user_id');
	$author_id   = $this->session->userdata('user_id');
	$comp_id     = $this->session->userdata('comp_id');
	$divn_id     = $this->session->userdata('divn_id');
	$zone_id     = $this->session->userdata('zone_id');
	$brnh_id     = $this->session->userdata('brnh_id');
	$maker_date  = date('Y-m-d');
	$author_date = date('Y-m-d');
		
	$issue=$this->db->query("select * from tbl_spare_issue_hdr where workorder_id='$workorder_id' AND workorder_spare_id='$workorder_spare_id' AND spare_id='$spareids'");
	$getIssue=$issue->row();
	$count=$issue->num_rows();

	$wosphdrid=$this->input->post('workorder_spare_id');
	$workordid=$this->input->post('workorder_id');
	//echo $count;die;

	$wo=$this->db->query("SELECT * FROM tbl_work_order_maintain where id='$workordid'");
	$getWorkid=$wo->row();
	$machine_id=$getWorkid->machine_name;
	$mac=$this->db->query("select * from tbl_machine where id='$machine_id' ");
	$getMac=$mac->row();
	$section_id=$getMac->m_type;



	if($count > 0)
	{


		for($i=0;$i<$rows;$i++)
		{

			if($spare_qty[$i] != '')
			{

				$this->db->query("update tbl_spare_issue_dtl set qty= qty + $spare_qty[$i] where issue_id_hdr='$getIssue->issue_id' AND spare_id='$spareids' AND type='$via_types' AND location='$location_id[$i]' AND rack='$rack_id[$i]' AND vendor='$vendor_id[$i]' AND price='$purchase_price[$i]'");

				$this->db->query("insert into tbl_spare_issue_log set issue_id_hdr='$getIssue->issue_id',spare_id='$spareids',type='$via_types',location='$location_id[$i]',rack='$rack_id[$i]',vendor='$vendor_id[$i]',price='$purchase_price[$i]',qty='$spare_qty[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

				$qty=$this->db->query("select SUM(qty) as totalqty from tbl_spare_issue_dtl where issue_id_hdr='$getIssue->issue_id' AND spare_id='$spareids'");
				$getQty=$qty->row();
				$this->db->query("update tbl_workorder_spare_dtl set issue_qty='$getQty->totalqty' where spare_hdr_id='$workorder_spare_id' AND spare_id='$spareids' ");

				$total_spent=$spare_qty[$i] * $purchase_price[$i];

				$this->add_software_cost_log($getIssue->issue_id,'Spare',$section_id,$machine_id,$workordid,$spare_qty[$i],$purchase_price[$i],$total_spent);

				$this->software_stock_log_insert($getIssue->issue_id,'Issue',$vendor_id[$i],$spareids,$spare_qty[$i],$purchase_price[$i]);

				$this->stock_refill_qty($spareids,$via_types,$location_id[$i],$rack_id[$i],$vendor_id[$i],$purchase_price[$i],$spare_qty[$i]);

			}			
			
		}

		echo $wosphdrid."^".$workordid;

	}
	else
	{

		$this->db->query("insert into tbl_spare_issue_hdr set spare_id='$spareids', workorder_id='$workorder_id', workorder_spare_id='$workorder_spare_id', bin_card_type='Issue', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

		$lastId=$this->db->insert_id();

		for($i=0;$i<$rows;$i++)
		{

			if($spare_qty[$i] != '')
			{

				$this->db->query("insert into tbl_spare_issue_dtl set issue_id_hdr='$lastId',spare_id='$spareids',type='$via_types',location='$location_id[$i]',rack='$rack_id[$i]',vendor='$vendor_id[$i]',price='$purchase_price[$i]',qty='$spare_qty[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

				$this->db->query("insert into tbl_spare_issue_log set issue_id_hdr='$lastId',spare_id='$spareids',type='$via_types',location='$location_id[$i]',rack='$rack_id[$i]',vendor='$vendor_id[$i]',price='$purchase_price[$i]',qty='$spare_qty[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

				$qty=$this->db->query("select SUM(qty) as totalqty from tbl_spare_issue_dtl where issue_id_hdr='$lastId' AND spare_id='$spareids'");
				$getQty=$qty->row();
				$this->db->query("update tbl_workorder_spare_dtl set issue_qty='$getQty->totalqty' where spare_hdr_id='$workorder_spare_id' AND spare_id='$spareids' ");


				$total_spent=$spare_qty[$i] * $purchase_price[$i];

				$this->add_software_cost_log($lastId,'Spare',$section_id,$machine_id,$workordid,$total_spent);

				$this->software_stock_log_insert($lastId,'Issue',$vendor_id[$i],$spareids,$spare_qty[$i],$purchase_price[$i]);
				
				$this->stock_refill_qty($spareids,$via_types,$location_id[$i],$rack_id[$i],$vendor_id[$i],$purchase_price[$i],$spare_qty[$i]);

			}
			
		}

		echo $wosphdrid."^".$workordid;

	}
							

}



public function stock_refill_qty($main_id,$type,$loc,$rack_id,$vendor_id,$purchase_price,$qty)
{
		
	$this->db->select('*');
	$array = array('product_id' => $main_id,'module_status' => $type, 'loc' => $loc, 'rack_id' => $rack_id,'supp_name' => $vendor_id,'purchase_price' => $purchase_price);
	$this->db->where($array);
	$query = $this->db->get('tbl_product_serial');
	//print_r($array);die;
	$num = $query->num_rows();

    //echo $num."aaa"; die;
	if($num>0)
	{
	
		$this->db->query("update tbl_product_serial set quantity=quantity-$qty where product_id='$main_id' and module_status='$type' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");
		$p_Q=$this->db->query("update tbl_product_stock set quantity=quantity-$qty where Product_id='$main_id' ");
		$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='spare issue',name_role='workorder spare issue',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=NOW(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
		$this->db->query($sqlProdLoc1);

	}

}


function ajex_IssueListData()
{	
	$data['shid'] = $this->input->post('wospid');
	$data['wids'] = $this->input->post('woid');
	//print_r($data);
	$this->load->view('spare/load-product-issue',$data);
}

/*==============================================================================================*/
}
?>