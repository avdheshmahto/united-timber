
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
              <div class="html5buttons">
                <div class="dt-buttons">
                  <button class="dt-button buttons-excel buttons-html5" onclick="exportTableToExcel('loadData')" title="Excel">Excel</button>
                  <a class="btn btn-sm" data-toggle="modal" formid = "#formId" data-target="#modal-1" id="formreset" ><i class="fa fa-arrow-circle-left" onclick="inputdisable();"></i> Add Section</a>
                </div>
              </div>
              <div class="dataTables_length" id="DataTables_Table_0_length">
                <label>
                  Show
                  <select name="DataTables_Table_0_length" url="<?= base_url('assets/Section/manage_section?')?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">
                    <option value="10">10</option>
                    <option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
                    <option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
                    <option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
                    <option value="500" <?=$entries=='500'?'selected':'';?>>500</option>
                    <option value="<?=$dataConfig['total'];?>" <?=$entries==$dataConfig['total']?'selected':'';?>>ALL</option>
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
                    <th id="row<?=$rows['id'];?>" onmouseover="showRowtree1(<?=$rows['id'];?>)" style="cursor: pointer;"><?php echo $rows['name'];?></th>
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
          