<div class="panel-body">
  <div class="row">
    <div class="col-sm-12">
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>master/Item/dashboar"><i class="fa fa-home"></i>Dashboard</a></li>
        <li><a href="#">Assets</a></li>
        <li class="active"><strong>Manage Toolsa</strong></li>
      </ol>
    </div>
  </div>
  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="html5buttons">
      <div class="dt-buttons">
        <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('getDataTable')">Excel</button>
        <a class="btn btn-sm" data-toggle="modal" formid = "#ToolForm" data-target="#modal-0" id="formreset"><i class="fa fa-arrow-circle-left"></i> Add Tool</a>
        <a class="btn btn-secondary btn-sm delete_all" ><span><i class="fa fa-trash-o"></i> Delete</span></a>
      </div>
    </div>
    <div class="dataTables_length" id="DataTables_Table_0_length">
      <label>
        Show
        <select name="DataTables_Table_0_length" url="<?=base_url();?>assets/tools/manage_tools?<?='sku_no='.$_GET['sku_no'].'&category='.$_GET['category'].'&productname='.$_GET['productname'].'&usages_unit='.$_GET['usages_unit'].'&purchase_price='.$_GET['purchase_price'].'&type_of_spare='.$_GET['type_of_spare'].'&filter='.$_GET['filter'];?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
          <option value="10" <?=$entries=='10'?'selected':'';?>>10</option>
          <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
          <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
          <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
          <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
          <option value="1000" <?=$entries=='1000'?'selected':'';?>>1000</option>
          <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>All</option>
        </select>
        entries
      </label>
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
  <!--row close-->
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example_"  id="getDataTable">
      <thead bgcolor="#CCCCCC">
        <tr>
          <th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
          <th>Serial Number </th>
          <th>Type Of Tools</th>
          <th>Priority</th>
          <th>Tool Name</th>
          <th>Usages Unit</th>
          <th>Purchase Price</th>
          <th>Quantity</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id = "getDataTable">
        <tr>
          <form method="get">
            <td>&nbsp;</td>
            <td><input name="sku_no"  type="text"  class="search_box form-control input-sm"  value="" /></td>
            <!--<td><input name="category"  type="text"  class="search_box form-control input-sm"  value="" /></td>-->
            <td><input name="priority"  type="text"  class="search_box form-control input-sm"  value="" /></td>
            <td><input name="type_of_tool"  type="text"  class="search_box form-control input-sm"  value="" /></td>
            <td><input name="productname"  type="text"  class="search_box form-control input-sm"  value="" /></td>
            <td><input name="usages_unit"  type="text"  class="search_box form-control input-sm"  value="" /></td>
            <td><input name="unitprice_purchase" type="text"  class="search_box form-control input-sm"  value="" /></td>
            <td><input name="quantity" type="text"  class="search_box form-control input-sm"  value="" /></td>
            <td><button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Search</span></button></td>
          </form>
        </tr>
        <?php  
          $i=1;
          if($result != ""){
            foreach($result as $fetch_list)
            {
            ?>
        <tr class="gradeC record" data-row-id="<?php echo $fetch_list->Product_id; ?>">
          <th><input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?php echo $fetch_list->Product_id; ?>" value="<?php echo $fetch_list->Product_id;?>" /></th>
          <?php
            $queryType=$this->db->query("select *from tbl_master_data where serial_number='$fetch_list->type'");
            $getType=$queryType->row();
            
            
            ?>
          <th><?=$fetch_list->sku_no;?></th>
          <th><?php $compQuery1 = $this -> db
            -> select('*')
            -> where('serial_number',$fetch_list->type_of_spare)
            -> get('tbl_master_data');
            $keyvalue1 = $compQuery1->row();
            echo $keyvalue1->keyvalue;		  
            ?></th>
          <th><?php $compQuery1 = $this -> db
            -> select('*')
            -> where('serial_number',$fetch_list->priority)
            -> get('tbl_master_data');
            $keyvalue1 = $compQuery1->row();
            echo $keyvalue1->keyvalue; ?></th>
          </th>
          <?php 
            $size=$this->db->query("select *from tbl_master_data where serial_number='$fetch_list->size'");
            $psize=$size->row();
            if($psize->keyvalue !='')
            {
            ?>
          <th><?php echo $fetch_list->productname .'   ( '.$psize->keyvalue .')' ; } else { ?></th>
          <th><a href="<?=base_url();?>assets/tools/manage_tool_map?id=<?php echo $fetch_list->Product_id; ?>" title="Tools Details"><?php echo $fetch_list->productname; } ?></a></th>
          <th>
            <?php
              $compQuery1 = $this -> db
              		   -> select('*')
              		   -> where('serial_number',$fetch_list->usageunit)
              		   -> get('tbl_master_data');
              		  $keyvalue1 = $compQuery1->row();
              echo $keyvalue1->keyvalue;		  
              
              
              ?>
          </th>
          <th><?=$fetch_list->unitprice_purchase?></th>
          <th><?=$fetch_list->quantity?></th>
          <th class="bs-example">
            <?php if($view!=''){ ?>
            <!--<button class="btn btn-default" type="button" property="view" arrt= '<?=json_encode($fetch_list);?>' onclick ="editRow(this);" data-toggle="modal" data-target="#modal-0" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i></button>
              -->
            <!-- <button class="btn btn-default modalEditItem" data-a="<?php echo $fetch_list->Product_id;?>" href='#edittool' onclick="getEditItem('<?php echo $fetch_list->Product_id;?>','view')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false'><i class="fa fa-eye"></i></button>
              -->
            <?php } if($edit!=''){ ?>
            <button class="btn btn-default modalEdittool" data-a="<?php echo $fetch_list->Product_id;?>" href='#edittool' onclick="getEdittool('<?php echo $fetch_list->Product_id;?>','edit')" type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' title="Edit Tools"><i class="icon-pencil"></i></button>
            <!--<a  arrt= '<?=json_encode($fetch_list);?>'   onclick ="editRow(this);" class="btn btn-default"  data-toggle="modal" data-target="#modal-0" >&nbsp; <i class="icon-pencil"></i>&nbsp; </a> -->
            <?php }
              $pri_col='Product_id';
              $table_name='tbl_product_stock';
              ?>
            <button class="btn btn-default delbutton" id="<?php echo $fetch_list->Product_id."^".$table_name."^".$pri_col ; ?>" type="button"><i class="icon-trash"></i></button>		
            <?php
              ?>
            <!--  <button class="btn btn-default " type="button" onclick ="viewItem(<?=$fetch_list->Product_id;?>);" type="button" data-toggle="modal" data-target="#modal-1" data-backdrop='static' data-keyboard='false'> <i class="fa fa-eye"></i> </button>
              -->
          </th>
        </tr>
        <?php $i++; }} ?>
      </tbody>
      <input type="text" style="display:none;" id="table_name" value="tbl_product_stock">  
      <input type="text" style="display:none;" id="pri_col" value="Product_id">
    </table>
  </div>
  <div class="row">
    <div class="col-md-12 text-right">
      <div class="col-md-6 text-left"> </div>
      <div class="col-md-6"> <?php echo $pagination; ?></div>
    </div>
  </div>
</div>