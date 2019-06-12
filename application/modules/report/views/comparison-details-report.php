                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
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
    <?php  $sect=$this->db->query("select * from tbl_category where id='".$_GET['id']."'");
            $getSect=$sect->row(); ?>
<h4 class="panel-title">COMPARISON DETAILS (<?php echo $getSect->name;?>)</h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>

<div class="panel-body panel-center">
<form class="form-horizontal" method="get" action="">
<div class="form-group panel-body-to"> 
<label class="col-sm-2 control-label">Section</label> 
<div class="col-sm-3">
<input type="hidden" name="id" id='id' value="<?php echo $_GET['id'];?>"> 
<select name="m_type" class="select2 form-control" id="m_type" style="width:100%;" onchange="getmachinelist(this.value);" required="" disabled="">
<option value="0" class="listClass">------Section-----</option>
<?php
$sql=$this->db->query("select * from tbl_category where inside_cat='0'");
foreach($sql->result() as $getSql) { 
//foreach ($categorySelectbox as $key => $dt) { ?>
<!-- <option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option> -->
<option value="<?=$getSql->id?>" <?php if($getSql->id==$_GET['id']) { ?> selected <?php } ?> ><?=$getSql->name?></option>
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

<tr>
    <th>
        <?php  
        $sec=$this->db->query("select * from tbl_category where id='".$_GET['id']."'");
        $getSec=$sec->row(); ?>

        <a target="_blank" href="<?=base_url('report/Report/section_details?id=')?><?=$_GET['id']?>"><?php echo $getSec->name; ?> 
    </th>
    
    <th>
        <?php 
        $april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=04 AND section_id='$getSec->id' AND machine_id='' "); 
        $getAprilSum=$april->row(); 
        echo (round($getAprilSum->totalamt,2));  
        ?>
    </th>
   
    <th>
        <?php
        $may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=05 AND section_id='$getSec->id' AND machine_id=''");        
        $getMaySum=$may->row();
        echo (round($getMaySum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=06 AND section_id='$getSec->id' AND machine_id=''"); 
        $getJuneSum=$june->row();
        echo (round($getJuneSum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=07 AND section_id='$getSec->id' AND machine_id=''"); 
        $getJulySum=$july->row();
        echo (round($getJulySum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=08 AND section_id='$getSec->id' AND machine_id=''"); 
        $getAugustSum=$august->row();
        echo (round($getAugustSum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=09 AND section_id='$getSec->id' AND machine_id=''"); 
        $getSeptemberSum=$september->row();
        echo (round($getSeptemberSum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=10 AND section_id='$getSec->id' AND machine_id=''"); 
        $getOctoberSum=$october->row();
        echo (round($getOctoberSum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=11 AND section_id='$getSec->id' AND machine_id=''"); 
        $getNovemberSum=$novermber->row();
        echo (round($getNovemberSum->totalamt,2));
        ?>
    </th>
    <th>
        <?php 
        $december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=12 AND section_id='$getSec->id' AND machine_id=''"); 
        $getDecemberSum=$december->row();
        echo (round($getDecemberSum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=01 AND section_id='$getSec->id' AND machine_id=''"); 
        $getJanuarySum=$january->row();
        echo (round($getJanuarySum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=02 AND section_id='$getSec->id' AND machine_id=''"); 
        $getFebruarySum=$february->row();
        echo (round($getFebruarySum->totalamt,2));
        ?>
    </th>
    <th>
        <?php
        $march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=03 AND section_id='$getSec->id' AND machine_id=''"); 
        $getMarchSum=$march->row();
        echo (round($getMarchSum->totalamt,2));
        ?>
    </th>

</tr>

<?php

if($_GET['filter'] == 'filter')
{
    $query=("select * from tbl_machine where m_type='".$_GET['id']."' AND id='".$_GET['machineid']."' ");    
}
else
{
    $query=("select * from tbl_machine where m_type='".$_GET['id']."'");
}

$result=$this->db->query($query)->result();
foreach($result as $fetch) { ?>
<tr class="gradeC record">

    <th style="text-align:center;"><a target="_blank" href="<?=base_url('report/Report/section_details?id=')?><?=$fetch->id?>"> <?php  echo $fetch->machine_name; ?> </a></th>
    
    <th>
        <?php 
        $april=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=04 AND machine_id='$fetch->id' "); 
        $getAprilData=$april->row(); 
        echo (round($getAprilData->totalamt,2));  
        ?>
    </th>
   
    <th>
        <?php
        $may=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=05 AND machine_id='$fetch->id' "); 
        $getMayData=$may->row();
        echo (round($getMayData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $june=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=06 AND machine_id='$fetch->id' "); 
        $getJuneData=$june->row();
        echo (round($getJuneData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $july=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=07 AND machine_id='$fetch->id' "); 
        $getJulyData=$july->row();
        echo (round($getJulyData->totalamt,2));
        ?>    
    </th>

    <th>
        <?php
        $august=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=08 AND machine_id='$fetch->id' "); 
        $getAugustData=$august->row();
        echo (round($getAugustData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $september=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=09 AND machine_id='$fetch->id' "); 
        $getSeptemberData=$september->row();
        echo (round($getSeptemberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $october=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=10 AND machine_id='$fetch->id' "); 
        $getOctoberData=$october->row();
        echo (round($getOctoberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $novermber=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=11 AND machine_id='$fetch->id' "); 
        $getNovemberData=$novermber->row();
        echo (round($getNovemberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php 
        $december=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=12 AND machine_id='$fetch->id' "); 
        $getDecemberData=$december->row();
        echo (round($getDecemberData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $january=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=01 AND machine_id='$fetch->id' "); 
        $getJanuaryData=$january->row();
        echo (round($getJanuaryData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $february=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=02 AND machine_id='$fetch->id' "); 
        $getFebruaryData=$february->row();
        echo (round($getFebruaryData->totalamt,2));
        ?>
    </th>

    <th>
        <?php
        $march=$this->db->query("select SUM(total_spent) as totalamt from tbl_software_cost_log where EXTRACT(MONTH FROM log_date)=03 AND machine_id='$fetch->id' "); 
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
    <th><?php echo (round($totalcost_april + $getAprilSum->totalamt,2)); ?> </th>
    <th><?php echo (round($totalcost_may + $getMaySum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_june + $getJuneSum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_july + $getJulySum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_august + $getAugustSum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_september + $getSeptemberSum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_october + $getOctoberSum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_november + $getNovemberSum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_december + $getDecemberSum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_january + $getJanuarySum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_february + $getFebruarySum->totalamt,2)); ?></th>
    <th><?php echo (round($totalcost_march + $getMarchSum->totalamt,2)); ?></th>

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
  location.href="<?=base_url('/report/Report/comparison_details_report?id=');?><?=$_GET['id']?>";
}

</script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/form-advanced-script.js"></script>

<script type="text/javascript">

window.onload = function() {
    getmachinelist(<?=$_GET['id']?>);
};

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