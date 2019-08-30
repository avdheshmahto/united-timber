<?php
  $this->load->view("header.php");
  $tableName='tbl_product_stock';
  $location='manage_item';
  		
  		$userQuery = $this -> db
             -> select('*')
  		   -> where('Product_id',$_GET['id'])
  		   -> or_where('Product_id',$_GET['view'])
             -> get('tbl_product_stock');
  		  $branchFetch = $userQuery->row();
  
  ?>
<!-- Main content -->
<div class="main-content">
<?php if(@$_GET['popup'] == 'True') {} else {?>
<ol class="breadcrumb breadcrumb-2">
  <li><a class="btn btn-success" href="<?=base_url();?>master/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
</ol>
<?php }?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h4 class="panel-title"><strong>Change Password</strong></h4>
        <ul class="panel-tool-options">
          <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
        </ul>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" method="post" action="qureychange_pass" enctype="multipart/form-data">
          <input type="hidden" name="userId" value="<?php echo $this->session->userdata('user_id');?>" />
          <div class="form-group">
            <label class="col-sm-2 control-label">*Current Password:</label> 
            <div class="col-sm-4"> 
              <input type="password" name="oldpass" class="form-control" required />
            </div>
            <label class="col-sm-2 control-label">*New Password:</label> 
            <div class="col-sm-4" id="regid"> 
              <input type="password" name="newpass" class="form-control" required />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">*Repeat Password:</label> 
            <div class="col-sm-4" id="regid"> 
              <input type="password" name="confirmpass" class="form-control" required />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
              <input type="submit" class="btn btn-primary" value="Change">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
  $this->load->view("footer.php");
  
  ?>