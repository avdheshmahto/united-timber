<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Region extends my_controller {


//-----------------region function----------------

public function add_region(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
		$this->load->view('region/add-region',$data);
	}
	else
	{
	redirect('index');
	}
	
	
}	
public function region_list()
	{
		$info=array();
		
		$res = $this -> db
           -> select('*')
           -> where('status','A')
           -> get('tbl_region_mst');
		   
		$i='0';
		
		foreach($res->result() as $row)
		{
		
		$divQuery = $this -> db
           -> select('*')
           -> where('comp_id',$row->comp_id)
           -> get('tbl_enterprise_mst');
		   
 	 $divRow = $divQuery->row();	
			
			$info[$i]['1']=$row->code;
			$info[$i]['2']=$row->zone_name;
			$info[$i]['3']=$divRow->comp_name;			
			$info[$i]['4']=$row->zone_id;
			
				$i++;
			
		}
		return $info;
	
	}		

public function manage_region(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
		$this->load->view('region/manage-region',$data);
	}
	else
	{
	redirect('index');
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
				redirect('/admin/region/manage_region');
				}
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




	
}


?>