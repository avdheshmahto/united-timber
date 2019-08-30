<?php
  $binQuery=$this->db->query("select *from tbl_bin_card_hdr");
  $getBin=$binQuery->row();
  
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>unitetimber</title>
    <link rel='stylesheet' type='text/css' href='<?=base_url();?>assets/bincardprint/css/style.css' />
  </head>
  <body>
    <div id="page-wrap">
      <div id="customer">
        <table id="meta" style="margin-bottom:10px;">
          <tr>
            <td colspan="5">
              <center><strong>MATERIAL MASTER (MM) cum BINCARD</strong></center>
            </td>
          </tr>
        </table>
        <div style="clear:both"></div>
        <table id="meta">
          <tr>
            <td><strong>Item Code</strong></td>
            <td colspan="2"><strong>Item Description</strong></td>
            <td><strong>Category</strong></td>
            <td><strong>UOM</strong></td>
            <td><strong>Unit Value</strong></td>
            <td><strong>Bin No.</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>Normal Lead Time</strong></td>
            <td><strong>Minimum Stock Level</strong></td>
            <td><strong>Maximum Stock</strong></td>
            <td><strong>Avg. Monthly Consumption</strong></td>
            <td><strong>Re-Order Level</strong></td>
            <td><strong>Storage Condition</strong></td>
            <td><strong>Bin Location</strong></td>
          </tr>
        </table>
        <div style="clear:both"></div>
        <table id="items-to">
          <tr>
            <th>New</th>
            <th>OK</th>
            <th>Test</th>
            <th>Rep.</th>
            <th>Rjct.</th>
          </tr>
          <tr class="item-row">
            <td colspan="5" align="center" class="item-name"> Grade</td>
          </tr>
        </table>
        <table id="items-to">
          <tr>
            <th>H</th>
            <th>M</th>
            <th>L</th>
          </tr>
          <tr class="item-row">
            <td colspan="3" align="center" class="item-name"> Cost</td>
          </tr>
        </table>
        <table id="items-to">
          <tr>
            <th>D</th>
            <th>S</th>
            <th>P</th>
          </tr>
          <tr class="item-row">
            <td colspan="3" align="center" class="item-name"> Shelf Life</td>
          </tr>
        </table>
        <table id="items-to">
          <tr>
            <th>V</th>
            <th>E</th>
            <th>N</th>
          </tr>
          <tr class="item-row">
            <td colspan="3" align="center" class="item-name"> Quality</td>
          </tr>
        </table>
        <table id="items-last">
          <tr>
            <th>A</th>
            <th>B</th>
            <th>C</th>
          </tr>
          <tr class="item-row">
            <td colspan="3" align="center" class="item-name"> Class</td>
          </tr>
        </table>
        <div style="clear:both"></div>
        <table id="meta">
          <tr>
            <td colspan="5">
              <center><strong>Preferred Vendor Code</strong></center>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <div style="clear:both"></div>
        <table id="meta" style="margin-top:10px;">
          <tr>
            <td colspan="5">
              <center><strong>STOCK CONTROL</strong></center>
            </td>
          </tr>
        </table>
        <div style="clear:both"></div>
        <table id="meta" style="margin-top:10px;">
          <tr>
            <td><strong>Date</strong></td>
            <td><strong>Receipt</strong></td>
            <td><strong>GRN No.</strong></td>
            <td><strong>GRN Date</strong></td>
            <td><strong>Issues</strong></td>
            <td><strong>Min#</strong></td>
            <td><strong>MIN Date</strong></td>
            <td><strong>Balance</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <div style="clear:both"></div>
        <table id="meta" style="margin-top:10px;">
          <tr>
            <td width="25%"><strong><strong>Pending Requisitions/POs</strong></strong></td>
            <td width="26%">&nbsp;</td>
            <td width="11%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="15%">&nbsp;</td>
            <td width="13%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><strong>UTW MM 001</strong> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>