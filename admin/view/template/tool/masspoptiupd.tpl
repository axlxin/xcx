<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid"> <!-- continut -->
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    
    <div class="panel panel-default"> <!-- filters div -->
      
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $masstxt_p_filters_h; ?></h3>
      </div>
      
      <div class="panel-body">
      <div class="table-responsive">
    	<table class="table table-bordered table-hover"> <!-- filters table -->
    	<tbody>

    	<tr>
    	  <td class="text-left" style="width:236px;">
    	  <strong><?php echo $masstxt_name; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <input size="42" type="text" value="<?php echo $filter_name; ?>" name="filter_name">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_name_help; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_tag; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <input size="42" type="text" value="<?php echo $filter_tag; ?>" name="filter_tag">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_tag_help; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_model; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <input size="42" type="text" value="<?php echo $filter_model; ?>" name="filter_model">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_model_help; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_categories; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
              <div class="well well-sm scroll1">
                <div class="checkbox">
                  <label>
                    <?php if (in_array(0, $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="0" checked="checked" /><?php echo $masstxt_none_cat; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_category[]" value="0" /><?php echo $masstxt_none_cat; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($categories as $category) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($category['category_id'], $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $masstxt_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $masstxt_unselect_all; ?></a>
              <label class="control-label tooltip1"><span data-toggle="tooltip" title="<?php echo $masstxt_unselect_all_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_manufacturers; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
              <div class="well well-sm scroll1">
                <div class="checkbox">
                  <label>
                    <?php if (in_array(0, $manufacturer_ids)) { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="0" checked="checked" /><?php echo $masstxt_none; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="0" /><?php echo $masstxt_none; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($manufacturers as $manufacturer) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($manufacturer['manufacturer_id'], $manufacturer_ids)) { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                    <?php echo $manufacturer['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                    <?php echo $manufacturer['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $masstxt_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $masstxt_unselect_all; ?></a>
              <label class="control-label tooltip1"><span data-toggle="tooltip" title="<?php echo $masstxt_unselect_all_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_p_filters; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <?php if($p_filters) { ?>
              <div class="well well-sm scroll1">
                <div class="checkbox">
                  <label>
                    <?php if (in_array(0, $filters_ids)) { ?>
                    <input type="checkbox" name="filters_ids[]" value="0" checked="checked" /><?php echo $masstxt_none_fil; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="filters_ids[]" value="0" /><?php echo $masstxt_none_fil; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($p_filters as $p_filter) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($p_filter['filter_id'], $filters_ids)) { ?>
                    <input type="checkbox" name="filters_ids[]" value="<?php echo $p_filter['filter_id']; ?>" checked="checked" />
                    <?php echo $p_filter['group'].' &gt; '.$p_filter['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="filters_ids[]" value="<?php echo $p_filter['filter_id']; ?>" />
                    <?php echo $p_filter['group'].' &gt; '.$p_filter['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $masstxt_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $masstxt_unselect_all; ?></a>
              <label class="control-label tooltip1"><span data-toggle="tooltip" title="<?php echo $masstxt_unselect_all_to_ignore; ?>"></span></label>
    	  <?php } else { echo $masstxt_p_filters_none; } ?>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_price; ?></strong>
    	  <span class="help"> <?php echo $masstxt_price_help; ?></span>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $price_mmarese; ?>" name="price_mmarese">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $price_mmicse; ?>" name="price_mmicse">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_discount; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  
    	  <div style="float:left;border-right:1px solid #DDDDDD;margin: -7px;padding: 7px;">
    	  <?php echo $masstxt_customer_group; ?> 
    	  <select name="d_cust_group_filter">
    	  <option value="any"<?php if ($d_cust_group_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_all; ?></option>
    	  <?php foreach ($customer_groups as $customer_group) { ?>
    	  <option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group['customer_group_id']==$d_cust_group_filter) { echo ' selected="selected"'; } ?>><?php echo $customer_group['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </div>
    	  
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $d_price_mmarese; ?>" name="d_price_mmarese">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $d_price_mmicse; ?>" name="d_price_mmicse">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_special; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  
    	  <div style="float:left;border-right:1px solid #DDDDDD;margin: -7px;padding: 7px;">
    	  <?php echo $masstxt_customer_group; ?> 
    	  <select name="s_cust_group_filter">
    	  <option value="any"<?php if ($s_cust_group_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_all; ?></option>
    	  <?php foreach ($customer_groups as $customer_group) { ?>
    	  <option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group['customer_group_id']==$s_cust_group_filter) { echo ' selected="selected"'; } ?>><?php echo $customer_group['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </div>
    	  
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $s_price_mmarese; ?>" name="s_price_mmarese">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $s_price_mmicse; ?>" name="s_price_mmicse">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_tax_class; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="tax_class_filter">
    	  <option value="any"<?php if ($tax_class_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="0"<?php if ($tax_class_filter=='0') { echo ' selected="selected"'; } ?>> <?php echo $masstxt_none; ?> </option>
    	  <?php foreach ($tax_classes as $tax_class) { ?>
    	  <option value="<?php echo $tax_class['tax_class_id']; ?>"<?php if ($tax_class['tax_class_id']==$tax_class_filter) { echo ' selected="selected"'; } ?>><?php echo $tax_class['title']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>
    	
    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_quantity; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $stock_mmarese; ?>" name="stock_mmarese">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $stock_mmicse; ?>" name="stock_mmicse">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label></td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_minimum_quantity; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $min_q_mmarese; ?>" name="min_q_mmarese">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input size="10" type="text" value="<?php echo $min_q_mmicse; ?>" name="min_q_mmicse">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_subtract_stock; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="subtract_filter">
    	  <option value="any"<?php if ($subtract_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="1"<?php if ($subtract_filter=='1') { echo ' selected="selected"'; } ?>><?php echo $masstxt_yes; ?></option>
    	  <option value="0"<?php if ($subtract_filter=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no; ?></option>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_out_of_stock_status; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="stock_status_filter">
    	  <option value="any"<?php if ($stock_status_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($stock_statuses as $stock_status) { ?>
    	  <option value="<?php echo $stock_status['stock_status_id']; ?>"<?php if ($stock_status['stock_status_id']==$stock_status_filter) { echo ' selected="selected"'; } ?>><?php echo $stock_status['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_requires_shipping; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="shipping_filter">
    	  <option value="any"<?php if ($shipping_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="1"<?php if ($shipping_filter=='1') { echo ' selected="selected"'; } ?>><?php echo $masstxt_yes; ?></option>
    	  <option value="0"<?php if ($shipping_filter=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no; ?></option>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_date_available; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input class="date" size="14" type="text" value="<?php echo $date_mmarese; ?>" name="date_mmarese" data-date-format="YYYY-MM-DD">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input class="date" size="14" type="text" value="<?php echo $date_mmicse; ?>" name="date_mmicse" data-date-format="YYYY-MM-DD">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_date_added; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input class="datetime" size="14" type="text" value="<?php echo $date_added_mmarese; ?>" name="date_added_mmarese" data-date-format="YYYY-MM-DD HH:mm">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input class="datetime" size="14" type="text" value="<?php echo $date_added_mmicse; ?>" name="date_added_mmicse" data-date-format="YYYY-MM-DD HH:mm">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_date_modified; ?></strong>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_greater_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input class="datetime" size="14" type="text" value="<?php echo $date_modified_mmarese; ?>" name="date_modified_mmarese" data-date-format="YYYY-MM-DD HH:mm">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	  <td class="text-right">
    	  <?php echo $masstxt_less_than_or_equal; ?>
    	  </td>
    	  <td class="text-left">
    	  <input class="datetime" size="14" type="text" value="<?php echo $date_modified_mmicse; ?>" name="date_modified_mmicse" data-date-format="YYYY-MM-DD HH:mm">
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_status; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="prod_status">
    	  <option value="any"<?php if ($prod_status=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="1"<?php if ($prod_status=='1') { echo ' selected="selected"'; } ?>><?php echo $masstxt_enabled; ?></option>
    	  <option value="0"<?php if ($prod_status=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_disabled; ?></option>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_store; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="store_filter">
    	  <option value="any"<?php if ($store_filter=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <option value="0"<?php if ($store_filter=='0') { echo ' selected="selected"'; } ?>><?php echo $masstxt_default; ?></option>
    	  <?php foreach ($stores as $store) { ?>
    	  <option value="<?php echo $store['store_id']; ?>"<?php if ($store['store_id']==$store_filter) { echo ' selected="selected"'; } ?>><?php echo $store['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_attribute; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="filter_attr">
    	  <option value="any"<?php if ($filter_attr=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($all_attributes as $attrib) { ?>
    	  <option value="<?php echo $attrib['attribute_id']; ?>"<?php if ($attrib['attribute_id']==$filter_attr) { echo ' selected="selected"'; } ?>><?php echo $attrib['attribute_group']." > ".$attrib['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_attribute_value; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <textarea name="filter_attr_val" cols="40" rows="2"><?php echo $filter_attr_val; ?></textarea>
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_with_attribute_value_help; ?><br /><br /><?php echo $masstxt_leave_empty_to_ignore; ?>"></span></label>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_this_option; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="filter_opti">
    	  <option value="any"<?php if ($filter_opti=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($all_options as $option) { ?>
    	  <option value="<?php echo $option['option_id']; ?>"<?php if ($option['option_id']==$filter_opti) { echo ' selected="selected"'; } ?>><?php echo $option['name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_with_this_option_value; ?></strong>
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <select name="filter_opti_val">
    	  <option value="any"<?php if ($filter_opti_val=='any') { echo ' selected="selected"'; } ?>><?php echo $masstxt_ignore_this; ?></option>
    	  <?php foreach ($all_optval as $optval) { ?>
    	  <option value="<?php echo $optval['option_value_id']; ?>"<?php if ($optval['option_value_id']==$filter_opti_val) { echo ' selected="selected"'; } ?>><?php echo $optval['o_name']." > ".$optval['ov_name']; ?></option>
    	  <?php } ?>
    	  </select>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <br />
    	  <?php echo $masstxt_max_prod_pag1; ?>
    	  <input size="3" type="text" value="<?php echo $max_prod_pag; ?>" name="max_prod_pag"> 
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_max_prod_pag2; ?>"></span></label>
    	  <br />
    	  <?php echo $masstxt_show_page_of1; ?>
    	  <select name="curent_pag" onchange="this.form.submit()">
    	  <?php for ($pg=1;$pg<=$total_pag;$pg++) { ?>
    	  <option value="<?php echo $pg; ?>"<?php if ($pg==$curent_pag) { echo ' selected="selected"'; } ?>><?php echo $pg; ?></option>
    	  <?php } ?>
    	  </select>
    	  <?php echo $masstxt_show_page_of2; ?><?php echo $total_pag; ?><br /><br />
    	  <input type="submit" value="<?php echo $masstxt_filter_products_button; ?>" name="lista_prod" class="btn btn-primary" style="width:222px; font-weight:bold;">
    	  <br /><br />
    	  <?php echo $total_prod_filtered; ?><?php echo $masstxt_total_prod_res; ?><br /><br />
    	  <span class="counter" style="font-weight:bold;">0</span><?php echo $masstxt_prod_sel_for_upd; ?><br />
    	  <br />
    	  </td>
    	  <td colspan="4" class="text-left">
    	  <div style="max-height:350px; overflow:auto; border-top:1px solid #DDDDDD;">
    	  <table class="list1"> <!-- products filtered table -->
          <thead>
            <tr>
              <td style="padding:4px;background-color:#DDD;" width="1">
              <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" checked="checked" name="sel_desel_all" />
              </td>
              <td style="padding:4px;background-color:#DDD;"><?php echo $masstxt_table_name; ?></td>
              <td style="padding:4px;background-color:#DDD;"><?php echo $masstxt_table_model; ?></td>
              <td style="padding:4px;text-align:right;background-color:#DDD;"><?php echo $masstxt_table_price; ?></td>
              <td style="padding:4px;text-align:right;background-color:#DDD;"><?php echo $masstxt_table_quantity; ?></td>
              <td style="padding:4px;background-color:#DDD;"><?php echo $masstxt_table_status; ?></td>
            </tr>
          </thead>
          <tbody class="products_to_upd">
          <?php if ($arr_lista_prod) { ?>
            <?php foreach ($arr_lista_prod as $product) { ?>
            <tr>
              <td style="padding:4px;"><input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" /></td>
              <td style="padding:4px;"><?php echo $product['name']; ?></td>
              <td style="padding:4px;"><?php echo $product['model']; ?></td>
              <td style="padding:4px;text-align:right;"><?php echo $product['price']; ?></td>
              <td style="padding:4px;text-align:right;"><?php if ($product['quantity'] <= 0) { ?>
                <span style="color: #FF0000;"><?php echo $product['quantity']; ?></span>
                <?php } elseif ($product['quantity'] <= 5) { ?>
                <span style="color: #FFA500;"><?php echo $product['quantity']; ?></span>
                <?php } else { ?>
                <span style="color: #008000;"><?php echo $product['quantity']; ?></span>
                <?php } ?></td>
              <td style="padding:4px;"><?php if ($product['status']==1) { ?>
                <span style="color: #008000;"><?php echo $masstxt_enabled; ?></span>
                <?php } else { ?>
                <span style="color: #FF0000;"><?php echo $masstxt_disabled; ?></span>
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="6"> </td>
            </tr>
            <?php } ?>
          </tbody>
          </table> <!-- products filtered table -->
    	  </div>
    	  </td>
    	</tr>

        </tbody>
        </table> <!-- filters table -->
      </div>
      </div>
    
    </div> <!-- filters div -->
    
    
    
    <div class="panel panel-default"> <!-- updates div -->
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $masstxt_p_options_updates; ?></h3>
      </div>
      
      <div class="panel-body">
      <div class="table-responsive">
    	<table class="table table-bordered table-hover"> <!-- updates table 1 -->
    	<tbody>
    	
    	<tr>
    	  <td style="padding:7px;">
    	  <div class="for_autocomplete"><?php echo $masstxt_load_existing_options; ?></div>
    	  <div class="for_autocomplete"><?php echo $masstxt_name_autocomplete; ?> <input type="text" name="filter_namex" value="<?php echo $filter_namex; ?>" size="16" /></div>
    	  <div class="for_autocomplete"><?php echo $masstxt_model_autocomplete; ?> <input type="text" name="filter_modelx" value="<?php echo $filter_modelx; ?>" size="16" /></div>
    	  <input type="hidden" name="product_id_to_options" value="<?php echo $product_id_to_options; ?>" />
    	  <input type="submit" value="load_product_options" name="load_product_options" style="display:none;" />
    	  </td>
    	</tr>
    	
    	</tbody>
    	</table>
    	
    	<table class="table table-bordered table-hover"> <!-- updates table 2 -->
    	<tbody>
    	
     	<tr>
    	  <td class="tableh1" style="padding:7px;">
    	  <strong><?php echo $masstxt_new_options; ?></strong>
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
            <div class="tab-pane" id="tab-option">
              <div class="row">
                <div class="col-sm-2">
                  <ul class="nav nav-pills nav-stacked" id="option">
                    <?php $option_row = 0; ?>
                    <?php foreach ($product_options as $product_option) { ?>
                    <li><a href="#tab-option<?php echo $option_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-option<?php echo $option_row; ?>\']').parent().remove(); $('#tab-option<?php echo $option_row; ?>').remove(); $('#option a:first').tab('show');"></i> <?php echo $product_option['name']; ?></a></li>
                    <?php $option_row++; ?>
                    <?php } ?>
                    <li>
                      <input type="text" name="option" value="" placeholder="<?php echo $entry_option; ?>" id="input-option" class="form-control" />
                    </li>
                  </ul>
                </div>
                <div class="col-sm-10">
                  <div class="tab-content">
                    <?php $option_row = 0; ?>
                    <?php $option_value_row = 0; ?>
                    <?php foreach ($product_options as $product_option) { ?>
                    <div class="tab-pane" id="tab-option<?php echo $option_row; ?>">
                      <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
                      <input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
                      <input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
                      <input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-required<?php echo $option_row; ?>"><?php echo $entry_required; ?></label>
                        <div class="col-sm-10">
                          <select name="product_option[<?php echo $option_row; ?>][required]" id="input-required<?php echo $option_row; ?>" class="form-control">
                            <?php if ($product_option['required']) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <?php if ($product_option['type'] == 'text') { ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
                        </div>
                      </div>
                      <?php } ?>
                      <?php if ($product_option['type'] == 'textarea') { ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                        <div class="col-sm-10">
                          <textarea name="product_option[<?php echo $option_row; ?>][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control"><?php echo $product_option['value']; ?></textarea>
                        </div>
                      </div>
                      <?php } ?>
                      <?php if ($product_option['type'] == 'file') { ?>
                      <div class="form-group" style="display: none;">
                        <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
                        </div>
                      </div>
                      <?php } ?>
                      <?php if ($product_option['type'] == 'date') { ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                        <div class="col-sm-3">
                          <div class="input-group date">
                            <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value<?php echo $option_row; ?>" class="form-control" />
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                            </span></div>
                        </div>
                      </div>
                      <?php } ?>
                      <?php if ($product_option['type'] == 'time') { ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                        <div class="col-sm-10">
                          <div class="input-group time">
                            <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                            </span></div>
                        </div>
                      </div>
                      <?php } ?>
                      <?php if ($product_option['type'] == 'datetime') { ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                        <div class="col-sm-10">
                          <div class="input-group datetime">
                            <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                            </span></div>
                        </div>
                      </div>
                      <?php } ?>
                      <?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
                      <div class="table-responsive">
                        <table id="option-value<?php echo $option_row; ?>" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <td class="text-left"><?php echo $entry_option_value; ?></td>
                              <td class="text-right"><?php echo $entry_quantity; ?></td>
                              <td class="text-left"><?php echo $entry_subtract; ?></td>
                              <td class="text-right"><?php echo $entry_price; ?></td>
                              <td class="text-right"><?php echo $entry_option_points; ?></td>
                              <td class="text-right"><?php echo $entry_weight; ?></td>
                              <td></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
                            <tr id="option-value-row<?php echo $option_value_row; ?>">
                              <td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]" class="form-control">
                                  <?php if (isset($option_values[$product_option['option_id']])) { ?>
                                  <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                                  <?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
                                  <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
                                  <?php } else { ?>
                                  <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                                  <?php } ?>
                                  <?php } ?>
                                  <?php } ?>
                                </select>
                                <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
                              <td class="text-right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                              <td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" class="form-control">
                                  <?php if ($product_option_value['subtract']) { ?>
                                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                  <option value="0"><?php echo $text_no; ?></option>
                                  <?php } else { ?>
                                  <option value="1"><?php echo $text_yes; ?></option>
                                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                  <?php } ?>
                                </select></td>
                              <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]" class="form-control">
                                  <?php if ($product_option_value['price_prefix'] == '+') { ?>
                                  <option value="+" selected="selected">+</option>
                                  <?php } else { ?>
                                  <option value="+">+</option>
                                  <?php } ?>
                                  <?php if ($product_option_value['price_prefix'] == '-') { ?>
                                  <option value="-" selected="selected">-</option>
                                  <?php } else { ?>
                                  <option value="-">-</option>
                                  <?php } ?>
                                </select>
                                <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                              <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]" class="form-control">
                                  <?php if ($product_option_value['points_prefix'] == '+') { ?>
                                  <option value="+" selected="selected">+</option>
                                  <?php } else { ?>
                                  <option value="+">+</option>
                                  <?php } ?>
                                  <?php if ($product_option_value['points_prefix'] == '-') { ?>
                                  <option value="-" selected="selected">-</option>
                                  <?php } else { ?>
                                  <option value="-">-</option>
                                  <?php } ?>
                                </select>
                                <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>
                              <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]" class="form-control">
                                  <?php if ($product_option_value['weight_prefix'] == '+') { ?>
                                  <option value="+" selected="selected">+</option>
                                  <?php } else { ?>
                                  <option value="+">+</option>
                                  <?php } ?>
                                  <?php if ($product_option_value['weight_prefix'] == '-') { ?>
                                  <option value="-" selected="selected">-</option>
                                  <?php } else { ?>
                                  <option value="-">-</option>
                                  <?php } ?>
                                </select>
                                <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>
                              <td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                            </tr>
                            <?php $option_value_row++; ?>
                            <?php } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="6"></td>
                              <td class="text-left"><button type="button" onclick="addOptionValue('<?php echo $option_row; ?>');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                      <select id="option-values<?php echo $option_row; ?>" style="display: none;">
                        <?php if (isset($option_values[$product_option['option_id']])) { ?>
                        <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                        <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                      <?php } ?>
                    </div>
                    <?php $option_row++; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
    	  </td>
    	</tr>

    	</tbody>
    	</table>
    	
    	<table class="table table-bordered table-hover"> <!-- updates table 3 -->
    	<tbody>

    	<tr>
    	  <td class="text-left tableh1">
    	  <?php echo $masstxt_options_update_mode; ?>
    	</tr>

    	<tr>
    	  <td class="text-left radio1">
    	  <input type="radio"<?php if ($opt_upd_mode=='o_upd_add') { echo ' checked="checked"'; } ?> value="o_upd_add" name="opt_upd_mode" id="o_upd_add">
    	  <label for="o_upd_add"> <?php echo $masstxt_upd_mode_o_upd_add; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($opt_upd_mode=='o_upd') { echo ' checked="checked"'; } ?> value="o_upd" name="opt_upd_mode" id="o_upd">
    	  <label for="o_upd"> <?php echo $masstxt_upd_mode_o_upd; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($opt_upd_mode=='o_add') { echo ' checked="checked"'; } ?> value="o_add" name="opt_upd_mode" id="o_add">
    	  <label for="o_add"> <?php echo $masstxt_upd_mode_o_add; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($opt_upd_mode=='o_del_add') { echo ' checked="checked"'; } ?> value="o_del_add" name="opt_upd_mode" id="o_del_add">
    	  <label for="o_del_add"> <?php echo $masstxt_upd_mode_o_del_add; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($opt_upd_mode=='o_del_opt_and_val') { echo ' checked="checked"'; } ?> value="o_del_opt_and_val" name="opt_upd_mode" id="o_del_opt_and_val">
    	  <label for="o_del_opt_and_val"> <?php echo $masstxt_upd_mode_o_del_opt_and_val; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($opt_upd_mode=='o_del_val') { echo ' checked="checked"'; } ?> value="o_del_val" name="opt_upd_mode" id="o_del_val">
    	  <label for="o_del_val"> <?php echo $masstxt_upd_mode_o_del_val; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($opt_upd_mode=='o_del') { echo ' checked="checked"'; } ?> value="o_del" name="opt_upd_mode" id="o_del">
    	  <label for="o_del"> <?php echo $masstxt_upd_mode_o_del; ?></label>
    	  <span style="color:#666666;font-size:11px;">&nbsp; <?php echo $masstxt_upd_mode_o_del_help; ?></span>
    	  </td>
    	</tr>

    	</tbody>
    	</table>
    	
    	<table class="table table-bordered table-hover"> <!-- updates table 4 -->
    	<tbody>

    	<tr>
    	  <td class="text-left tableh1">
    	  <?php echo $masstxt_options_values_update_mode; ?>
    	</tr>
    	
    	<tr>
    	  <td class="text-left radio1">
    	  <input type="radio"<?php if ($val_upd_mode=='v_rep_add') { echo ' checked="checked"'; } ?> value="v_rep_add" name="val_upd_mode" id="v_rep_add">
    	  <label for="v_rep_add"> <?php echo $masstxt_upd_mode_v_rep_add; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($val_upd_mode=='v_rep') { echo ' checked="checked"'; } ?> value="v_rep" name="val_upd_mode" id="v_rep">
    	  <label for="v_rep"> <?php echo $masstxt_upd_mode_v_rep; ?></label>
    	  <br />
    	  </td>
    	</tr>

    	</tbody>
    	</table>
    	
    	<table class="table table-bordered table-hover"> <!-- updates table 5 -->
    	<tbody>

    	<tr>
    	  <td class="text-left">
    	  
    	  <table class="table_val_upd_m1">
    	  <tbody>
    	  
    	  <tr>
    	  <td><?php echo $masstxt_options_quantity_update_mode; ?></td>
    	  <td><select name="qty_upd_mode">
    	  <option value="re"<?php if ($qty_upd_mode=='re') { echo ' selected="selected"'; } ?>><?php echo $masstxt_replacement; ?></option>
    	  <option value="mu"<?php if ($qty_upd_mode=='mu') { echo ' selected="selected"'; } ?>><?php echo $masstxt_multiplication; ?></option>
    	  <option value="ad"<?php if ($qty_upd_mode=='ad') { echo ' selected="selected"'; } ?>><?php echo $masstxt_addition; ?></option>
    	  <option value="su"<?php if ($qty_upd_mode=='su') { echo ' selected="selected"'; } ?>><?php echo $masstxt_subtraction; ?></option>
    	  <option value="no"<?php if ($qty_upd_mode=='no') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no_update; ?></option>
    	  </select><label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_example1; ?>"></span></label></td>
    	  </tr>
    	  
    	  <tr>
    	  <td><?php echo $masstxt_options_price_update_mode; ?></td>
    	  <td><select name="price_upd_mode">
    	  <option value="re"<?php if ($price_upd_mode=='re') { echo ' selected="selected"'; } ?>><?php echo $masstxt_replacement; ?></option>
    	  <option value="mu"<?php if ($price_upd_mode=='mu') { echo ' selected="selected"'; } ?>><?php echo $masstxt_multiplication; ?></option>
    	  <option value="ad"<?php if ($price_upd_mode=='ad') { echo ' selected="selected"'; } ?>><?php echo $masstxt_addition; ?></option>
    	  <option value="su"<?php if ($price_upd_mode=='su') { echo ' selected="selected"'; } ?>><?php echo $masstxt_subtraction; ?></option>
    	  <option value="no"<?php if ($price_upd_mode=='no') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no_update; ?></option>
    	  </select><label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_example2; ?>"></span></label></td>
    	  </tr>
    	  
    	  <tr>
    	  <td><?php echo $masstxt_options_points_update_mode; ?></td>
    	  <td><select name="points_upd_mode">
    	  <option value="re"<?php if ($points_upd_mode=='re') { echo ' selected="selected"'; } ?>><?php echo $masstxt_replacement; ?></option>
    	  <option value="mu"<?php if ($points_upd_mode=='mu') { echo ' selected="selected"'; } ?>><?php echo $masstxt_multiplication; ?></option>
    	  <option value="ad"<?php if ($points_upd_mode=='ad') { echo ' selected="selected"'; } ?>><?php echo $masstxt_addition; ?></option>
    	  <option value="su"<?php if ($points_upd_mode=='su') { echo ' selected="selected"'; } ?>><?php echo $masstxt_subtraction; ?></option>
    	  <option value="no"<?php if ($points_upd_mode=='no') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no_update; ?></option>
    	  </select><label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_example3; ?>"></span></label></td>
    	  </tr>
    	  
    	  <tr>
    	  <td><?php echo $masstxt_options_wgt_update_mode; ?></td>
    	  <td><select name="wgt_upd_mode">
    	  <option value="re"<?php if ($wgt_upd_mode=='re') { echo ' selected="selected"'; } ?>><?php echo $masstxt_replacement; ?></option>
    	  <option value="mu"<?php if ($wgt_upd_mode=='mu') { echo ' selected="selected"'; } ?>><?php echo $masstxt_multiplication; ?></option>
    	  <option value="ad"<?php if ($wgt_upd_mode=='ad') { echo ' selected="selected"'; } ?>><?php echo $masstxt_addition; ?></option>
    	  <option value="su"<?php if ($wgt_upd_mode=='su') { echo ' selected="selected"'; } ?>><?php echo $masstxt_subtraction; ?></option>
    	  <option value="no"<?php if ($wgt_upd_mode=='no') { echo ' selected="selected"'; } ?>><?php echo $masstxt_no_update; ?></option>
    	  </select><label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_example4; ?>"></span></label></td>
    	  </tr>
    	  
    	  </tbody>
    	  </table>
    	  </td>
    	</tr>

    	</tbody>
    	</table>
    	
    	<table class="table table-bordered table-hover"> <!-- updates table 6 -->
    	<tbody>

    	<tr>
    	  <td colspan="2" class="text-center" style="color:#f24545;">
    	  <span class="counter" style="font-weight:bold;">0</span>
    	  <?php echo $masstxt_mass_update_button_top1; ?>
    	  <?php echo $curent_pag; ?>
    	  <?php echo $masstxt_mass_update_button_top2; ?>
    	  <?php echo $total_pag; ?>
    	  <?php echo $masstxt_mass_update_button_top3; ?>
    	  <label class="control-label"><span data-toggle="tooltip" title="<?php echo $masstxt_mass_update_button_help; ?>"></span></label>
    	  <br />
    	  <input type="submit" value="<?php echo $masstxt_mass_update_button; ?>" name="mass_update"  class="btn btn-danger" style="width:222px; font-weight:bold;">
    	  <br />
    	  </td>
    	</tr>

    	</tbody>
    	</table>
      </div>
      </div>

    </div> <!-- updates div -->
    
    <div style="width:100%;text-align:right">
    <a href="http://opencart-market.com" target="_blank">www.opencart-market.com</a>
    </div>    
    
    </form>
    
  </div> <!-- continut -->

  

  <script type="text/javascript"><!--	
var option_row = <?php echo $option_row; ?>;

$('input[name=\'option\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item['category'],
						label: item['name'],
						value: item['option_id'],
						type: item['type'],
						option_value: item['option_value']
					}
				}));
			}
		});
	},
	'select': function(item) {
		html  = '<div class="tab-pane" id="tab-option' + option_row + '">';
		html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + item['label'] + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + item['value'] + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + item['type'] + '" />';
		
		html += '	<div class="form-group">';
		html += '	  <label class="col-sm-2 control-label" for="input-required' + option_row + '"><?php echo $entry_required; ?></label>';
		html += '	  <div class="col-sm-10"><select name="product_option[' + option_row + '][required]" id="input-required' + option_row + '" class="form-control">';
		html += '	      <option value="1"><?php echo $text_yes; ?></option>';
		html += '	      <option value="0"><?php echo $text_no; ?></option>';
		html += '	  </select></div>';
		html += '	</div>';
		
		if (item['type'] == 'text') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
			html += '	</div>';
		}
		
		if (item['type'] == 'textarea') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><textarea name="product_option[' + option_row + '][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control"></textarea></div>';
			html += '	</div>';			
		}
		 
		if (item['type'] == 'file') {
			html += '	<div class="form-group" style="display: none;">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
			html += '	</div>';
		}
						
		if (item['type'] == 'date') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-3"><div class="input-group date"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}
		
		if (item['type'] == 'time') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><div class="input-group time"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}
				
		if (item['type'] == 'datetime') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><div class="input-group datetime"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}
			
		if (item['type'] == 'select' || item['type'] == 'radio' || item['type'] == 'checkbox' || item['type'] == 'image') {
			html += '<div class="table-responsive">';
			html += '  <table id="option-value' + option_row + '" class="table table-striped table-bordered table-hover">';
			html += '  	 <thead>'; 
			html += '      <tr>';
			html += '        <td class="text-left"><?php echo $entry_option_value; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_quantity; ?></td>';
			html += '        <td class="text-left"><?php echo $entry_subtract; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_price; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_option_points; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_weight; ?></td>';
			html += '        <td></td>';
			html += '      </tr>';
			html += '  	 </thead>';
			html += '  	 <tbody>';
			html += '    </tbody>';
			html += '    <tfoot>';
			html += '      <tr>';
			html += '        <td colspan="6"></td>';
			html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + option_row + ');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
			html += '      </tr>';
			html += '    </tfoot>';
			html += '  </table>';
			html += '</div>';
			
            html += '  <select id="option-values' + option_row + '" style="display: none;">';
			
            for (i = 0; i < item['option_value'].length; i++) {
				html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
            }

            html += '  </select>';	
			html += '</div>';	
		}
		
		$('#tab-option .tab-content').append(html);
			
		$('#option > li:last-child').before('<li><a href="#tab-option' + option_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-option' + option_row + '\\\']\').parent().remove(); $(\'#tab-option' + option_row + '\').remove(); $(\'#option a:first\').tab(\'show\')"></i> ' + item['label'] + '</li>');
		
		$('#option a[href=\'#tab-option' + option_row + '\']').tab('show');
		
		$('.date').datetimepicker({
			pickTime: false
		});
		
		$('.time').datetimepicker({
			pickDate: false
		});
		
		$('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});
				
		option_row++;
	}	
});
//--></script> 
  <script type="text/javascript"><!--		
var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_row) {	
	html  = '<tr id="option-value-row' + option_value_row + '">';
	html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" class="form-control">';
	html += $('#option-values' + option_row).html();
	html += '  </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
	html += '  <td class="text-right"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>'; 
	html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]" class="form-control">';
	html += '    <option value="1"><?php echo $text_yes; ?></option>';
	html += '    <option value="0"><?php echo $text_no; ?></option>';
	html += '  </select></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>';	
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" rel="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#option-value' + option_row + ' tbody').append(html);
        $('[rel=tooltip]').tooltip();
        
	option_value_row++;
}
//--></script> 

  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script> 

  <script type="text/javascript"><!--
$('#language a:first').tab('show');
$('#option a:first').tab('show');
//--></script>


<script type="text/javascript"><!--
$('input[name=\'selected[]\']').click(function(){
var len = $('.products_to_upd input:checked').length;
$('.counter').text(len);
});

$('input[name=\'sel_desel_all\']').click(function(){
var len = $('.products_to_upd input:checked').length;
$('.counter').text(len);
});

var len = $('.products_to_upd input:checked').length;
$('.counter').text(len);
//--></script>


<script type="text/javascript"><!--
$('input[name=\'filter_namex\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id'],
						altax: item['model']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_namex\']').val(item['label']);
		$('input[name=\'filter_modelx\']').val(item['altax']);
		$('input[name=\'product_id_to_options\']').val(item['value']);
		$('input[name=\'load_product_options\']').click();
	}
});

$('input[name=\'filter_modelx\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id'],
						altax: item['name']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_modelx\']').val(item['label']);
		$('input[name=\'filter_namex\']').val(item['altax']);
		$('input[name=\'product_id_to_options\']').val(item['value']);
		$('input[name=\'load_product_options\']').click();
	}
});
//--></script>


</div> <!-- id content -->
<?php echo $footer; ?>
