<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Rolefunction extends my_controller {

	
//-----------------role_function_action function----------------


public function role_function_action(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('/rolefunction/role-function-action');
	}
	else
	{
	redirect('index');
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
		redirect('admin/rolefunction/role_function_action');}
		}
	
}

//-----------------Close role_function_action function----------------

	
}


?>