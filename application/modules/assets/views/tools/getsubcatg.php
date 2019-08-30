<div id="subcategory">
  <select name="subcategory" required class="form-control">
    <option value="">----Select----</option>
    <?php 
      $space = "";
      foreach ($result as $dt){	
      					
      ?>					
    <option value="<?=$dt['id']; ?>" > <?=$dt['name']; ?></option>
    <?php  } ?>
  </select>
</div>