<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">
<title>Tech Vyas Software</title>
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='<?=base_url();?>assets/images/favicon.ico' /><!-- /site favicon -->
<link rel="stylesheet" href="<?=base_url();?>assets/js/fullcalendar/fullcalendar.css">
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


<link type="text/css" href="<?=base_url();?>assets/dropdown-customer/semantic.css" rel="stylesheet" />

<link href="<?=base_url();?>assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.datetimepicker.css"/>

<link href="<?=base_url();?>assets/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="<?=base_url();?>assets/plugins/select2/css/select2.css" rel="stylesheet">