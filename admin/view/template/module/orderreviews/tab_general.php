<div class="tab-pane fade in active">
<div class="row">
   <div class="col-md-3">
      <h5><strong><span class="required">* </span>ReviewMail <?php echo $reviewmail['id']; ?> status:</strong></h5>
      <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the selected mail review configuration.</span>
   </div>
   <div class="col-md-3">
      <select id="Checker" name="<?php echo $reviewmail_name; ?>[Enabled]" class="form-control">
         <option value="yes" <?php echo (!empty($reviewmail_data['Enabled']) && $reviewmail_data['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
         <option value="no"  <?php echo (empty($reviewmail_data['Enabled']) || $reviewmail_data['Enabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
      </select>
   </div>
</div>
<br />
<div class="row">
   <br />
   <div class="col-md-3">
      <h5><strong>ReviewMail <?php echo $reviewmail['id']; ?> name:</strong></h5>
      <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the name of the template which will show up on the left column.</span>
   </div>
   <div class="col-md-3">
      <input type="text" class="form-control" name="<?php echo $reviewmail_name; ?>[Name]" value="<?php if (isset($reviewmail_data['Name'])) echo $reviewmail_data['Name']; else echo 'ReviewMail '.$reviewmail['id'] ; ?>" />
   </div>
</div>
</div>