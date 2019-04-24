<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class Role extends my_controller {

	

//-----------------role function---------------	
public function add_role(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('/role/add-role');
	}
	else
	{
	redirect('index');
	}
	
	
}	

public function manage_role(){
	
	if($this->session->userdata('is_logged_in')){
	$data=$this->user_function();// call permission fnctn
		$this->load->view('/role/manage-role',$data);
	}
	else
	{
	redirect('index');
	}

}

	public function role_list()
	{
		$info=array();
		
		$res = $this -> db
           -> select('*')
           -> where('status','A','comp_id',$this->session->userdata('comp_id'))
           -> get('tbl_role_mst');
		   
		$i='0';
		
		foreach($res->result() as $row)
		{
	
			$info[$i]['1']=$row->code;
			$info[$i]['2']=$row->role_name;
			$info[$i]['3']=$row->role_id;		
				$i++;
			
		}
		return $info;
	
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
				redirect('/admin/role/manage_role');
				}
}



	//--------------------------close role data -----------------------------------	

	

	
}


?>