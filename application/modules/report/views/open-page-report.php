<style>
.booking-padding{padding: 0px;}
.booking-step {
    /*margin-top: 35px;
    margin-bottom: 10px;*/
	padding:20px;
}

.step-item {
    color: #636363;
    display: block;
    text-align: center;
    text-transform: uppercase;
    font-size: 13px;
    margin:0 0 30px 0px;

}

.step-item .line {
    width: 100%;
    height: 1px;
    background: #D1D1D1;
}

.step-item .step-item {
    margin-top: -26px;
    margin-bottom: 5px;
	height:90px;
}

.step-item .number {
    width: 40px;
    height: 40px;
    background: #EDEDED;
    margin: 5px auto 0;
    padding: 5px;
    border-radius: 50%;
}

.step-item .number .inner {
    background: #D1D1D1;
    height: 100%;
    color: #FFF;
    font-size: 16px;
    font-weight: 400;
    line-height: 30px;
    border-radius: 50%;
}

.step-item.active a:hover {
    cursor: pointer;
    opacity: 0.4;
    text-decoration: none;
}

.step-item.active .line {
    background: #424C70;
}

.step-item.active .number .inner {
    background: #424C70;
}

</style>


<?php
$this->load->view("header.php");
?>
<!-- Main content -->
<div class="main-content">
	
<?php
$this->load->view("reportheader");
?>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading clearfix">
<h4 class="panel-title">REPORT </h4>
<ul class="panel-tool-options"> 
<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
</ul>
</div>
<div class="panel-body">
<div class="booking-step">
<div class="row gap-0">

<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/section_report">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">1</div>
</div>
<p>Section Report</p>
</div>
</a> </div>
</div>
<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/comparison_report"> 
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">2</div>
</div>
<p>Comparison Report</p>
</div>
</a> 
</div>
</div>

<div class="col-xs-12 col-sm-2" style="padding:0px;"> 
<div class="step-item active"><a href="<?=base_url();?>report/Report/searchStock">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">3</div>
</div>
<p>Current Stock Report</p>
</div>
</a> </div>
</div>
<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/searchReorderLevel">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">4</div>
</div>
<p>Required Stock Report</p>
</div>
</a> </div>
</div>
<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/searchBincard"> 
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">5</div>
</div>
<p>Stock Receive Report</p>
</div>
</a> </div>
</div>
<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/spare_return">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">6</div>
</div>
<p>Stock Return Report</p>
</div>
</a> </div>
</div>

<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/breakdown_report">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">7</div>
</div>
<p>Breakdown Wororder Report</p>
</div>
</a> </div>
</div>


<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/scheduled_report">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">8</div>
</div>
<p>Scheduled Workorder Report</p>
</div>
</a> </div>
</div>

<!-- <div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/spare_machine_mapping_report/">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">10</div>
</div>
<p>Machine Spare Mapping Report</p>
</div>
</a> </div>
</div> -->
<!---<div class="col-xs-12 col-sm-2"  style="padding:0px;">
<div class="step-item active"><a href="<?=base_url();?>report/Report/searchWhereQty/">
<div class="line"></div>
<div class="step-item">
<div class="number">
<div class="inner">8</div>
</div>
<p>Stock in Stage Report</p>
</div>
</a> -->
</div>
</div>









</div>
</div><!--container booking-step close-->
</div>
</div>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<?php
$this->load->view("footer.php");
?>

