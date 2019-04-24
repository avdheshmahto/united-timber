<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Wing extends my_controller {

	
//-----------------------------start wing function ----------------------------


	public function manage_wing(){
	
	if($this->session->userdata('is_logged_in')){
	
	
	$data=$this->user_function();// call permission fnctn
	
	$this->load->view('/wing/manage-wing',$data);
	}
	else
	{
	redirect('index');
	}
	
	
}

public function wing_list()
	{
		$info=array();
		
		$res = $this -> db
           -> select('*')
           -> where('status','A')
           -> get('tbl_wing_mst');
		   
		$i='0';
		
		foreach($res->result() as $row)
		{
	
		  $compQuery = $this -> db
           -> select('*')
           -> where('status','A','brnh_id',$line->brnh_id)
           -> get('tbl_branch_mst');
		  $compRow = $compQuery->row();

 				
			$info[$i]['1']=$row->code;
			$info[$i]['2']=$row->divn_name;
			$info[$i]['3']=$compRow->brnh_name;
			$info[$i]['4']=$row->divn_id;
			
				$i++;
			
		}
		return $info;
	
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
				redirect('/admin/wing/manage_wing');
				}
				
			}	
			
		public function add_wing(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('/wing/add-wing');
	}
	else
	{
	redirect('index');
	}
	
	
}
	
	
//-------------------------close wing function---------------------------------	



	
}


?>