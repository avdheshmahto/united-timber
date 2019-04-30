<div class="main-header row">
<div class="col-sm-4 col-xs-4">
</div>

<div class="col-sm-4 col-xs-4">
<!-- <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="icon-cancel"></i></span></button>
<strong>Well done! &nbsp; uihuihuhyu</strong> 
</div> -->
</div>


<div class="col-sm-4 col-xs-4">
<div class="pull-right">
<ul class="user-info pull-left">
<!-- Notifications -->
<li class="notifications dropdown" style="display:none">
<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-attention"></i><span class="badge badge-info">6</span></a>
<ul class="dropdown-menu pull-right">
<li class="first">
<div class="small"><a class="pull-right" href="#">Mark all Read</a> You have <strong>3</strong> new notifications.</div>
</li>
<li>
<ul class="dropdown-list">
<li class="unread notification-success"><a href="#"><i class="icon-user-add pull-right"></i><span class="block-line strong">New user registered</span><span class="block-line small">30 seconds ago</span></a></li>
<li class="unread notification-secondary"><a href="#"><i class="icon-heart pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
<li class="unread notification-primary"><a href="#"><i class="icon-user pull-right"></i><span class="block-line strong">Privacy settings have been changed</span><span class="block-line small">2 hours ago</span></a></li>
<li class="notification-danger"><a href="#"><i class="icon-cancel-circled pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
<li class="notification-info"><a href="#"><i class="icon-info pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
<li class="notification-warning"><a href="#"><i class="icon-rss pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
</ul>
</li>
<li class="external-last"> <a href="#">View all notifications</a> </li>
</ul>
</li>
<!-- /notifications -->

<!-- Messages -->
<li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"> 
<img width="22" class="img-circle___ avatar" alt="" src="<?=base_url();?>assets/images/man-3.png">
 <?php 
            $user=$this->db->query("select * from tbl_user_mst where user_id='".$this->session->userdata('user_id')."' ");
            $getUser=$user->row();
          ?>
        <?=$getUser->user_name;?>
 <span class="caret"></span></a>

<!-- User action menu -->
<ul class="dropdown-menu">
<li style="display:none"><a href="<?php echo base_url();?>master/Item/profile"><i class="icon-user" ></i>My profile</a></li>
<li><a href="<?php echo base_url();?>master/changePassword/changepwd"><i class="icon-cog"></i>Change Password</a></li>
<li><a href="<?php echo base_url();?>master/Item/logout"><i class="icon-logout"></i>Logout</a></li>
</ul>
<!-- /user action menu -->

</li>
<!-- /messages -->

</ul><!-- /user alerts -->
</div><!--pull-right close-->
</div>
</div>

<div class="page-sidebar">
<div class="side-to">
<!-- Site header  -->
<header class="site-header">
<div class="site-logo"><a href="<?php echo base_url(); ?>master/Item/dashboar"><img src="<?=base_url();?>assets/images/logo.png" alt="ERP" title="ERP" style="margin-top:10px"></a></div>
<div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu" style="margin: 10px -15px 5px 15px;"></i></a></div>
<div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu" style="margin: 10px -15px 5px 15px;"></i></a></div>
</header>
<!-- /site header -->


<!-- Main navigation -->
<ul id="side-nav" class="main-menu navbar-collapse collapse">
<!--<li class="active"><a href="<?php echo base_url();?>master/Item/dashboar"><i class="icon-gauge"></i><span class="title">Dashboard</span></a></li>
-->
<?php
@session_start();
@$main=$_session['main'];
@$submain=$_session['submain'];
@$sub=$_session['sub'];
@$page0=$_SERVER['REQUEST_URI'];
@$page=explode('/',$page0);
@$page1=@$page[2]."/".@$page[3]."/".@$page[4];
@$page2=@$page[2]."/".@$page[3];
$query = $this->db->query("SELECT * FROM tbl_module_function where status='A' and function_url='$page1' or  function_url='$page2' ");
$row = $query->row();
@$MN=$row->module_name;
@$UR=$row->func_id;
@$GP=$row->function_group;
$role = $this->session->userdata('role');


$mod_sql = $this->db->query("select module_id,module_name,module_url from tbl_module_mst where status='A' order by Order_id");
$countsss=1;
foreach ($mod_sql->result() as $mod_fetch){
$module_sqldata = $this->db->query("select COUNT(function_url) as ct from tbl_role_func_action where role_id='".$role."' and module_id='".$mod_fetch->module_id."' and action_id !='Inactive'");
$module_fetchdata = $module_sqldata->row();
$module_fetchdata->ct;
if($module_fetchdata->ct >0) {
echo $mod_fetch->function_url;
?>

<li <?php if($mod_fetch->module_id==$MN){ ?> class="active has-sub"<?php }?> class='has-sub'>

<?php

if($mod_fetch->module_name=='Reports')
{
//echo "<li class='has-sub'>"; 
?>
<a href="#" onclick="window.location='<?=base_url();?>report/Report/report_function'"><i  class="<?php echo $mod_fetch->module_url; ?>"></i><span class="title"><?php echo $mod_fetch->module_name; ?></span></a> 
<?php } else { 
if($mod_fetch->module_name=='Logout')
{
?>
<a href="#" onclick="window.location='<?php echo base_url()?>master/Item/logout<?php echo $mod_fetch->function_url; ?>'"><i  class="<?php echo $mod_fetch->module_url; ?>"></i><span class="title"><?php echo $mod_fetch->module_name; ?></span></a>
<?php
}else{
?>
<a href="#"><i  class="<?php echo $mod_fetch->module_url; ?>"></i><span class="title"><?php echo $mod_fetch->module_name; ?></span></a> 

<?php } } ?>
<?php echo "<ul class='nav collapse'>"; 

$mod_sql2 = $this->db->query("select distinct f.function_group from tbl_module_function f  join tbl_role_func_action rf on f.func_id=rf.function_url where rf.role_id='".$role."' and rf.action_id !='Inactive' and f.module_name='".$mod_fetch->module_id."'");
foreach ($mod_sql2->result() as $mod_fetch2){
//echo $mod_fetch2->function_url;
$mod_sql3 = $this->db->query("select func_id,function_name,function_url from tbl_module_function where status='A' and module_name='".$mod_fetch->module_id."' and function_group='".$mod_fetch2->function_group."'");

if($mod_fetch2->function_group !='' )
{
//echo "<li class='has-sub'>";

?>

<li <?php if($mod_fetch2->function_group==$GP){  ?> class="active has-sub" <?php }?> class='has-sub'>
<a href="#/"><span class="title"><?php echo $mod_fetch2->function_group; ?></span></a> 
<?php 
echo "<ul class='nav collapse'>";
}
foreach ($mod_sql3->result() as $mod_fetch3){
$rr1=$this->db->query("select action_id from tbl_role_func_action where function_url='".$mod_fetch3->func_id."' and role_id='".$role."' and module_id='".$mod_fetch->module_id."'");
$rr = $rr1->row();
$rr->action_id;
if($rr->action_id != 'Inactive')
{

// if($mod_fetch3->function_url=='report/Report/report_function')
// {}else{

// if($mod_fetch3->function_url=='master/Item/logout')
// {}else{

?>	

<li <?php if($mod_fetch2->function_group==$GP){  ?> <?php if($mod_fetch3->function_url==$page1 or $mod_fetch3->function_url==$page2){?> class="active" <?php }?> <?php }?>><a href="<?php echo base_url();?><?php echo $mod_fetch3->function_url; ?>"><span class="title"><?php echo $mod_fetch3->function_name; ?></span></a></li> 

<?php 
//} //}
//echo "</ul>";

} } 

if($mod_fetch2->function_group!='')
{
echo "</ul></li>";
echo $mod_fetch3->module_name;
}
} echo "</ul></li>"; ?><?php } } ?>


</ul><!-- /main navigation -->		


</div>	 
</div>