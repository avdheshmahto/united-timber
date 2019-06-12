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
<button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
<a class="btn btn-sm" data-toggle="modal" formid = "#formId" data-target="#modal-1" id="formreset" ><i class="fa fa-arrow-circle-left" onclick="inputdisable();"></i> Add Section</a>

</div>
</div>

<div class="dataTables_length" id="DataTables_Table_0_length">
<label>Show
<select name="DataTables_Table_0_length" url="<?= base_url('assets/Section/manage_section?')?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
	<option value="10">10</option>
	<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
	<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
	<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
  <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
  <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>
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
<table class="table table-striped table-bordered table-hover dataTables-example1" id="loadData">
<thead>
<tr>
<th>Category Name</th>	
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody id="getDataTable">

<tr style="display: none;">
  <th></th>
  <th></th>
  <th></th>
</tr>

<?php
$yy=1;
if(!empty($result_list)) {
foreach($result_list as $rows) {
?>
<tr class="gradeC record" data-row-id="<?=$rows['id'];?>">
<th id="row<?=$rows['id'];?>" onmouseover="showRowtree1(<?=$rows['id'];?>)" style="cursor: pointer;"><?php echo $rows['name'];?>
</th>
<th><?=$rows['create_on'];?></th>
<th>
<?php if($edit==''){ ?>  
<a  id="<?=$rows['id'];?>" property="edit" typeid = "<?=$rows['type'];?>"  arrt = "<?=$rows['name'];?>" cat_id ="<?=$rows['parent_id'];?>" grade="<?=$rows['grade'];?>" onclick ="editRow(this.id,this);" class="btn btn-default modalEditItem" title="Update Category !" data-toggle="modal" data-target="#modal-1" >&nbsp; <i class="icon-pencil"></i> &nbsp; </a> 
<?php } ?>      
<?php 
 $pri_col='id';
 $table_name='tbl_category';

$stfCostLog=$this->db->query("select * from tbl_software_cost_log where (section_id='".$rows['id']."' OR main_section='".$rows['id']."') ");
$numCost=$stfCostLog->num_rows();

$sftStkLog=$this->db->query("select * from tbl_machine where m_type='".$rows['id']."' ");
$numStk=$sftStkLog->num_rows();

$countRows=$numCost + $numStk;

if($countRows > 0 ) {  ?>
<button class="btn btn-default" type="button" title="Delete Category" onclick="return confirm('Section already map. You can not delete ?');"><i class="icon-trash"></i></button>
<?php } else { ?>

<button class="btn btn-default delbutton_section" title="Delete Category" id="<?php echo $rows['id']."^".$table_name."^".$pri_col ; ?>" ><i class="icon-trash"></i></button>	
<?php } ?>
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
<label class="col-sm-2 control-label" style="display: none;">Select Section</label> 
<div class="col-sm-3" style="display: none;"> 
<select class=" form-control" required name="selectCategory" id="selectCategory" style="width: 240px;">
<option value="0" class="listClass">Section</option>
<?php
foreach ($categorySelectbox as $key => $dt) { ?>
<option id="<?=$dt['id'];?>" value = "<?=$dt['id'];?>" class="<?=$dt['praent']==0 ? 'listClass':'';?>" > <?=$dt['name'];?></option>
<?php } ?>
</select>
</div> 
<input type="hidden" class="hiddenField" name="editvalue" value="" id="editvalue">

<label class="col-sm-2 control-label">Section Name </label>
<div class="col-sm-3"> 
<input type="text"  name="category" class="form-control" id="category" placeholder="Enter input" value="<?=$name;?>" required>
</div>
</div>

</form>
<div class="modal-footer" id="button">
<?php	if($edit==''){  ?>
<a class="btn btn-sm" style1="padding:4px;"  submit_value = "save" id="target"> Save </a>
<?php } ?>	
<span id="saveload" style="display: none;">
<img src="<?=base_url('assets/loadgif.gif');?>" alt="HTML5 Icon" width="44.63" height="30">
</span>
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


<script type="text/javascript">
function exportTableToExcel(tableID, filename = '')
{

    //alert();
   var downloadLink;
   var dataType = 'application/vnd.ms-excel';
   var tableSelect = document.getElementById(tableID);
   var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
   // Specify file name
   filename = filename?filename+'.xls':'Section <?php echo date('d-m-Y');?>.xls';
   
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
</script>