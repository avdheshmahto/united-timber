<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Branch extends my_controller {

	
//-----------------branch function----------------
	
public function manage_branch(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
	$this->load->view('/branch/manage-branch',$data);
	}
	else
	{
	redirect('index');
	}
	
	
}
	
public function add_branch(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('/branch/add-branch');
	}
	else
	{
	redirect('index');
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
				redirect('/admin/branch/manage_branch');
				}
				
			}	

			
			
		public function getregion(){
	
		$data['zone_id']=$_GET['zone_id'];
		$this->load->view('admin/branch/get-zone',$data);
	
	}
	
	
//-------------------close branch function---------------------	
	public function branch_list()
	{
		$info=array();
		
		$res = $this -> db
           -> select('*')
           -> where('status','A')
           -> get('tbl_branch_mst');
		   
		$i='0';
		
		foreach($res->result() as $row)
		{
	
		  $compQuery = $this -> db
           -> select('*')
           -> where('status','A','comp_id',$row->comp_id)
           -> get('tbl_enterprise_mst');
		  $compRow = $compQuery->row();

 		 $zoneQuery = $this -> db
           -> select('*')
           -> where('status','A','zone_id',$row->zone_id)
           -> get('tbl_region_mst');
		  $zoneRow = $zoneQuery->row();
		
			$info[$i]['1']=$row->code;
			$info[$i]['2']=$row->brnh_name;
			$info[$i]['3']=$compRow->comp_name;
			$info[$i]['4']=$zoneRow->zone_name;
			$info[$i]['5']=$row->brnh_id;
			
				$i++;
			
		}
		return $info;
	
	}
	
}


?>