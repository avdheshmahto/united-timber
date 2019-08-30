<?php
  $this->load->view("header.php");
  $tableName='tbl_master_data';
  $location='manage_master_data';
  		
  		$userQuery = $this -> db
             -> select('*')
  		   -> where('serial_number',$_GET['id'])
  		   -> or_where('serial_number',$_GET['view'])
             -> get('tbl_master_data');
  		  $branchFetch = $userQuery->row();
  
  ?>
<!-- Main content -->
<div class="main-content">
<?php if(@$_GET['popup'] == 'True') {} else {?>
<ol class="breadcrumb breadcrumb-2">
  <li><a class="btn btn-success" href="<?=base_url();?>admin/masterdata/manage_master_data">Manage Master Data</a></li>
</ol>
<ol class="breadcrumb breadcrumb-2">
  <li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
  <li><a href="#">Admin Setup</a></li>
  <li><a href="#">Master Data</a></li>
  <li class="active"><strong><a href="#">Add Master Data</a></strong></li>
</ol>
<?php }?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <?php if($_GET['id']!=''){ ?>
        <h4 class="panel-title"><strong>Update Master Data</strong></h4>
        <?php }elseif($_GET['view']!=''){ ?>
        <h4 class="panel-title"><strong>View Master Data</strong></h4>
        <?php }else{ ?> 
        <h4 class="panel-title"><strong>Add Master Data</strong></h4>
        <?php } ?>
        <ul class="panel-tool-options">
          <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
        </ul>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" method="post" action="insert_master_data">
          <div class="form-group">
            <label class="col-sm-2 control-label">*Value Name:</label> 
            <div class="col-sm-4">
              <input type="hidden" name="serial_number" value="<?php echo $branchFetch->serial_number; ?>" />
              <select name="param_id" class="form-control" required <?php if(@$_GET['view']!=""){ ?> disabled="disabled" <?php } ?>>
                <option value="">-----select----</option>
                <?php
                  $comp_sql = $this->db->query("select * FROM tbl_master_data_mst where status='A'");
                  
                  foreach ($comp_sql->result() as $comp_fetch){
                  
                   ?>
                <option value="<?php  echo @$comp_fetch->param_id;?>" <?php if(@$comp_fetch->param_id==@$branchFetch->param_id){ ?> selected="selected" <?php }?>><?php echo @$comp_fetch->keyname;?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">*Added Value:</label> 
            <div class="col-sm-4"> 
              <input name="keyvalue" type="text" class="form-control" value="<?php echo $branchFetch->keyvalue?>" <?php if($_GET['view']!='') {?> readonly="" <?php }?> required> 
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">*Description:</label> 
            <div class="col-sm-4"> 
              <textarea name="description" class="form-control" type="text" <?php if($_GET['view']!='') {?> readonly="" <?php }?>><?php echo $branchFetch->description?></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
              <?php if(@$_GET['popup'] == 'True') {
                if($_GET['id']!=''){
                ?>
              <input type="submit" class="btn btn-primary" value="Save">
              <?php } ?>
              <a href="" onclick="popupclose(this.value)"  title="Cancel" class="btn btn-blue"> Cancel</a>
              <?php }else {  ?>
              <input type="submit" class="btn btn-primary" value="Save">
              <a href="<?=base_url();?>admin/masterdata/manage_master_data" class="btn btn-blue">Cancel</a>
              <?php } ?>
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