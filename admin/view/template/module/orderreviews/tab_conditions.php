<div class="tab-pane fade in active">

	<div class="row">

   <div class="col-md-3">

      <h5><strong>Order status:</strong></h5>

      <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Define the order status for the selected mail review.</span>

   </div>

   <div class="col-md-3">

      <select required class="form-control" name="<?php echo $reviewmail_name; ?>[OrderStatusID]">

         <option disabled selected value="">Select order status</option>

         <?php if (!empty($orderStatuses)) { foreach ($orderStatuses as $orderStatus) {  ?>

         <option value="<?php echo $orderStatus['order_status_id']; ?>" 

            <?php if(!empty($reviewmail_data['OrderStatusID']) && ($orderStatus['order_status_id'] == $reviewmail_data['OrderStatusID'])) {

               echo 'selected="selected"'; 

               } else if(empty($reviewmail_data['OrderStatusID']) && $orderStatus['name'] == 'Complete') { 

               echo 'selected="selected"';

               } ?>>

            <?php echo $orderStatus['name']; ?> 

         </option>

         <?php } }?>

      </select>

   </div>

</div>

<br />

<div class="row">

   <div class="col-md-3">

      <h5><strong>Customer group:</strong></h5>

      <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Specify customer group for the selected mail review.</span>

   </div>

   <div class="col-md-3">

      <select required class="form-control" name="<?php echo $reviewmail_name; ?>[CustomerGroupID]">

         <option value="send_all" selected value="">All customer groups</option>

         <?php if (!empty($customer_groups)) { foreach ($customer_groups as $customer_group) {  ?>

         <option value="<?php echo $customer_group['customer_group_id']; ?>" 

            <?php if(!empty($reviewmail_data['CustomerGroupID']) && ($customer_group['customer_group_id'] == $reviewmail_data['CustomerGroupID'])) {

               echo 'selected="selected"'; 

               } else if(empty($reviewmail_data['CustomerGroupID']) && $customer_group['name'] == 'Complete') { 

               echo 'selected="selected"';

               } ?>>

            <?php echo $customer_group['name']; ?> 

         </option>

         <?php } }?>

      </select>

   </div>

</div>

<br />

<div class="row">

   <div class="col-md-3">

      <h5><strong>Message delay:</strong></h5>

      <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Define after how many days to send the email.<br /><br />

      <strong>NOTE: </strong>If you set the delay to 0, the message will be sent immediately after you change the order status.</span>

   </div>

   <div class="col-md-3">

      <div class="input-group">

         <input type="text" class="form-control" name="<?php echo $reviewmail_name; ?>[Delay]" value="<?php if (isset($reviewmail_data['Delay'])) echo $reviewmail_data['Delay']; else echo '15'; ?>" />

         <span class="input-group-addon">days</span>

      </div>

   </div>

</div>

<br />

<div class="row">

   <div class="col-md-3">

      <h5><strong>Select orders by:</strong></h5>

      <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose how the orders should be selected.</span>

   </div>

   <div class="col-md-3">

      <select name="<?php echo $reviewmail_name; ?>[DateType]" class="form-control">

         <option value="date_added" <?php echo (!empty($reviewmail_data['DateType']) && $reviewmail_data['DateType'] == 'date_added') ? 'selected=selected' : '' ?>>Date Added</option>

         <option value="date_modified"  <?php echo (empty($reviewmail_data['DateType']) || $reviewmail_data['DateType']== 'date_modified') ? 'selected=selected' : '' ?>>Date Modified</option>

      </select>

   </div>

</div>

<br />

<div class="row">

   <div class="col-md-3">

      <h5><strong>Review type:</strong></h5>

      <span class="help">Choose whether there should be one form for all products in a purchase or each product in the given purchase should have individual form.</span>

   </div>

   <div class="col-md-3">

      <select name="<?php echo $reviewmail_name; ?>[ReviewType]" class="form-control">

         <option value="per_product" <?php echo (!empty($reviewmail_data['ReviewType']) && $reviewmail_data['ReviewType'] == 'per_product') ? 'selected=selected' : '' ?>>Per Product</option>

         <option value="per_purchase"  <?php echo (empty($reviewmail_data['ReviewType']) || $reviewmail_data['ReviewType']== 'per_purchase') ? 'selected=selected' : '' ?>>Per Purchase</option>

      </select>

   </div>

</div>

<br />

<div class="row" id="displayImages_<?php echo $reviewmail['id']; ?>">

   <div class="col-md-3">

      <h5><strong>Display images:</strong></h5>

      <span class="help">Choose whether to display product images in the email which will be sent to the customer.</span>

   </div>

   <div class="col-md-3">

      <select name="<?php echo $reviewmail_name; ?>[DisplayImages]" class="form-control">

         <option value="yes" <?php echo (!empty($reviewmail_data['DisplayImages']) && $reviewmail_data['DisplayImages'] == 'yes') ? 'selected=selected' : '' ?>>Yes</option>

         <option value="no"  <?php echo (empty($reviewmail_data['DisplayImages']) || $reviewmail_data['DisplayImages']== 'no') ? 'selected=selected' : '' ?>>No</option>

      </select>

   </div>

</div>

</div>

