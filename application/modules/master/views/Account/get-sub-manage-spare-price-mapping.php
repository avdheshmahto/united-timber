<table class="table table-striped table-bordered table-hover dataTables-example1"  id="loadsparepricemapping" >
  <thead>
    <tr>
      <th>SPARE NAME</th>
      <th>RATE</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
      	 
      	 $sparequery = $this->db->query("select * from tbl_vendor_spare_price_map where status = 'A' AND vendor_id = '$id' ORDER BY id DESC");
      
        foreach($sparequery->result() as $fetch_list)
        {
        $pname=$this->db->query("select * from tbl_product_stock where Product_id='$fetch_list->spare_id' ");
          $getPname=$pname->row();
          
      ?>
    <tr>
      <td><?=$getPname->productname;?></td>
      <td><?=$fetch_list->price;?></td>
    </tr>
    <?php  $i++;  }  ?>
    <tr class="gradeU">
      <td>
        <button  class="btn btn-default modalMapSpare" data-a="<?php echo $fetch_list->id;?>" href='#mapSpare'  type="button" data-toggle="modal" data-backdrop='static' data-keyboard='false' formid = "#mapSpareForm" id="formreset" title="Add Spare Price Mapping"><img src="<?=base_url();?>assets/images/plus.png" /></button>
      </td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>