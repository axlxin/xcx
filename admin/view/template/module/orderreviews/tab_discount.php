<div class="tab-pane">
<div class="row">
    <div class="col-md-3">
        <h5><strong>Type of discount:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;If you choose the option 'No discount', you will have to remove the following codes from the mail template: {discount_code}, {discount_value}, {total_amount} and {date_end}.</span>
    </div>
    <div class="col-md-3">
        <select name="<?php echo $reviewmail_name; ?>[DiscountType]" id="DiscountType_<?php echo $reviewmail['id']; ?>" class="discountTypeSelect form-control">
            <option value="P" <?php if(!empty($reviewmail_data['DiscountType']) && $reviewmail_data['DiscountType'] == "P") echo "selected"; ?>>Percentage</option>
            <option value="F" <?php if(!empty($reviewmail_data['DiscountType']) && $reviewmail_data['DiscountType'] == "F") echo "selected"; ?>>Fixed amount</option>
            <option value="N" <?php if(empty($reviewmail_data['DiscountType']) || $reviewmail_data['DiscountType'] == "N") echo "selected"; ?>>No discount</option>
        </select>
    </div>
</div>
<br />
<div class="discountSettings">
    <div class="row">
        <div class="col-md-3">
            <h5><strong><span class="required">* </span>Discount:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enter the discount percent or value.</span>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" name="<?php echo $reviewmail_name; ?>[Discount]" value="<?php if(!empty($reviewmail_data['Discount'])) echo $reviewmail_data['Discount']; else echo '10'; ?>">
                <span class="input-group-addon">
                <span style="display:none;" id="currencyAddon"><?php echo $currency; ?></span><span style="display:none;" id="percentageAddon">%</span>
                </span>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3">
            <h5><strong><span class="required">* </span>Total amount:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;The total amount that must reached before the coupon is valid.</span>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" name="<?php echo $reviewmail_name; ?>[TotalAmount]" value="<?php if(!empty($reviewmail_data['TotalAmount'])) echo $reviewmail_data['TotalAmount']; else echo '20'; ?>">
                <span class="input-group-addon"><?php echo $currency ?></span>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3">
            <h5><strong><span class="required">* </span>Discount validity:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Define how many days the discount code will be active after sending the reminder.</span>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" value="<?php if(!empty($reviewmail_data['DiscountValidity'])) echo (int)$reviewmail_data['DiscountValidity']; else echo 7; ?>" name="<?php echo $reviewmail_name; ?>[DiscountValidity]">
                <span class="input-group-addon">days</span>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
         <div class="col-md-3">
            <h5><strong>Discount mail status:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;The customer will receive information about his discount after he submits a review directly in the success page. If you enable this option, the customer will also receive an email with the discount information.</span>
         </div>
         <div class="col-md-3">
            <select id="Checker_<?php echo $reviewmail['id']; ?>" name="<?php echo $reviewmail_name; ?>[DiscountMailEnabled]" class="discountMailSelect form-control">
               <option value="yes" <?php echo (!empty($reviewmail_data['DiscountMailEnabled']) && $reviewmail_data['DiscountMailEnabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
               <option value="no"  <?php echo (empty($reviewmail_data['DiscountMailEnabled']) || $reviewmail_data['DiscountMailEnabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
         </div>
      </div>
</div>
</div>
<script>
   $(function() {
      var $typeSelector = $('#Checker_<?php echo $reviewmail['id']; ?>');
      var $toggleArea = $('#discountMailTab_<?php echo $reviewmail['id']; ?>');
    if ($typeSelector.val() === 'yes') {
              $toggleArea.show(200); 
          }
          else {
              $toggleArea.hide(200); 
          }
      $typeSelector.change(function(){
          if ($typeSelector.val() === 'yes') {
              $toggleArea.show(200); 
          }
          else {
              $toggleArea.hide(200); 
          }
      });
   });
   
   $(function() {
      var $typeSelector = $('#DiscountType_<?php echo $reviewmail['id']; ?>');
      var $toggleArea = $('#discountMailTab_<?php echo $reviewmail['id']; ?>');
	  var $toggleArea2 = $('#Checker_<?php echo $reviewmail['id']; ?>');
    if ($typeSelector.val() === 'N') {
              $toggleArea.hide(200); 
			  $toggleArea2.val('no');
          }
      $typeSelector.change(function(){
          if ($typeSelector.val() === 'N') {
              $toggleArea.hide(200); 
			  $toggleArea2.val('no');
          }
      });
   });
   
   
</script>