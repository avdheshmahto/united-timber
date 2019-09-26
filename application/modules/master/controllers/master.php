<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting (E_ALL ^ E_NOTICE);
class master extends my_controller {


 	function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('model_master');
    }
    

    public function dashboard()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('dashboard/dashboard');
        } else {
            redirect('index');
        }
        
    }


    public function filterSectionExpense()
    {

    	 $data = array(
            'section_id' => $_POST['section'],
            'myear' 	 => $_POST['year']
        );
        //print_r($data);
        echo $this->load->view("dashboard/section-expense",$data);

    }


    public function filterMachineExpense()
    {

    	$data = array(

    		'section_id' => $_POST['section'],
    		'machine_id' => $_POST['machine'],
    		'date_from'  => $_POST['fromdate'],
    		'date_to'    => $_POST['todate'],

    		);

    	//print_r($data);
    	echo $this->load->view("dashboard/machine-expense",$data);

    }


    public function filterTypeExpense()
    {

    	$data = array(

    		'section_id' => $_POST['section1'],
    		'machine_id' => $_POST['machine1'],
    		'date_from'  => $_POST['fromdate1'],
    		'date_to'    => $_POST['todate1'],

    		);

    	//print_r($data);
    	echo $this->load->view("dashboard/type-expense",$data);

    }

    public function filterSpareExpense()
    {

    	$data = array(

            'section_ids' => $_POST['spsection'],
    		'machine_ids' => $_POST['machineid'],
    		'spare_types' => $_POST['sparetype'],
    		'date_from3'  => $_POST['date_from'],
    		'date_to3'    => $_POST['date_to'],

    		);

    	//print_r($data);
    	echo $this->load->view("dashboard/spare-consume",$data);

    }


    public function filterBreakdownHours()
    {

        $data = array(

            'bdsection' => $_POST['bsection'],
            'byear'     => $_POST['bkdnyear'],

        );
        //print_r($data);
        echo $this->load->view("dashboard/breakdown-hours",$data);

    }

    public function filterSparesHours()
    {

        $data = array(

            'section_id' => $_POST['section'],
            'machine_id' => $_POST['machine'],
            'date_from7' => $_POST['date_from'],
            'date_to7'   => $_POST['date_to'],

            );

        //print_r($data);
        echo $this->load->view("dashboard/spares-hours",$data);

    }

	
} ?>