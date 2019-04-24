<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class admin extends my_controller {

	public function manage_user(){
	
	$data=$this->user_function();// call permission fnctn
	
	if($this->session->userdata('is_logged_in')){

	$this->load->view('manage-user',$data);
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}
	public function add_user(){
	
	
	if($this->session->userdata('is_logged_in')){
	
		$this->load->view('add-user');
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}
	
	public function insert_user(){
	
	
		extract($_POST);
		$table_name ='tbl_user_mst';
		$pri_col ='user_id';
	 	$id= $this->input->post('user_id');
		$data = array(
					//$sesio,
					'user_name' => $this->input->post('user_name'),
					'password' => $this->input->post('password'),
					'comp_id' => $this->input->post('comp_id'),
					'phone_no' => $this->input->post('phone_no'),
					'zone_id' => $this->input->post('zone_id'),
					'brnh_id' => $this->input->post('brnh_id'),
					'divn_id' => $this->input->post('divn_id'),
					'email_id' => $this->input->post('email_id')
					);
					
			$sesio = array(
					
					'compa_id' => $this->session->userdata('comp_id'),
					'divna_id' => $this->session->userdata('divn_id'),
					'zonea_id' => $this->session->userdata('zone_id'),
					'brnha_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
			$dataall=array_merge($data,$sesio);
				
		$this->load->model('Model_admin_login');
		if($id!=''){
					$this->Model_admin_login->update_user($pri_col,$table_name,$id,$dataall);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
				$this->Model_admin_login->insert_user($table_name,$dataall);
				redirect('/index.php/admin/manage_user');
				}
}
	
	
	
	
	
	
	function delete_user() {
	$table_name ='tbl_user_mst';
	$pri_col ='user_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_user');
}
//-----------------------------start item function ----------------------------

//-----------------------------start wing function ----------------------------


	public function manage_wing(){
	
	if($this->session->userdata('is_logged_in')){
	
	
	$data=$this->user_function();// call permission fnctn
	
	$this->load->view('admin/manage-wing',$data);
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}

	public function insert_wing(){
		
		extract($_POST);
		$table_name ='tbl_wing_mst';
		 $pri_col ='divn_id';
	 	$id= $this->input->post('divn_id');
		$data = array(
					
					'code' => $this->input->post('code'),
					'divn_name' => $this->input->post('divn_name'),
					'brnh_id' => $this->input->post('brnh_id')
					
					);
		$sesio = array(
					'comp_id' => $this->session->userdata('comp_id'),
					'divna_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnha_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
			$dataall=array_merge($data,$sesio);
					
		$this->load->model('Model_admin_login');
		
		if($id!=''){
		
					$this->Model_admin_login->update_user($pri_col,$table_name,$id,$dataall);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
				$this->Model_admin_login->insert_user($table_name,$dataall);
				redirect('/index.php/admin/manage_wing');
				}
				
			}	
			
		public function add_wing(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-wing');
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}
	


	function delete_wing() {
	$table_name ='tbl_wing_mst';
	$pri_col ='divn_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_wing');
}
	

			

//-------------------------close wing function---------------------------------	
///----------------------Map User Role starts-----------------------------------
public function map_user_role(){

	if($this->session->userdata('is_logged_in')){
		$this->load->view('user-role');
}
	else
	{
	redirect('/admin/index');
	}
	
}

public function mapped_user_role(){

	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();//permission call function
		$this->load->view('manage-user-role',$data);
}
	else
	{
	redirect('/admin/index');
	}
	
}
public function insert_user_role(){
			
		@extract($_POST);
		$table_name ='tbl_user_role_mst';
		$pri_col ='user_role_id';
	 	$id= $this->input->post('user_role_id');
		
		$data = array(
					'user_id' => $this->input->post('user_id'),
					'role_id' => $this->input->post('role_id'),
					
				//	'negative_cash' => $this->input->post('negative_cash'),
					//'nagative_stock' => $this->input->post('nagative_stock'),
					);
		 $sesio = array(
					
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
					
		$this->load->model('Model_admin_login');
			//print_r($data);
			//die;
		if($id!=''){
				
					$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
				$this->Model_admin_login->insert_user($table_name,$data);
				redirect('/index.php/admin/mapped_user_role');
				
				}
				
			}	
	

function delete_user_role(){
	$table_name ='tbl_user_role_mst';
	$pri_col ='user_role_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/mapped_user_role');
	}
///----------------------Map User Role ends-----------------------------------

//----------------------------------start master data function-----------------------


	public function insert_master_data(){
		
		extract($_POST);
		$table_name ='tbl_master_data';
		 $pri_col ='serial_number';
	 	$id= $this->input->post('serial_number');
		$data = array(
					
					'param_id' => $this->input->post('param_id'),
					'keyvalue' => $this->input->post('keyvalue'),
					'description' => $this->input->post('description')
					
					);
		$sesio = array(
					
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
			$dataall=array_merge($data,$sesio);
			
					
		$this->load->model('Model_admin_login');
		
		if($id!=''){
		
					$this->Model_admin_login->update_user($pri_col,$table_name,$id,$dataall);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
				$this->Model_admin_login->insert_user($table_name,$dataall);
				redirect('/index.php/admin/manage_master_data');
				}
				
			}	
			
		public function add_master_data(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-master-data');
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}
	
	public function manage_master_data(){
	
	
	if($this->session->userdata('is_logged_in')){
	
	$data=$this->user_function();// call permission fnctn
	
	$this->load->view('manage-master-data',$data);
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}

	function delete_master_data(){
	$table_name ='tbl_master_data';
	$pri_col ='serial_number';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_master_data');
}
	

			

//--------------------------close master data -----------------------------------	

//-----------------role function---------------	
public function add_role(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-role');
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}	

public function manage_role(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
		$this->load->view('manage-role',$data);
	}
	else
	{
	redirect('/admin/index');
	}

}

function delete_role() {
	$table_name ='tbl_role_mst';
	$pri_col ='role_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_role');
}

public function insert_role(){
	
	extract($_POST);
		$tablename ='tbl_role_mst';
		$pri_col ='role_id';
	 	$id= $this->input->post('role_id');
		
		$action1= $this->input->post('action1');
		$action2= $this->input->post('action2');
		$action3= $this->input->post('action3');
		$action4= $this->input->post('action4');
		$ction =$action1."-".$action2."-".$action3."-".$action4;
				
		$data = array(
					'code' => $this->input->post('code'),
				'role_name' => $this->input->post('role_name'),
					'action'=>$ction
					);
					
//create session					
					
			$sesio = array(
					'comp_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
			$dataall=array_merge($data,$sesio);
		
		$dataall = array_merge($data,$sesio);
		
				$this->load->model('Model_admin_login');
		if($id!=''){
					$this->Model_admin_login->update_user($pri_col,$tablename,$id,$dataall);
					echo "<script type='text/javascript'>;";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>;";
					}
		else
				{
				
				$this->Model_admin_login->insert_user($tablename,$dataall);
				redirect('/index.php/admin/manage_role');
				}
}



	//--------------------------close role data -----------------------------------	

	//-----------------branch function----------------
	
public function manage_branch(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
	$this->load->view('manage-branch',$data);
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}
	
public function add_branch(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-branch');
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}


	public function insert_branch(){
		
		extract($_POST);
		$table_name ='tbl_branch_mst';
		 $pri_col ='brnh_id';
		
	 	$id= $this->input->post('brnh_id');
		$data = array(
					
					'code' => $this->input->post('code'),
					'brnh_name' => $this->input->post('brnh_name'),
					'comp_id' => $this->input->post('comp_id'),
					'zone_id' => $this->input->post('zone_id')
					);
		$sesio = array(
					
					'compa_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zonea_id' => $this->session->userdata('zone_id'),
					'brnha_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);
					
		$this->load->model('Model_admin_login');
		
		if($id!=''){
		
					$this->Model_admin_login->update_user($pri_col,$table_name,$id,$dataall);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
				$this->Model_admin_login->insert_user($table_name,$dataall);
				redirect('/index.php/admin/manage_branch');
				}
				
			}	
			
function delete_branch() {
	$table_name ='tbl_branch_mst';
	$pri_col ='brnh_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_branch');
}
	
			
//-------------------close branch function---------------------	
public function add_item(){


	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-item');
}
	else
	{
	redirect('/admin/index');
	}
}

//-----------------region function----------------

public function add_region(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-region');
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}	

public function manage_region(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
		$this->load->view('manage-region',$data);
	}
	else
	{
	redirect('/admin/index');
	}
	
	
}	
	public function insert_region(){
	extract($_POST);
		$tablename ='tbl_region_mst';
		$pri_col ='zone_id';
	 	$id= $this->input->post('zone_id');
		
		$data = array(
					'code' => $this->input->post('code'),
					'comp_id' => $this->input->post('comp_id'),
					'zone_name' => $this->input->post('zone_name')
					);
		$sesio = array(
					
					'compa_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zonea_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
		
		$dataall = array_merge($data,$sesio);

									
		$this->load->model('Model_admin_login');
		if($id!=''){
					$this->Model_admin_login->update_user($pri_col,$tablename,$id,$dataall);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
				
				$this->Model_admin_login->insert_user($tablename,$dataall);
				redirect('/index.php/admin/manage_region');
				}
}
	

function delete_region() {
	$table_name ='tbl_region_mst';
	$pri_col ='zone_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_region');
}


//-------------------close region function---------------------	



		public function getregion(){
	
		$data['zone_id']=$_GET['zone_id'];
		$this->load->view('get-zone',$data);
	
	}
		
		
	public function getBranch(){
	
		$data['zone_id']=$_GET['zone_id'];
		$this->load->view('get_branch',$data);
	
	}
	
	public function getDivision(){
	
		$data['branch_id']=$_GET['branch_id'];
		$this->load->view('get_division',$data);
	
	}
	public function get_cid(){
	$data=$this->user_function();// call permission function
	
		$this->load->view('get_cid',$data);
	
	}
	
	
	public function logout(){
	
		$this->session->sess_destroy();
		redirect('/user/index');
}

//---------------state--------------------
public function getState(){
	
		$data['country']=$_GET['country'];
		$this->load->view('get_state',$data);
	
	}
	
	public function getCity(){
	
		$data['state']=$_GET['state'];
		$this->load->view('get_city',$data);
	
	}

//---------------Group--------------------
public function getgroup(){
	
		$data['group']=$_GET['group'];
		$this->load->view('get_group',$data);
	
	}
	
//-----------------role_function_action function----------------


public function role_function_action(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('role-function-action');
	}
	else
	{
	redirect('/admin/index');
	}
}

public function role_function_permision(){


 	 $drid =$this->input->post('drid');
	 $cid =$this->input->post('cid');
	 $module_id=$this->input->post('module_id');
	 $role_id=$this->input->post('role_id');
	 @$r =@count(@$drid);
	 @$rc=@count(@$cid);
	
	@$z=$rc-1;
	
	for($i=0;$i<$rc;$i++){
	
	
	 @$tbl_qry = $this->db->query("select count(status) as r1 from tbl_role_func_action where function_url='". $cid[$i]."' and role_id='".$role_id."'");
		 @$userFetch = $tbl_qry->row();
		 $rl1= @$userFetch->r1;
		 if($rl1>0)
		{
		 @$tbl_sql=$this->db->query("update tbl_role_func_action set action_id='".$drid[$i]."' where function_url='".$cid[$i]."' and role_id='".$role_id."'");	
		}else{
		@$tbl_sql=$this->db->query("insert into tbl_role_func_action set action_id='".$drid[$i]."',function_url='".$cid[$i]."', role_id='".$role_id."',module_id='".$module_id."'");
		@$tbl_sql="";
		
		}
		if($i==$z){
		redirect('/index.php/admin/role_function_action');}
		}
	
}

//-----------------Close role_function_action function----------------


//-----------------Enterprise starts function----------------
public function manage_enterprise(){
	
	if($this->session->userdata('is_logged_in')){
$data=$this->user_function();// call permission fnctn
	$this->load->view('manage-enterprise',$data);
	}
	else
	{
	redirect('/admin/index');
	}
}


public function add_enterprise(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('add-enterprise');
	}
	else
	{
	redirect('/admin/index');
	}
}

public function insert_enterprise(){
	
		@extract($_POST);
		$table_name ='tbl_enterprise_mst';
		$pri_col ='comp_id';
	 	$id= $this->input->post('comp_id');
		$data= array(
					'code' => $this->input->post('code'),
					'comp_name' => $this->input->post('comp_name'),
					);
		$sesio = array(
					
					'compa_id' => $this->session->userdata('comp_id'),
					'divn_id' => $this->session->userdata('divn_id'),
					'zone_id' => $this->session->userdata('zone_id'),
					'brnh_id' => $this->session->userdata('brnh_id'),
					'maker_id' => $this->session->userdata('user_id'),
					'author_id' => $this->session->userdata('user_id'),
					'maker_date'=> date('y-m-d'),
					'author_date'=> date('y-m-d')
					);
		
		$data_entr = array_merge($data,$sesio);
		$this->load->model('Model_admin_login');
		if($id!=''){
					$this->Model_admin_login->update_user($pri_col,$table_name,$id,$data_entr);
					echo "<script type='text/javascript'>";
					echo "window.close();";
					echo "window.opener.location.reload();";
					echo "</script>";
					}
		else
				{
		    	$this->Model_admin_login->insert_user($table_name,$data_entr);
				redirect('/index.php/admin/manage_enterprise');
				}
	
	}
	
	function delete_enterprise() {
	$table_name ='tbl_enterprise_mst';
	$pri_col ='comp_id';
	$this->load->model('Model_admin_login');
		$id= $_GET['id'];
		$this->Model_admin_login->delete_user($pri_col,$table_name,$id);
		redirect('/index.php/admin/manage_enterprise');
}
//----------------- Close Enterprise starts function----------------
	
public function get_pop(){

if($this->session->userdata('is_logged_in')){
$this->load->view('add-account-popup');
}
else
{
redirect('/admin/index');
}
}
public function get_popp(){


if($this->session->userdata('is_logged_in')){
$this->load->view('add-account-popup2');
}
else
{
redirect('/admin/index');
}
}
	
//--------------------------close account function ---------------------------





	
}


?>