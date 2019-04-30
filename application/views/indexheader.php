<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Software</title>
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' />
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="<?php echo base_url();?>assets/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Integral core stylesheet -->
<link href="<?php echo base_url();?>assets/css/integral-core.css" rel="stylesheet">
<!-- /integral core stylesheet -->

<link href="<?php echo base_url();?>assets/css/integral-forms.css" rel="stylesheet">

<link href="<?php echo base_url();?>assets/css/login.css" rel="stylesheet">


<style>
body, html {
    height: 100%;
    margin: 0;
}

.main-head{
    height: 150px;
    background: #FFF;
}

.sidenav {
    height: 100%;
    overflow-x: hidden;
    padding-top: 20px;
	/*background-image: url(http://jthemes.org/html/harmony-event/assets/images/special-offer-bg.png);*/
	background-color:#1F2633;
    color: #fff;
	padding: 30px 0px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
}

.login a{color:#fff; text-decoration:none; font-size:14px; }
.login a:hover{color:#FEFF00; text-decoration:underline;}


.main {
    padding: 0px 10px;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
}

@media screen and (min-width: 768px){
    .main{
        margin-left:37%; 
    }

    .sidenav{
        width:36%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
    }
}




</style>


</head>
<body>

<!-- Loader Backdrop -->
	<div class="loader-backdrop">           
	  <!-- Loader -->
		<div class="loader">
			<div class="bounce-1"></div>
			<div class="bounce-2"></div>
		</div>
	  <!-- /loader -->
	</div>
<!-- loader backgrop -->

<div class="sidenav">
<div class="container w-420 p-15 mt-100 text-center">
<h3 class="text-light text-white"><img src="<?=base_url();?>assets/images/logo_login.png" alt=""></h3>
<div class="login">
<form class="form-validation mt-20" method="post" action="master/Item/dashboard" id="tbl">
<font color="#FF0000" style="display:marker"><b><?php echo $this->session->flashdata('error1');?></b> </font>
		<font color="#FF0000" style="display:marker"><b><?php echo $this->session->flashdata('error');?></b> </font> 
<div class="form-group">
<input type="text" name="username" class="form-control underline-input_" placeholder="Username" required>
</div>
<div class="form-group">
<input type="password" name="password" placeholder="Password" class="form-control underline-input_" required>
</div>

<div class="form-group">
<input type="submit" id="login" class="btn btn-lg  login-button"  value="Login">
</div>

<div class="form-group">
<div class="checkbox_">
<a onclick="show();" class="#">Forgot Password?</a>
</div>
</div>
</form>

<form method="post" class="form-validation mt-20" action="master/Item/forgotPassword" id="tbl1" style="display:none"> 
		                    
	<h2>Forget Password</h2>
	<div class="form-group">
		<input type="email" name="email_id" placeholder="Email Id" class="form-control" required>
	</div>                        
	
	<div class="form-group">
	<input type="submit" class="btn btn-lg  login-button" value="Submit">
	</div>

	<div class="form-group">
	<div class="checkbox_">
	<p class="text-center"><a href="index">Login</a></p>      
	</div>  

	</div>                     
</form>

<hr>
</div>
</div>
</div><!--sidenav close-->

<div class="main">
<div class="col-md-12 col-sm-12 text-center">
<h1>Dashboards</h1>
<h3>See your business. Chart your course.</h3>
<p><img src="<?=base_url();?>assets/images/dashboard.png" alt="" class="img-responsive"></p>
</div>
</div><!--main close-->


