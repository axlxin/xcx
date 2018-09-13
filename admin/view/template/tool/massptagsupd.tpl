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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $masstxt_p_tags_updates; ?></h3>
      </div>
      
      <div class="panel-body">
      <div class="table-responsive">
    	<table class="table table-bordered table-hover"> <!-- updates table -->
    	<tbody>
    	
    	<tr>
    	  <td class="text-left" style="width:182px;">
    	  <strong><?php echo $masstxt_new_tags; ?></strong>
    	  <br />
    	  <span class="help"><?php echo $masstxt_new_tags_help; ?></span>
    	  </td>
    	  <td class="text-left">
    	  
    	  <?php foreach ($languages as $language) { ?>
    	  <input size="44" type="text" value="<?php echo $tags_upd[$language['language_id']]; ?>" name="tags_upd[<?php echo $language['language_id']; ?>]">
    	  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: middle;" /><br />
    	  <?php } ?></td>
    	  
    	  </td>
    	</tr>

    	<tr>
    	  <td class="text-left">
    	  <strong><?php echo $masstxt_update_mode; ?></strong>
    	  </td>
    	  <td class="radio1">
    	  <input type="radio"<?php if ($upd_mode=='ad') { echo ' checked="checked"'; } ?> value="ad" name="upd_mode" id="rg1">
    	  <label for="rg1"> <?php echo $masstxt_upd_mode_ad; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($upd_mode=='re') { echo ' checked="checked"'; } ?> value="re" name="upd_mode" id="rg4">
    	  <label for="rg4"> <?php echo $masstxt_upd_mode_re; ?></label>
    	  <br />
    	  <input type="radio"<?php if ($upd_mode=='de') { echo ' checked="checked"'; } ?> value="de" name="upd_mode" id="rg5">
    	  <label for="rg5"> <?php echo $masstxt_upd_mode_de; ?></label>
    	  </td>
    	</tr>

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
    	</table> <!-- updates table -->
      </div>
      </div>

    </div> <!-- updates div -->
    
    <div style="width:100%;text-align:right">
    <a href="http://opencart-market.com" target="_blank">www.opencart-market.com</a>
    </div>    
    
    </form>
    
  </div> <!-- continut -->

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

</div> <!-- id content -->
<?php echo $footer; ?>
