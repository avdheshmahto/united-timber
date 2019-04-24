<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Mapuser extends my_controller {

	
///----------------------Map User Role starts-----------------------------------
public function map_user_role(){

	if($this->session->userdata('is_logged_in')){
		$this->load->view('/mapuser/user-role');
}
	else
	{
	redirect('index');
	}
	
}

public function mapped_user_role(){

	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();//permission call function
		$this->load->view('/mapuser/manage-user-role',$data);
}
	else
	{
	redirect('index');
	}
	
}

public function userroll_list()
	{
		$info=array();
		
		$res = $this -> db
           -> select('*')
           -> where('status','A')
           -> get('tbl_user_role_mst');
		   
		$i='0';
		
		foreach($res->result() as $row)
		{
	
		  $compQuery = $this -> db
           -> select('*')
           -> where('user_id',$row->user_id)
           -> get('tbl_user_mst');
		  $compRow = $compQuery->row();

 		 $zoneQuery = $this -> db
           -> select('*')
           -> where('role_id',$row->role_id)
           -> get('tbl_role_mst');
		  $zoneRow = $zoneQuery->row();
		
			
			$info[$i]['1']=$compRow->user_name;
			$info[$i]['2']=$zoneRow->role_name;
			$info[$i]['3']=$row->user_role_id;
				$i++;
			
		}
		return $info;
	
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
				redirect('/admin/mapuser/mapped_user_role');
				
				}
				
			}	
	
///----------------------Map User Role ends-----------------------------------




	
}


?>