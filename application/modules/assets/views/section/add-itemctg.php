
		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
			<div class="html5buttons">
			  <div class="dt-buttons">
				<a class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="DataTables_Table_0"><span>Excel</span></a>
				<a id="TreeShowId" class="dt-button" tabindex="0" data-toggle="modal" data-target="#modal-2" onclick="showtree();"><span><i class="icon-flow-tree"></i>Category Tree</span></a>
				<a class="btn btn-sm" data-toggle="modal" formid = "#formId" data-target="#modal-1" id="formreset"><i class="fa fa-arrow-circle-left" onclick="inputdisable();"></i> Add Category</a>
				<a class="btn btn-secondary btn-sm delete_all" ><span><i class="fa fa-trash-o"></i> Delete</span></a>
				  </div>
				    </div>
                     
					<div class="dataTables_length" id="DataTables_Table_0_length">
						<label>Show
						<select name="DataTables_Table_0_length" url="<?=base_url('master/ProductCategory/manage_itemctg');?>" aria-controls="DataTables_Table_0" id="entries" class="form-control input-sm">

						<option value="10">10</option>
						<option value="25" <?=$entries=='25'?'selected':'';?>>25</option>
						<option value="50" <?=$entries=='50'?'selected':'';?>>50</option>
						<option value="100" <?=$entries=='100'?'selected':'';?>>100</option>
						</select>
						entries</label>
						<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite" style="    margin-top: -5px;margin-left: 12px;float: right;">Showing <?=$dataConfig['page']+1;?> to 
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
                                <th></th>
								<th><br>Category Name</th>	
								<!-- <th>Type</th>	 -->
								<th>Date</th>
								<th>Action</th>
								<!-- <th>Action</th> -->
								</tr>
								<tr>
							    
                                <th><input name="check_all" type="checkbox" id="check_all" onClick="checkall(this.checked)" value="check_all" /></th>
                                <form action="" method="get">
								<th><input type="text" name="filtername" id="searchTerm" value="<?=$filtername;?>"  class="search_box form-control input-sm"  placeholder="Please Enter Category Name"></th>
								<!-- <th>
								  <select class="search_box form-control input-sm" name="filtertype">
									<option value = "">Select Category Type</option>
									<option value= "1">Product</option>
									<option value= "2">Quotation</option>
								  </select>
							    </th> -->		
								<th><input type="date" name="filterdate" id="searchTerm" value="<?=$filterdate;?>"  class="search_box form-control input-sm"  placeholder="Please Enter Category Date"></th>
								<th><button type="submit" class="btn btn-sm" name="filter" value="filter"><span>Filter</span></button>
								<!-- <a href="<?=base_url('master/ProductCategory/manage_itemctg');?>"  class="btn btn-sm"  value="filter"><span>All</span></a> -->
								</th>
							    </form>
								<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody id="getDataTable">
							<?php
							$yy=1;
							if(!empty($result_list)) {
							  foreach($result_list as $rows) {
							?>
							<tr class="gradeC record" data-row-id="<?=$rows['id'];?>">
								<th>
								<input name="cid[]" type="checkbox" id="cid[]" class="sub_chk" data-id="<?=$rows['id'];?>" value="<?=$rows['id'];?>" />
							    </th>
								<th id="row<?=$rows['id'];?>" onmouseover="showRowtree(<?=$rows['id'];?>)" style="cursor: pointer;"><?php echo $rows['name'];?>
								</th>
								<!-- <th><?=$rows['type']==1?'Product':'';?><?=$rows['type']==2?'Quotation':'';?><?=$rows['type']==3?'Scope':'';?></th> -->
								<th><?=$rows['create_on'];?></th>
								<th>
								<?php $pri_col='id';
                                      $table_name='tbl_category';
                                ?>
                                
                         <?php if($view!=''){ ?>
                             <button class="btn btn-default modalEditItem" type="button" data-toggle="modal" data-target="#modal-1" data-backdrop='static'  typeid = "<?=$rows['type'];?>" arrt = "<?=$rows['name'];?>" cat_id ="<?=$rows['parent_id'];?>" grade="<?=$rows['grade'];?>" onclick ="editRow(this.id);"  id="<?=$rows['id'];?>" data-keyboard='false'> <i class="fa fa-eye"></i> </button>
                         <?php } if($edit==''){ ?>  
                         <a  id="<?=$rows['id'];?>" typeid = "<?=$rows['type'];?>"  arrt = "<?=$rows['name'];?>" cat_id ="<?=$rows['parent_id'];?>" grade="<?=$rows['grade'];?>" onclick ="editRow(this.id);" class="btn btn-default modalEditItem"  data-toggle="modal" data-target="#modal-1" >&nbsp; <i class="icon-pencil"></i> &nbsp; </a> 
                          <?php } ?>      
                           <button class="btn btn-default delbutton" id="<?php echo $rows['id']."^".$table_name."^".$pri_col ; ?>" ><i class="icon-trash"></i></button>	
                       
						</th>
					</tr>
				<?php } } ?>
              </tbody>
            </table>
		  </div>
		  <div class="row">
	       <div class="col-md-12 text-right">
	    	  <div class="col-md-6 text-left"> 
	    	  <!-- <h6>Showing 1 to 10 of <?php echo $totalrow; ?> entries</h6> -->
	    	  </div>
	    	  <div class="col-md-6"> 
	          <?php echo $pagination; ?>
	          </div>

	        <div class="popover fade right in displayclass" role="tooltip" id="popover" style=" background-color: #ffffff;border-color: #212B4F;"><!-- <div class="arrow" style="top: 50%;"></div>  -->
			<div class="popover-content" id="showParent"></div>
			</div>
	       </div>
	     </div>

	     
        