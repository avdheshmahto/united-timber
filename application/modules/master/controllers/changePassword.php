<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class changePassword extends my_controller {

public function changepwd(){
	
	if($this->session->userdata('is_logged_in')){
		$this->load->view('changePassword/change-password');
	}
	else
	{
	redirect('index');
	}
		
}





public function qureychange_pass(){

	$table_name = 'tbl_user_mst';

	//$this->load->model('Model_admin_login');

	$user_id = $this->session->userdata('user_id');

	//$this->load->view('change-password');

	//echo $user_id;exit;

	$sql = "select * from `tbl_user_mst` where `user_id` = '$user_id'";

	$re = $this->db->query($sql);

	$fetchdata = $re->row();	

	$fetchpass = $fetchdata->password;

		extract($_POST);

		$oldpass;

		$newpass;

		$confirmpass;

		if($fetchpass !='' && $oldpass!='' && $newpass!='' && $confirmpass!=''){

			if($fetchpass == $oldpass){

				if($newpass == $confirmpass){

			$sql2 = "UPDATE `tbl_user_mst` SET `password` = '$confirmpass' where `user_id` = '$user_id'";

		

			$qr = $this->db->query($sql2);	

					

					if($qr){											                        	 

						print "<script type=\"text/javascript\">

						alert('Password Changed Successfully ');

						window.location.href='changepwd';

						</script>";					 

				   }

				}else{		

						print "<script type=\"text/javascript\">

						alert('The New-password and confirmation-password do not match.');

						window.location.href='changepwd';

						</script>";

				   }

			}else{				

                    print "<script type=\"text/javascript\">

					alert('Wrong Current Password');

					window.location.href='changepwd';

					</script>";					

				  }		

		}

	

}



}

?>