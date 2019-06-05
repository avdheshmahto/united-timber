
<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
  $entries = $this->input->get('entries');
}

?>
<div class="main-content">
<?php
$this->load->view("reportheader");
?>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">COMPARISON REPORT (APRIL 2019 - MARCH 2020)</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Section</label> 
<div class="col-sm-3"> 
<select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);" required="">
<option value="0" class="listClass">------Section-----</option>
<?php
$sql=$this->db->query("select * from tbl_category where inside_cat='0'");
foreach($sql->result() as $getSql) { 
//foreach ($categorySelectbox as $key => $dt) { ?>
<!-- <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option> -->
<option value="<?=$getSql->id?>"><?=$getSql->name?></option>
<?php } ?>
</select>
</div>  

<label class="col-sm-2 control-label">Machine</label> 
<div class="col-sm-3"> 
<select name="machineid" id="machineid" class="select2 form-control">
<option value="">----Machine----</option>
<?php 
// $qry="select * from tbl_machine where status='A'";
// $qryres=$this->db->query($qry)->result();
// foreach($qryres as $res) { 
// $fac=$this->db->query("select * from tbl_category where id='$res->m_type'");
// $getFac=$fac->row(); ?>
<!-- <option value="<?=$res->id?>" <?php if($_GET['machine'] == $res->id) {?>selected <?php } ?>><?php echo $res->machine_name."(". $getFac->name.")"?></option>  -->
<?php //} ?>
</select> 
</div>
<div class="form-group panel-body-to" style="padding: 8px 14px 0px 0px"> 
<button class="btn btn-sm btn-default pull-right" type="reset" onclick="ResetLead();" style="margin: 0px 0px 0px 25px;">Reset</button>  
<button type="submit" class="btn btn-sm pull-right" name="filter" value="filter" ><span>Search</span>
</div>
</div> 
</form>
</div>
                                                                                            
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>

	<th>Particulars</th>
	<th>April</th>
	<th>May</th>
    <th>June</th>
    <th>July</th>
    <th>August</th>
    <th>September</th>
    <th>October</th>
	<th>November</th>
	<th>December</th>
    <th>January</th>
    <th>February</th>
    <th>March</th>
		
</tr>
</thead>
<tbody id="getDataTable" >
<?php

$query=("select * from tbl_software_cost_log  GROUP BY main_section ");
$result=$this->db->query($query)->result();
//echo date('m');
foreach($result as $fetch) { ?>

<tr class="gradeC record">
    
    <th>
        <?php $sec=$this->db->query("select * from tbl_category where id='$fetch->main_section'");
        $getSec=$sec->row(); ?>
        <a target="_blank" href="<?=base_url('report/Report/comparison_details_report?id=')?><?=$fetch->main_section?>"> <?php echo $getSec->name;?> </a>
    </th>
    
    <th>
        <?php $april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=04 AND main_section='$fetch->main_section' "); 
        $getAprilData=$april->row();
        echo (round($getAprilData->totalamt,2)); 
        ?>
    </th>
    
    <th>
        <?php
        $may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=05 AND main_section='$fetch->main_section' "); 
        $getMayData=$may->row();
        echo (round($getMayData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=06 AND main_section='$fetch->main_section'");    
        $getJuneData=$june->row();
        echo (round($getJuneData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=07 AND main_section='$fetch->main_section' "); 
        $getJulyData=$july->row();
        echo (round($getJulyData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=08 AND main_section='$fetch->main_section' "); 
        $getAugustData=$august->row();
        echo (round($getAugustData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=09 AND main_section='$fetch->main_section' "); 
        $getSeptemberData=$september->row();
        echo (round($getSeptemberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=10 AND main_section='$fetch->main_section' "); 
        $getOctoberData=$october->row();
        echo (round($getOctoberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=11 AND main_section='$fetch->main_section' "); 
        $getNovemberData=$novermber->row();
        echo (round($getNovemberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=12 AND main_section='$fetch->main_section' "); 
        $getDecemberData=$december->row();
        echo (round($getDecemberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=01 AND main_section='$fetch->main_section'");    
        $getJanuaryData=$january->row();
        echo (round($getJanuaryData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=02 AND main_section='$fetch->main_section' ");   
        $getFebruaryData=$february->row();
        echo (round($getFebruaryData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=03 AND main_section='$fetch->main_section' "); 
        $getMarchData=$march->row();
        echo (round($getMarchData->totalamt,2));
        ?>
    </th>

</tr>
<?php 

$totalcost_april     =$totalcost_april + $getAprilData->totalamt;
$totalcost_may       =$totalcost_may + $getMayData->totalamt;
$totalcost_june      =$totalcost_june + $getJuneData->totalamt;
$totalcost_july      =$totalcost_july + $getJulyData->totalamt;
$totalcost_august    =$totalcost_august + $getAugustData->totalamt;
$totalcost_september =$totalcost_september + $getSeptemberData->totalamt;
$totalcost_october   =$totalcost_october + $getOctoberData->totalamt;
$totalcost_november  =$totalcost_november + $getNovemberData->totalamt;
$totalcost_december  =$totalcost_december + $getDecemberData->totalamt;
$totalcost_january   =$totalcost_january + $getJanuaryData->totalamt;
$totalcost_february  =$totalcost_february + $getFebruaryData->totalamt;
$totalcost_march     =$totalcost_march + $getMarchData->totalamt;


 }  ?>

<tr class="gradeC record">

    <th>Totals</th>
    <th><?php echo (round($totalcost_april,2)); ?> </th>
    <th><?php echo (round($totalcost_may,2)); ?></th>
    <th><?php echo (round($totalcost_june,2)); ?></th>
    <th><?php echo (round($totalcost_july,2)); ?></th>
    <th><?php echo (round($totalcost_august,2)); ?></th>
    <th><?php echo (round($totalcost_september,2)); ?></th>
    <th><?php echo (round($totalcost_october,2)); ?></th>
    <th><?php echo (round($totalcost_november,2)); ?></th>
    <th><?php echo (round($totalcost_december,2)); ?></th>
    <th><?php echo (round($totalcost_january,2)); ?></th>
    <th><?php echo (round($totalcost_february,2)); ?></th>
    <th><?php echo (round($totalcost_march,2)); ?></th>

</tr>

</tbody>
</table>
</div>
<div class="row">
	<div class="col-md-12 text-right">
		<div class="col-md-6 text-left"> 
		</div>
		<div class="col-md-6"> 
			<?php echo $pagination; ?>
		</div>

</div>
</div>
</div>
</div>
	
<?php
$this->load->view("footer.php");
?>	
</div>





<script>
function exportTableToExcel(tableID, filename = ''){

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Product Bin Card Report<?php echo date('d-m-Y');?>.xls';
   
   // Create download link element
   downloadLink = document.createElement("a");
   
   document.body.appendChild(downloadLink);
   
   if(navigator.msSaveOrOpenBlob){
       var blob = new Blob(['\ufeff', tableHTML], {
           type: dataType
       });
       navigator.msSaveOrOpenBlob( blob, filename);
   }else{

       // Create a link to the file
       downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
   
       // Setting the file name
       downloadLink.download = filename;
       
       //triggering the function
       downloadLink.click();
   }
}



function ResetLead()
{
  location.href="<?=base_url('/report/Report/comparison_report');?>";
}

</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>


<script type="text/javascript">
function getmachinelist(v)
{

  ur="<?=base_url();?>report/Report/get_machine_list";
  //alert(v);
  $.ajax({

      url   : ur,
      type  : "POST",
      data  : {'mid':v},
      success:function(data)
      {

        //alert(data);
        if(data != '')
        {
          $("#machineid").empty().append(data);
        }
      }
  })

}
</script>