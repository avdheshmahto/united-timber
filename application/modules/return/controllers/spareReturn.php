<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
class spareReturn extends my_controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('model_master');
    }
    
    public function manage_spare_return()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->manageItemJoinfun();
            $this->load->view('manage-spare-return', $data);
        } else {
            redirect('index');
        }
        
    }
    
    public function manageItemJoinfun()
    {
        
        $table_name     = 'tbl_spare_return_hdr';
        $data['result'] = "";
        ////Pagination start ///
        $url            = site_url('/return/spareReturn/manage_spare_return?');
        $sgmnt          = "4";
        
        if ($_GET['entries'] != "")
            $showEntries = $_GET['entries'];
        else
            $showEntries = 10;
        
        
        $totalData = $this->model_master->count_allproduct($table_name, 'A', $this->input->get());
        
        
        if ($_GET['entries'] != "" && $_GET['filter'] == "") {
            $url = site_url('/return/spareReturn/manage_spare_return?entries=' . $_GET['entries']);
        } elseif ($_GET['filter'] != "") {
            $url = site_url('/return/spareReturn/manage_spare_return?entries=' . $_GET['entries'] . '&rflhdrid=' . $_GET['rflhdrid'] . '&return_date=' . $_GET['return_date'] . '&vendor_id=' . $_GET['vendor_id'] . '&po_no=' . $_GET['po_no'] . '&po_date=' . $_GET['po_date'] . '&filter=' . $_GET['filter']);

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
            $data['result'] = $this->model_master->filterListproduct($pagination['per_page'], $pagination['page'], $this->input->get());
        else
            $data['result'] = $this->model_master->product_get($pagination['per_page'], $pagination['page']);
        
        // call permission fnctn
        return $data;
        
    }
    
    
    
    
    
    public function edit_spare_return()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            $this->load->view('edit-spare-return');
        } else {
            redirect('index');
        }
        
    }
    
    
    public function add_spare_return()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            
            $this->load->view('add-spare-return');
        } else {
            redirect('index');
        }
        
    }
    
    public function getproduct()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            //$this->getSelect();
            $this->load->view('getproduct');
        } else {
            redirect('index');
        }
        
    }
    
    
    public function insertSpareReturn()
    {
        @extract($_POST);
        $table_name     = 'tbl_spare_return_hdr';
        $table_name_dtl = 'tbl_spare_return_dtl';
        $pri_col        = 'rflhdrid';
        $pri_col_dtl    = 'refillhdr';
        
        $rows = sizeof($this->input->post('qtyname'));
        
        $sess = array(
            
            'maker_id' => $this->session->userdata('user_id'),
            'maker_date' => date('y-m-d'),
            'author_id' => $this->session->userdata('user_id'),
            'author_date' => date('y-m-d'),
            'status' => 'A',
            'comp_id' => $this->session->userdata('comp_id'),
            'zone_id' => $this->session->userdata('zone_id'),
            'brnh_id' => $this->session->userdata('brnh_id'),
            'divn_id' => $this->session->userdata('divn_id')
        );
        
        $data = array(
            
            'vendor_id' => $this->input->post('vendor_id'),
            'return_date' => $this->input->post('return_date'),
            'po_no' => $this->input->post('po_no'),
            'po_date' => $this->input->post('po_date'),
            'remarks' => $this->input->post('remarks'),
            'stock_status' => "Pending"
            
        );
        
        $data_merge = array_merge($data, $sess);
        $this->Model_admin_login->insert_user($table_name, $data_merge);
        $lastHdrId11 = $this->db->insert_id();
        
        for ($i = 0; $i < $rows; $i++) {
            
            $data_dtl = array(
                
                'refillhdr' => $lastHdrId11,
                'product_id' => $spareids[$i],
                'type' => $via_types[$i],
                'loc' => $locs[$i],
                'rack_id' => $racks[$i],
                'purchase_price' => $prices[$i],
                'quantity' => $qtyname[$i],
                
                'maker_id' => $this->session->userdata('user_id'),
                'maker_date' => date('y-m-d'),
                'author_id' => $this->session->userdata('user_id'),
                'author_date' => date('y-m-d'),
                'comp_id' => $this->session->userdata('comp_id'),
                'zone_id' => $this->session->userdata('zone_id'),
                'brnh_id' => $this->session->userdata('brnh_id'),
                'divn_id' => $this->session->userdata('divn_id')
                
            );
            //print_r($data_dtl);die;
             $this->software_log_insert($lastHdrId11, 'Return');

            $this->software_stock_log_insert($lastHdrId11, 'Return', $vendor_id, $spareids[$i], $qtyname[$i], $prices[$i]);
            
            $this->stock_refill_qty($qtyname[$i], $spareids[$i], $locs[$i], $racks[$i], $vendor_id, $via_types[$i], $prices[$i]);
            
            $this->Model_admin_login->insert_user($table_name_dtl, $data_dtl);
            
        }
        
        redirect('/return/spareReturn/manage_spare_return');
    }
    
    
    
    public function stock_refill_qty($qty, $main_id, $loc, $rack_id, $vendor_id, $type, $purchase_price)
    {
        
        $this->db->select('*');
        $array = array(
            'module_status' => $type,
            'loc' => $loc,
            'rack_id' => $rack_id,
            'product_id' => $main_id,
            'supp_name' => $vendor_id,
            'purchase_price' => $purchase_price
        );
        $this->db->where($array);
        $query = $this->db->get('tbl_product_serial');
        //print_r($array);die;
        $num   = $query->num_rows();
        
        if ($num > 0) {
            
            $this->db->query("update tbl_product_serial set quantity =quantity-$qty where product_id='$main_id' and loc='$loc' and rack_id='$rack_id' and supp_name='$vendor_id' and purchase_price='$purchase_price' ");
            $p_Q = $this->db->query("update tbl_product_stock set quantity =quantity-$qty where Product_id='$main_id' ");
            
            $sqlProdLoc1 = "insert into tbl_product_serial_log set quantity ='$qty',product_id='$main_id',loc='$loc',rack_id='$rack_id',type='stock return',name_role='bincard stock return',module_status='$type',supp_name='$vendor_id',purchase_price='$purchase_price', maker_date=NOW(), author_date=NOW(), author_id='" . $this->session->userdata('user_id') . "', maker_id='" . $this->session->userdata('user_id') . "', divn_id='" . $this->session->userdata('divn_id') . "', comp_id='" . $this->session->userdata('comp_id') . "', zone_id='" . $this->session->userdata('zone_id') . "', brnh_id='" . $this->session->userdata('brnh_id') . "' ";
            $this->db->query($sqlProdLoc1);
        }
        
        
    }
    
    
    
    public function updateSpareReturn()
    {
        
        extract($_POST);
        $table_name     = 'tbl_spare_return_hdr';
        $table_name_dtl = 'tbl_spare_return_dtl';
        $pri_col        = 'rflhdrid';
        $pri_col_dtl    = 'refillhdr';
        //$rows = $this->input->post('rows');
        //echo $id = $this->input->post('id');die;
        
        $this->db->query("delete from tbl_spare_return_dtl where refillhdr='$id'");
        
        $sess = array(
            
            'maker_id' => $this->session->userdata('user_id'),
            'maker_date' => date('y-m-d'),
            'status' => 'A',
            'comp_id' => $this->session->userdata('comp_id'),
            'zone_id' => $this->session->userdata('zone_id'),
            'brnh_id' => $this->session->userdata('brnh_id'),
            'divn_id' => $this->session->userdata('divn_id')
        );
        
        $data = array(
            
            'remarks' => $this->input->post('remarks'),
            'vendor_id' => $this->input->post('vendor_id'),
            'return_date' => $this->input->post('return_date'),
            'po_no' => $this->input->post('po_no'),
            'po_date' => $this->input->post('po_date'),
            'stock_status' => "Pending"
            
        );
        
        $data_merge = array_merge($data, $sess);
        
        $this->load->model('Model_admin_login');
        $this->Model_admin_login->update_user($pri_col, $table_name, $id, $data_merge);
        
        
        for ($i = 0; $i <= $rows; $i++) {
            
            if ($new_quantity[$i] != '') {
                
                $data_dtl = array(
                    'refillhdr' => $id,
                    'main_loc' => $main_loc[$i],
                    'loc' => $loc[$i],
                    'rack_id' => $rack_id[$i],
                    'product_id' => $product_id[$i],
                    //$data_dtl['list_price']=$this->input->post('list_price')[$i];
                    'quantity' => $new_quantity[$i],
                    'maker_id' => $this->session->userdata('user_id'),
                    'maker_date' => date('y-m-d'),
                    'comp_id' => $this->session->userdata('comp_id'),
                    'zone_id' => $this->session->userdata('zone_id'),
                    'brnh_id' => $this->session->userdata('brnh_id')
                );
                
                
                $this->Model_admin_login->insert_user($table_name_dtl, $data_dtl);
                
            }
        }
        
        
        echo "<script type='text/javascript'>";
        echo "window.close();";
        echo "window.opener.location.reload();";
        echo "</script>";
        
    }
    
    
    public function get_rack()
    {
        
        if ($this->session->userdata('is_logged_in')) {
            
            $data = array(
                'loc' => $_GET['loc'],
                'rack_id' => $_GET['rack_id'],
                'main_loc' => $_GET['main_loc']
            );
            //$data['$loc']=$_GET["proPall"];
            $this->load->view('get-rack', $data);
            
        } else {
            redirect('index');
        }
        
    }
    
    
    public function get_price()
    {
        if ($this->session->userdata('is_logged_in')) {
            
            
            $data = array(
                'loc' => $_GET['loc'],
                'rack_id' => $_GET['rack_id'],
                'main_id' => $_GET['main_id'],
                'vendor_id' => $_GET['vendor_id']
            );
            
            //echo "hello".$data;
            //print_r($data);die;
            $this->load->view('get-price', $data);
            
        } else {
            redirect('index');
        }
    }
    
    
    public function getPalletQty()
    {
        
        $qtySerial = $this->db->query("select *from tbl_product_serial where loc='" . $_GET['loc'] . "' and product_id='" . $_GET['pri_id'] . "'");
        $getData1  = $qtySerial->row();
        $numCnt    = $qtySerial->num_rows();
        
        if ($numCnt > 0) {
            foreach ($qtySerial->result() as $getData) {
                
                $queryLocation = $this->db->query("select *from tbl_location_rack where id='$getData->rack_id'");
                $getLocation   = $queryLocation->row();
                $numCnt        = $queryLocation->num_rows();
                
                $sum = $getData->quantity;
                $abc = $abc + $sum;

                echo "Rack Name Is:-" . $getLocation->rack_name . " and Qty is:-" . $sum . "<br>";
                
            }
            echo "Total Quantity Is :-" . $abc;
        } else {
            echo "No Record found";
        }
    }
    
    
    public function ajex_rackData()
    {
        
        $locId  = $this->input->post('id');
        $rackId = $this->input->post('rackId');
        
        $cateQuery = $this->db->query("select * from tbl_location_rack where location_rack_id='$locId'");
        foreach ($cateQuery->result() as $getTypeQuery) {
			?>
			   <option value="<?php
			            echo $getTypeQuery->id;
			?>" <?php
			            if ($rackId == $getTypeQuery->id) {
			                echo 'selected';
			            }
			?>>   <?php
			            echo $getTypeQuery->rack_name;
			?></option>
			     <?php
        }
        
    }
    
    public function check_rack_qty()
    {
        
        $pid   = $this->input->post('pid');
        $loc   = $this->input->post('loc');
        $rack  = $this->input->post('rack');
        $etqty = $this->input->post('eqty');
        
        $PrdQty = $this->db->query("select * from tbl_product_serial where product_id='$pid' AND loc='$loc' AND rack_id='$rack'");
        $count  = $PrdQty->num_rows();
        $getQty = $PrdQty->row();
        
        if ($etqty > $getQty->quantity)
            echo "0";
        else
            echo "1";
        
    }
    
    
    function spare_dropdown()
    {
        $vndrid = $this->input->get('vid');
        
        $price = $this->db->query("select * from tbl_product_serial_log where supp_name='$vndrid' GROUP BY product_id");
        
        echo "<option value=''>----Select ----</option> ";
        foreach ($price->result() as $getprice) {
            $prd    = $this->db->query("select * from tbl_product_stock where Product_id='$getprice->product_id'");
            $getPrd = $prd->row();
            echo "<option value=" . $getPrd->Product_id . ">" . $getPrd->productname . "</option>";
        }
    }
    
    function spare_return_page()
    {
        $data['pid'] = $_GET['PID'];
        $this->load->view('getReturnPage', $data);
    }
    
    
    
    
}
?>