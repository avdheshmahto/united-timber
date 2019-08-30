<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">
<title>Tech Vyas Software</title>
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='<?=base_url();?>assets/images/favicon.ico' />
<!-- /site favicon -->

<script src="<?=base_url();?>assets/newjs/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url();?>assets/dropdown-customer/semantic.js"></script>
<link rel="stylesheet" href="<?=base_url();?>assets/js/fullcalendar/fullcalendar.css">
<script src="<?=base_url();?>assets/js/fullcalendar/fullcalendar.min.js"></script>
<script src="<?=base_url();?>assets/js/daterangepicker/moment.min.js"></script>
<link type="text/css" href="<?=base_url();?>assets/dropdown-customer/semantic.css" rel="stylesheet" />

<script>
$(document).ready(function(){
   $('.search').on('keyup',function(){
       var searchTerm = $(this).val().toLowerCase();
       $('#userTbl tbody tr').each(function(){
           var lineStr = $(this).text().toLowerCase();
           if(lineStr.indexOf(searchTerm) === -1){
               $(this).hide();
           }else{
               $(this).show();
           }
       });
   });
});
</script>
<!-- Entypo font stylesheet -->
<link href="<?=base_url();?>assets/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="<?=base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->
<!------------------------report menu-------------------------->

<link href="<?php echo base_url();?>assets/report/report.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>assets/report-js/jquery.min.js" type="text/javascript"></script>

<!------------------------report menu close-------------------------->
<!-- Integral core stylesheet -->
<link href="<?=base_url();?>assets/css/integral-core.css" rel="stylesheet">
<!-- /integral core stylesheet -->

<!--Jvector Map-->
<link href="<?=base_url();?>assets/plugins/jvectormap/css/jquery-jvectormap-2.0.3.css" rel="stylesheet">
<link href="<?=base_url();?>assets/css/integral-forms.css" rel="stylesheet">
<link href="<?=base_url();?>assets/css/invoice.css" rel="stylesheet">

<style>
.side-to{position:fixed; background-color:#fff;}
#pagination_controls{margin:20px 0 0 0px;}
</style>


<style type="text/css">
.listpro :focus {
  background: #e0dddd;
  cursor: pointer;
}
</style>

</head>
<?php $this->load->view("javascriptPage.php");?>
<body <?php if($_GET['view']!=''){?> oncontextmenu='return false;' onkeydown='return false;' onmousedown='return false;' <?php }?>>

<div class="loader-backdrop">          
<div class="loader">
<div class="bounce-1"></div>
</div>
</div>
	
<!-- Page container -->
<div class="page-container">
<?php if($_GET['popup']=='True'){} else {?>

<!-- Page Sidebar -->
<?php 
//require_once(APPPATH.'views/side.php');
$this->load->view("side.php");?>
<!-- /page sidebar -->
  
<!-- Main container -->
<div class="main-container">
<!-- Main header -->
<?php }?>
<!-- /main header -->



