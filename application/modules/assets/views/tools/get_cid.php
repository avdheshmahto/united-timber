<p>Actions <img src="<?php echo base_url();?>/assets/images/arrow.png" alt="" /></p>
<ul>
  <?php if($delete!=''){ ?>
  <li>
    <input type="submit" name="del" value="delete" class="submit" onclick="return confirm('Are you sure you want to delete ?');" />
  </li>
  <?php } ?>
</ul>