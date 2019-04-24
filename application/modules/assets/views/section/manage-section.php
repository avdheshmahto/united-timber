<?php
$this->load->view("header.php");

$entries = "";
if($this->input->get('entries')!="")
{
	$entries = $this->input->get('entries');
}

?>

<div class="main-content">
<div class="panel-body panel panel-default">

<div class="row">
<div class="col-sm-12">
<ol class="breadcrumb"> 
	<li class="active">Manage Section </li> 
</ol>
<div class="panel-body" style="background: #f7f7f7;">

<div id="loadProductData">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<div class="html5buttons">
<div class="dt-buttons">
<a class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="DataTables_Table_0"><span>Excel</span></a>
<!-- <a id="TreeShowId" class="dt-button" tabindex="0" data-toggle="modal" data-target="#modal-2"><span><i class="icon-flow-tree"></i>Section Tree</span></a> -->
<a class="btn btn-sm" data-toggle="modal" formid = "#formId" data-target="#modal-1" id="formreset" style="margin: 0px 0px 15px 0px;"><i class="fa fa-arrow-circle-left" onclick="inputdisable();"></i> Add Section</a>
<a class="btn btn-secondary btn-sm delete_all" style="margin: 0px 0px 15px 0px;"><span><i class="fa fa-trash-o"></i> Delete</span></a>
</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?= base_url('assets/Section/manage_section').'?filtername='.$_GET['filtername'].'&filterdate='.$_GET['filterdate'].'&filter='.$_GET['filter'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10">10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
</select>
entries</label>

<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="margin-top: -5px;margin-left: 12px;float: right;">
Showing <?=$dataConfig['page']+1;?> to 
<?php
	$m=$dataConfig['page']==0?$dataConfig['perPage']:$dataConfig['page']+$dataConfig['perPage'];
	echo $m >= $dataConfig['total']?$dataConfig['total']:$m;
?> of <?=$dataConfig['total'];?> entries
</div>
</div>

<div id="DataTables_Table_0_filter" class="dataTables_filter">
<label>Search:
<input type="text" id="searchTerm"  class="search_box form-control input-sm" onkeyup="doSearch()"  placeholder="What you looking for?">
</label>
</div>
</div>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
<th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
<th>Category Name</th>	
<th>Date</th>
<th>Action</th>
</tr>
</thead>
<thead>
<tr>
<form action="" method="get">
<th></th>
<th><input type="text" name="filtername" id="searchTerm" value="<?=$filtername;?>"  class="search_box form-control input-sm"  placeholder="Please Enter Section Name"></th>
<th><input type="date" name="filterdate" id="searchTerm" value="<?=$filterdate;?>"  class="search_box form-control input-sm"  placeholder="Please Enter Section Date"></th>
<th><button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Filter</span></button></th>
</form>

</tr>
</thead>

<tbody id="getDataTable">
<?php
$yy=1;
if(!empty($result_list)) {
foreach($result_list as $rows) {
?>
<tr class="gradeC record" data-row-id="<?=$rows['id'];?>">
<th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?=$rows['id'];?>" value="<?=$rows['id'];?>" /></th>
<th id="row<?=$rows['id'];?>" onmouseover="showRowtree(<?=$rows['id'];?>)" style="cursor: pointer;"><?php echo $rows['name'];?>
</th>
<th><?=$rows['create_on'];?></th>
<th>


<?php if($view!=''){ ?>
<!-- <button class="btn btn-default modalEditItem" property="view" title="View Category !" type="button" data-toggle="modal" data-target="#modal-1" data-backdrop='static'  typeid = "<?=$rows['type'];?>" arrt = "<?=$rows['name'];?>" cat_id ="<?=$rows['parent_id'];?>" grade="<?=$rows['grade'];?>" onclick ="editRow(this.id,this);"  id="<?=$rows['id'];?>" data-keyboard='false'> <i class="fa fa-eye"></i> </button> -->
<?php } if($edit==''){ ?>  
<a  id="<?=$rows['id'];?>" property="edit" typeid = "<?=$rows['type'];?>"  arrt = "<?=$rows['name'];?>" cat_id ="<?=$rows['parent_id'];?>" grade="<?=$rows['grade'];?>" onclick ="editRow(this.id,this);" class="btn btn-default modalEditItem" title="Update Category !" data-toggle="modal" data-target="#modal-1" >&nbsp; <i class="icon-pencil"></i> &nbsp; </a> 
<?php } ?>      
<?php 
 $pri_col='id';
 $table_name='tbl_category';
?>
<button class="btn btn-default delbutton" title="Delete Category !" id="<?php echo $rows['id']."^".$table_name."^".$pri_col ; ?>" ><i class="icon-trash"></i></button>	

</th>
</tr>
<?php } } ?>
</tbody>
</table>
</div>

<div class="row">
<div class="col-md-12 text-right">
	<div class="col-md-6 text-left"> </div>
	<div class="col-md-6"> 
		<?php echo $pagination; ?>
	</div>
	<div class="popover fade right in displayclass" role="tooltip" id="popover" style=" background-color: #ffffff;border-color: #212B4F;">
		<div class="popover-content" id="showParent"></div>
	</div>
</div>
</div>


</div>  

<!--Large Modal-->
<div id="modal-1" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content" style="top: 38px;left: 45px;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"><span class="top_title">Add</span>&nbsp;Section</h4>
<div id="resultarea" class="text-center" style="font-size: 15px;color: red;"></div>
</div>
<div class="modal-body">
<form class="form-horizontal" id="formId">
<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-6" > 
<p class="text-danger" id="error"></p>
</div>
</div>

<div class="form-group"> 
<label class="col-sm-2 control-label">Select Section</label> 
<div class="col-sm-3"> 
<select class=" form-control" required name="selectCategory" id="selectCategory" style="width: 240px;">
<option value="0" class="listClass">Section</option>
<?php
foreach ($categorySelectbox as $key => $dt) { ?>
<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
<?php } ?>
</select>
</div> 
<input type="hidden" class="hiddenField" name="editvalue" value="" id="editvalue">

<label class="col-sm-2 control-label">Enter Tree Value </label>
<div class="col-sm-3"> 
<input type="text"  name="category" class="form-control" id="category" placeholder="Enter input" value="<?=$name;?>" required>
</div>
</div>

</form>
<div class="modal-footer" id="button">
<?php	if($edit==''){  ?>
<a class="btn btn-sm" style1="padding:4px;"  submit_value = "save" id="target"> Save </a>
<?php } ?>	
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="padding: 4px;">Cancel</button>
</div>

<a  arr='<?=$result;?>' class="treeAncor" id="content_wrap"></a>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End Large Modal-->
</div>


<!--Large Modal-->
<div id="modal-2" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content" style="top: 38px;left: 45px;" >
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"> Show Section Tree </h4>
</div>
<div class="modal-body">
<!-- Card list view -->
<div class="cards-container">
<!-- Card -->
<div class="card">
<div class="card-header panel-heading clearfix">
<div class="content_wrap">
<div class="zTreeDemoBackground left">
	<ul id="treeDemo" class="ztree">
	</ul>
</div>
<div class="right">
</div>
</div> 

</div>
</div>
<!-- /card -->
</div>
<!-- /card container -->
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End Large Modal-->
<!-- /main content -->

<input type="text" style="display:none;" id="table_name" value="tbl_category">  
<input type="text" style="display:none;" id="pri_col" value="id">

</div>
</div>
</div>
</div>
</div>

<?php
$this->load->view("footer.php");
?>
<script>
$(function(){


	var setting = { };
    var da      = "";
    var title   =  $("#content_wrap").attr('arr');
    //console.log(title);
    if(title !== undefined)
    var da      = JSON.parse(title);
  
    var zNodes  = da;
    var curMenu = null, zTree_Menu = null;
    var setting = {
      view:{
        showLine: false,
        showIcon: false,
        selectedMulti: false,
        dblClickExpand: false,
        addDiyDom: addDiyDom
       },
      data: {
        simpleData: {
          enable: true
        }
      },
      callback: {
        beforeClick: beforeClick
      }
    };


 function addDiyDom(treeId, treeNode) {
      var spaceWidth = 5;
      var switchObj = $("#" + treeNode.tId + "_switch"),
      icoObj = $("#" + treeNode.tId + "_ico");
      switchObj.remove();
      icoObj.before(switchObj);

      if (treeNode.level > 1) {
        var spaceStr = "<span style='display: inline-block;width:" + (spaceWidth * treeNode.level)+ "px'></span>";
        switchObj.before(spaceStr);
      }
  }

    function beforeClick(treeId, treeNode) {
      if (treeNode.level == 0 ) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandNode(treeNode);
        return false;
      }
      return true;
    }


$(document).ready(function(){

  if(zNodes != ""){
      var treeObj = $("#treeDemo");
      console.log(treeObj);
      $.fn.zTree.init(treeObj, setting, zNodes);
      zTree_Menu = $.fn.zTree.getZTreeObj("treeDemo");
      curMenu = zTree_Menu.getNodes()[0].children[0].children[0];
      zTree_Menu.selectNode(curMenu);

      treeObj.hover(function () {
        if (!treeObj.hasClass("showIcon")) {
          treeObj.addClass("showIcon");
        }
      }, function() {
        treeObj.removeClass("showIcon");
      });
     }

});

});
//==============**********************========================
</script>


<script type="text/javascript">
// 	function inputdisable(){
//    $('#formId')[0].reset(); 
// }


function editRow(ths){
   var value  =  $('#'+ths).attr("arrt");
   var cat_id =  $('#'+ths).attr("cat_id");
   //var type =  $('#'+ths).attr("typeid");
  // var grade =  $('#'+ths).attr("grade");
   //alert(cat_id);
    $('#selectCategory').val(cat_id).prop('selected', true);
    $('#category').val(value);
   // $('#type').val(type).prop('selected', true);
    //$('#grade').val(grade).prop('selected', true);
    $('#target').attr("submit_value","edit");
    $('#editvalue').val(ths);
}



</script>
