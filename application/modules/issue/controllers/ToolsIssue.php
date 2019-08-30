<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

class ToolsIssue extends my_controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('model_issue');
    }
    
    /*============================Start ToolsIssue ========================*/
    
    function manage_tools_issue()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageToolsJoinfun();
            $this->load->view('tools/manage-tools-issue', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageToolsJoinfun()
    {
        
        $table_name     = 'tbl_tools_issue_hdr';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/issue/ToolsIssue/manage_tools_issue?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_issue->count_allTools($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] == "") {
            $url = site_url('/issue/ToolsIssue/manage_tools_issue?entries=' . $_GET['entries']);
        } elseif ($_GET['filter'] != "") {
            $url = site_url('/issue/ToolsIssue/manage_tools_issue?entries=' . $_GET['entries'] . '&location_rack_id=' . $_GET['location_rack_id'] . '&rack_name=' . $_GET['rack_name'] . '&filter=' . $_GET['filter']);
        }
        
        $pagination         = $this->ciPagination($url, $totalData, $sgmnt, $showEntries);
        $data               = $this->user_function();
        //////Pagination end ///
        $data['dataConfig'] = array(
            'total' => $totalData,
            'perPage' => $pagination['per_page'],
            'page' => $pagination['page']
        );
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->input->get('filter') == 'filter' || $_GET['entries'] != '') ////filter start ////
            $data['result'] = $this->model_issue->filterToolsList($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_issue->getToolsIssueData($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        $data['categorySelectbox'] = $this->model_issue->categorySelectbox();
        return $data;
        
    }
    
    
    function insert_tools_issue()
    {
        
        
        @extract($_POST);
        $table_name = 'tbl_tools_issue_hdr';
        
        $rows = count($spareids);
        
        $maker_id    = $this->session->userdata('user_id');
        $author_id   = $this->session->userdata('user_id');
        $comp_id     = $this->session->userdata('comp_id');
        $divn_id     = $this->session->userdata('divn_id');
        $zone_id     = $this->session->userdata('zone_id');
        $brnh_id     = $this->session->userdata('brnh_id');
        $maker_date  = date('Y-m-d');
        $author_date = date('Y-m-d');
        
        
        $this->db->query("insert into tbl_tools_issue_hdr set section='$section',machine='$machineid',issue_date='$issue_date',shift='$shift',maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");
        
        $lastId = $this->db->insert_id();
        
        /*$mac=$this->db->query("select * from tbl_machine where m_type='$section' ");
        $getMac=$mac->row();
        
        if(sizeof($mac->result_array()) > 0){
        $machineid=$getMac->id;
        }else{
        $machineid='';
        }    */
        
        for ($i = 0; $i < $rows; $i++) {
            
            $this->db->query("insert into tbl_tools_issue_dtl set issue_id_hdr='$lastId',spare_id='$spareids[$i]',type='$via_types[$i]',location='$locs[$i]',rack='$racks[$i]',vendor='$vendors[$i]',price='$prices[$i]',qty='$qtyname[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date=NOW()");
            
            $total_spent = $qtyname[$i] * $prices[$i];
            
            $this->add_software_cost_log($lastId, 'Tools', $issue_date, $section, $machineid, '', $spareids[$i], $qtyname[$i], $prices[$i], $total_spent, $shift);
            
            $this->software_stock_log_insert($lastId, 'Tools Issue', $vendors[$i], $spareids[$i], $qtyname[$i], $prices[$i]);
            
            $this->stock_refill_qty($spareids[$i], $via_types[$i], $locs[$i], $racks[$i], $vendors[$i], $prices[$i], $qtyname[$i]);
            
        }
        
        echo 1;
        
        
    }
    
    
    
    public function stock_refill_qty($main_id, $type, $loc, $rack_id, $vendor_id, $purchase_price, $qty)
    {
        
        $this->db->select('*');
        $array = array(
            'product_id' => $main_id,
            'module_status' => $type,
            'loc' => $loc,
            'rack_id' => $rack_id,
            'supp_name' => $vendor_id,
            'purchase_price' => $purchase_price
        );
        $this->db->where($array);
        $query = $this->db->get('tbl_product_serial');
        //print_r($array);die;
        $num   = $query->num_rows();
        
        //echo $num."aaa"; die;
        
        if ($num > 0) {
            
            $this->db->query("update tbl_product_serial set quantity =quantity-$qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");
            
            $p_Q = $this->db->query("update tbl_product_stock set quantity =quantity-$qty where Product_id='$main_id' ");
            
            //$this->db->query("update tbl_product_serial_log set quantity =quantity-$qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' and type='opening stock'");
            
            $sqlProdLoc1 = "insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='tools issue',name_role='section tools issue',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=NOW(), author_id='" . $this->session->userdata('user_id') . "', maker_id='" . $this->session->userdata('user_id') . "', divn_id='" . $this->session->userdata('divn_id') . "', comp_id='" . $this->session->userdata('comp_id') . "', zone_id='" . $this->session->userdata('zone_id') . "', brnh_id='" . $this->session->userdata('brnh_id') . "' ";
            $this->db->query($sqlProdLoc1);
        }
        
    }
    
    
    function ajex_IssueListData()
    {
        $data = $this->manageToolsJoinfun();
        $this->load->view('tools/load-tools-issue', $data);
    }
    
    
    function view_parts_issue()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('tools/view-tools-issue');
        } else {
            redirect('index');
        }
        
    }
    
    function return_parts()
    {
        if ($this->session->userdata('is_logged_in')) {
            
            $data['sid'] = $_GET['ISD'];
            $data['fid'] = $_GET['FID'];
            $data['tid'] = $_GET['PTP'];
            $data['sts'] = $_GET['STS'];
            $data['mac'] = $_GET['MAC'];
            //print_r($data);die;
            $this->load->view('tools/return-tools', $data);
            
        } else {
            redirect('index');
        }
    }
    
    
    function getRack()
    {
        $data['id'] = $_GET['location_rack_id'];
        $this->load->view('tools/getRack', $data);
    }
    
    
    public function getRackQty()
    {
        $rackQty = $this->db->query("select SUM(quantity) as qty from tbl_product_serial where rack_id='" . $_GET['location_rack_id'] . "' and product_id='" . $_GET['pid'] . "'");
        $getQty  = $rackQty->row();
        echo $getQty->qty;
    }
    
    public function getPalletQty()
    {
        
        $qtySerial = $this->db->query("select * from tbl_product_serial where loc='" . $_GET['loc'] . "' and product_id='" . $_GET['pri_id'] . "'");
        $getData1  = $qtySerial->row();
        $numCnt    = $qtySerial->num_rows();
        
        if ($numCnt > 0) {
            foreach ($qtySerial->result() as $getData) {
                
                $queryLocation = $this->db->query("select * from tbl_location_rack where id='$getData->rack_id'");
                $getLocation   = $queryLocation->row();
                $numCnt        = $queryLocation->num_rows();
                $sum           = $getData->quantity;
                $abc           = $abc + $sum;
                echo "Rack Name Is:-" . $getLocation->rack_name . " and Qty is:-" . $sum . "<br>";
                
            }
            echo "Total Quantity Is :-" . $abc;
        } else {
            echo "No Record found";
        }
        
    }
    
    public function get_vendor_list()
    {
        $prdct_id = $this->input->post('pid');
        $loct     = $this->input->post('loc');
        $rackid   = $this->input->post('rack');
        
        //print_r($_POST);
        
        $vndr    = $this->db->query("select * from tbl_product_serial where product_id='$prdct_id' AND loc='$loct' AND rack_id='$rackid'");
        //$getVndr=$vndr->result();
        $count   = $vndr->result_array();
        $v_array = array();
        foreach ($vndr->result() as $getVndr) {
            array_push($v_array, $getVndr->supp_name);
        }
        //print_r($v_array);
        if (sizeof($count) > 0) {
            $cntid = implode(",", $v_array);
        } else {
            $cntid = '999999';
        }
        
        $cnt = $this->db->query("select * from tbl_contact_m where contact_id IN ($cntid) ");
        
        echo "<option value=''>----Select ----</option> ";
        foreach ($cnt->result() as $getCnt) {
            echo "<option value=" . $getCnt->contact_id . ">" . $getCnt->first_name . "</option>";
        }
        
    }
    
    
    public function get_price_list()
    {
        
        $prd_id = $this->input->post('prid');
        $locs   = $this->input->post('loc');
        $racks  = $this->input->post('rack');
        $vndrid = $this->input->post('vid');
        
        $price = $this->db->query("select distinct(purchase_price) from tbl_product_serial where product_id='$prd_id' AND loc='$locs' AND rack_id='$racks' AND supp_name='$vndrid' ");
        
        echo "<option value=''>----Select ----</option> ";
        foreach ($price->result() as $getprice) {
            echo "<option value=" . $getprice->purchase_price . ">" . $getprice->purchase_price . "</option>";
        }
    }
    
    
    public function check_product_type()
    {
        $prdctid       = $this->input->post('pid');
        $product       = $this->db->query("select * from tbl_product_stock where Product_id='$prdctid'");
        $getProductRow = $product->row();
        
        echo $getProductRow->via_type;
    }
    
    
    
    function insert_tools_return()
    {
        
        
        @extract($_POST);
        $table_name = 'tbl_tools_return_hdr';
        
        $rows = $this->input->post('cntVal');
        
        $maker_id    = $this->session->userdata('user_id');
        $author_id   = $this->session->userdata('user_id');
        $comp_id     = $this->session->userdata('comp_id');
        $divn_id     = $this->session->userdata('divn_id');
        $zone_id     = $this->session->userdata('zone_id');
        $brnh_id     = $this->session->userdata('brnh_id');
        $maker_date  = date('Y-m-d');
        $author_date = date('Y-m-d');
        
        $return    = $this->db->query("select * from tbl_tools_return_hdr where issue_id='$issue_id' AND section='$section' AND machine='$machine'");
        $getReturn = $return->row();
        $count     = $return->num_rows();
        
        if ($count > 0) {
            
            for ($i = 0; $i < $rows; $i++) {
                
                if ($return_qty[$i] != '') {
                    
                    $this->db->query("update tbl_tools_return_dtl set qty=qty + $return_qty[$i] where return_id_hdr='$getReturn->return_id' AND spare_id='$product_id[$i]' AND type='$via_type[$i]' AND location='$location_id[$i]' AND rack='$rack_id[$i]' AND vendor='$vendor_id[$i]' AND price='$purchase_price[$i]'");
                    
                    $this->db->query("insert into tbl_tools_return_log set return_id_hdr='$getReturn->return_id',spare_id='$product_id[$i]',type='$via_type[$i]',location='$location_id[$i]',rack='$rack_id[$i]',vendor='$vendor_id[$i]',price='$purchase_price[$i]',qty='$return_qty[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");
                    
                    $this->software_stock_log_insert($getReturn->return_id, 'Tools Return', $vendor_id[$i], $product_id[$i], $return_qty[$i], $purchase_price[$i]);
                    
                    $cost    = $this->db->query("select * from tbl_software_cost_log where log_type='Tools' AND section_id='$section' AND machine_id='$machine' AND product_id='$product_id[$i]' ");
                    $getCost = $cost->row();
                    
                    $actQty   = $getCost->qty - $return_qty[$i];
                    $actSpent = $actQty * $getCost->price;
                    
                    $this->db->query("update tbl_software_cost_log set qty='$actQty',total_spent='$actSpent' where log_type='Tools' AND log_id='$issue_id' AND section_id='$section' AND machine_id='$machine' AND product_id='$product_id[$i]' AND price='$purchase_price[$i]' AND qty='$getCost->qty'");
                    
                    $this->stock_refill_qty_return($product_id[$i], $via_type[$i], $location_id[$i], $rack_id[$i], $vendor_id[$i], $purchase_price[$i], $return_qty[$i]);
                    
                }
                
            }
            
            echo $this->input->post('issue_id');
            
        } else {
            
            $this->db->query("insert into tbl_tools_return_hdr set issue_id='$issue_id',section='$section',machine='$machine',maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");
            
            $lastId = $this->db->insert_id();
            
            for ($i = 0; $i < $rows; $i++) {
                
                if ($return_qty[$i] != '') {
                    
                    $this->db->query("insert into tbl_tools_return_dtl set return_id_hdr='$lastId',spare_id='$product_id[$i]',type='$via_type[$i]',location='$location_id[$i]',rack='$rack_id[$i]',vendor='$vendor_id[$i]',price='$purchase_price[$i]',qty='$return_qty[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");
                    
                    $this->db->query("insert into tbl_tools_return_log set return_id_hdr='$lastId',spare_id='$product_id[$i]',type='$via_type[$i]',location='$location_id[$i]',rack='$rack_id[$i]',vendor='$vendor_id[$i]',price='$purchase_price[$i]',qty='$return_qty[$i]', maker_id='$maker_id',author_id='$author_id',comp_id='$comp_id',divn_id='$divn_id',zone_id='$zone_id', brnh_id='$brnh_id', maker_date='$maker_date', author_date='$author_date'");
                    
                    $this->software_stock_log_insert($lastId, 'Tools Return', $vendor_id[$i], $product_id[$i], $return_qty[$i], $purchase_price[$i]);
                    
                    $cost    = $this->db->query("select * from tbl_software_cost_log where log_type='Tools' AND section_id='$section' AND machine_id='$machine' AND product_id='$product_id[$i]' ");
                    $getCost = $cost->row();
                    
                    $actQty   = $getCost->qty - $return_qty[$i];
                    $actSpent = $actQty * $getCost->price;
                    
                    $this->db->query("update tbl_software_cost_log set qty='$actQty',total_spent='$actSpent' where log_type='Tools' AND log_id='$issue_id' AND section_id='$section' AND machine_id='$machine' AND product_id='$product_id[$i]' AND price='$purchase_price[$i]' AND qty='$getCost->qty'");
                    
                    $this->stock_refill_qty_return($product_id[$i], $via_type[$i], $location_id[$i], $rack_id[$i], $vendor_id[$i], $purchase_price[$i], $return_qty[$i]);
                }
                
            }
            
            echo $this->input->post('issue_id');
            
        }
        
    }
    
    
    
    public function stock_refill_qty_return($main_id, $type, $loc, $rack_id, $vendor_id, $purchase_price, $qty)
    {
        
        $this->db->select('*');
        $array = array(
            'product_id' => $main_id,
            'module_status' => $type,
            'loc' => $loc,
            'rack_id' => $rack_id,
            'supp_name' => $vendor_id,
            'purchase_price' => $purchase_price
        );
        $this->db->where($array);
        $query = $this->db->get('tbl_product_serial');
        //print_r($array);die;
        $num   = $query->num_rows();
        
        if ($num > 0) {
            
            $this->db->query("update tbl_product_serial set quantity =quantity + $qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");
            
            $p_Q = $this->db->query("update tbl_product_stock set quantity=quantity+$qty where Product_id='$main_id' ");
            
            //$this->db->query("update tbl_product_serial_log set quantity =quantity + $qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' and type='opening stock' ");
            
            $sqlProdLoc1 = "insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='tools return',name_role='section tools return',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=NOW(), author_id='" . $this->session->userdata('user_id') . "', maker_id='" . $this->session->userdata('user_id') . "', divn_id='" . $this->session->userdata('divn_id') . "', comp_id='" . $this->session->userdata('comp_id') . "', zone_id='" . $this->session->userdata('zone_id') . "', brnh_id='" . $this->session->userdata('brnh_id') . "' ";
            $this->db->query($sqlProdLoc1);
        }
        
    }
    
    
    function ajex_returnToolsListData()
    {
        $data['id'] = $this->input->post('idval');
        $this->load->view('tools/load-tools-return', $data);
    }
    
    
    function tools_issue_page()
    {
        
        $data['pid'] = $_GET['PID'];
        $this->load->view('tools/getToolsPage', $data);
        
    }
    
    function get_machine_list()
    {
        
        $sec     = $this->input->post('mid');
        $machine = $this->db->query("select * from tbl_machine where m_type='$sec'");
        echo "<option value=''>----Select ----</option> ";
        foreach ($machine->result() as $getMachine) {
            echo "<option value=" . $getMachine->id . ">" . $getMachine->machine_name . "</option>";
        }
        
    }
    
    /*======================================================================*/
    
}
?>