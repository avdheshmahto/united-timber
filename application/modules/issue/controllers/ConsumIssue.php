<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);

class ConsumIssue extends my_controller {

function __construct()
{
	parent::__construct(); 
	$this->load->library('pagination');
	$this->load->model('model_issue');	
}     

/*==================Start Consumeable Issue ================================*/

function manage_consumable_issue() 
{

    if($this->session->userdata('is_logged_in'))
    {
    	$data = $this->manageConsumJoinfun();
    	$this->load->view('consumable/manage-consumable-issue',$data);
	}
	else
	{
		redirect('index');
	}

}

public function manageConsumJoinfun()
{
    
	$table_name='tbl_consum_issue_hdr';
	$data['result'] = "";
	////Pagination start ///
	$url   = site_url('/issue/ConsumIssue/manage_consum_issue?');
	$sgmnt = "4";

	if($_GET['entries']!="")
	$showEntries = $_GET['entries'];
	else
	$showEntries = 10;


	$totalData   = $this->model_issue->count_allConsum($table_name,'A',$this->input->get());


	if($_GET['entries']!="" && $_GET['filter'] == ""){
	$url   = site_url('/issue/ConsumIssue/manage_consum_issue?entries='.$_GET['entries']);
	}elseif($_GET['filter'] != ""){
	$url   = site_url('/issue/ConsumIssue/manage_consum_issue?entries='.$_GET['entries'].'&location_rack_id='.$_GET['location_rack_id'].'&rack_name='.$_GET['rack_name'].'&filter='.$_GET['filter']);
	// sku_no=&category=&productname=Bearing+&usages_unit=&purchase_price=&filter=filter
	}

	$pagination = $this->ciPagination($url,$totalData,$sgmnt,$showEntries);
	$data       = $this->user_function();
	//////Pagination end ///
	$data['dataConfig']        = array('total'=>$totalData,'perPage'=>$pagination['per_page'],'page'=>$pagination['page']);
	$data['pagination']        = $this->pagination->create_links();

	if($this->input->get('filter') == 'filter' || $_GET['entries']!='')   ////filter start ////
	$data['result']          = $this->model_issue->filterConsumList($pagination['per_page'],$pagination['page'],$this->input->get());
	else	
	$data['result']          = $this->model_issue->getConsumIssueData($pagination['per_page'],$pagination['page']);

	// call permission fnctn
	$data['categorySelectbox'] = $this->model_issue->categorySelectbox();
	return $data;

}


function insert_consumable_issue()
{

	
	@extract($_POST);
	$table_name='tbl_consum_issue_hdr';

	$rows=count($spareids);

	$maker_id    = $this->session->userdata('user_id');
	$author_id   = $this->session->userdata('user_id');
	$comp_id     = $this->session->userdata('comp_id');
	$divn_id     = $this->session->userdata('divn_id');
	$zone_id     = $this->session->userdata('zone_id');
	$brnh_id     = $this->session->userdata('brnh_id');
	$maker_date  = date('Y-m-d');
	$author_date = date('Y-m-d');
		
							
	$this->db->query("insert into tbl_consum_issue_hdr set section='$section',maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");
	
	$lastId=$this->db->insert_id();

	$mac=$this->db->query("select * from tbl_machine where m_type='$section' ");
	$getMac=$mac->row();
	
	if(sizeof($mac->result_array()) > 0){
		$machineid=$getMac->id;
	}else{
		$machineid='';
	}	

	for($i=0;$i<$rows;$i++)
	{

		$this->db->query("insert into tbl_consum_issue_dtl set issue_id_hdr='$lastId',spare_id='$spareids[$i]',type='$via_types[$i]',location='$locs[$i]',rack='$racks[$i]',vendor='$vendors[$i]',price='$prices[$i]',qty='$qtyname[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");

		$total_spent=$qtyname[$i] * $prices[$i];

		$this->add_software_cost_log($lastId,'Consumable',$section,$machineid,'',$spareids[$i],$qtyname[$i],$prices[$i],$total_spent);

		$this->software_stock_log_insert($lastId,'Consumable Issue',$vendors[$i],$spareids[$i],$qtyname[$i],$prices[$i]);		

		$this->stock_refill_qty($spareids[$i],$via_types[$i],$locs[$i],$racks[$i],$vendors[$i],$prices[$i],$qtyname[$i]);
		
	}

	echo 1;


}



public function stock_refill_qty($main_id,$type,$loc,$rack_id,$vendor_id,$purchase_price,$qty)
{
		
	$this->db->select('*');
	$array = array('product_id' => $main_id,'module_status' => $type, 'loc' => $loc, 'rack_id' => $rack_id,'supp_name' => $vendor_id,'purchase_price' => $purchase_price);
	$this->db->where($array);
	$query = $this->db->get('tbl_product_serial');
	//print_r($array);die;
	$num = $query->num_rows();

	if($num>0)
	{
	
		$this->db->query("update tbl_product_serial set quantity =quantity-$qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");
		$p_Q=$this->db->query("update tbl_product_stock set quantity =quantity-$qty where Product_id='$main_id' ");
		$sqlProdLoc1="insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='consumable issue',name_role='section consumable issue',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=NOW(), author_id='".$this->session->userdata('user_id')."', maker_id='".$this->session->userdata('user_id')."', divn_id='".$this->session->userdata('divn_id')."', comp_id='".$this->session->userdata('comp_id')."', zone_id='".$this->session->userdata('zone_id')."', brnh_id='".$this->session->userdata('brnh_id')."' ";
		$this->db->query($sqlProdLoc1);
	}

}


function ajex_IssueDataConsumable()
{	
	$data = $this->manageConsumJoinfun();
	$this->load->view('consumable/load-consumable-issue',$data);
}


function view_consumable_issue()
{

	if($this->session->userdata('is_logged_in'))
    {
		$this->load->view('consumable/view-consumable-issue');
	}
	else
	{
		redirect('index');
	}

}


function getRack()
{
	$data['id'] = $_GET['location_rack_id'];
	$this->load->view('consumable/getRack',$data);
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
	$sum=$getData->quantity;
	$abc=$abc+$sum;
	echo "Rack Name Is:-".$getLocation->rack_name." and Qty is:-".$sum."<br>";

	}
	echo "Total Quantity Is :-".$abc;
	}
	else
	{
	echo "No Record found";	
	}

}

public function get_vendor_list()
{
	$prdct_id=$this->input->post('pid');
    $loct=$this->input->post('loc');
    $rackid=$this->input->post('rack');

	$vndr=$this->db->query("select * from tbl_product_serial where product_id='$prdct_id' AND loc='$loct' AND rack_id='$rackid'");
	//$getVndr=$vndr->result();
	$count=$vndr->result_array();
	$v_array=array();
	foreach ($vndr->result() as $getVndr) 
	{
		array_push($v_array, $getVndr->supp_name);
	}
	//print_r($v_array);\
	if(sizeof($count) > 0){
		$cntid=implode(",", $v_array);	
	}else{
		$cntid='9999999';
	}
	
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


public function check_product_type()
{
	$prdctid=$this->input->post('pid');
	$product=$this->db->query("select * from tbl_product_stock where Product_id='$prdctid'");
	$getProductRow=$product->row();

	echo $getProductRow->via_type;
}

public function consumeable_issue_page()
{
	$data['pid']=$_GET['PID'];
	$this->load->view('consumable/getConsumeablePage',$data);
}

/*=====================================================================*/
}
?>