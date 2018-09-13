<?php 
/**
 * Google Analytics Ecommerce Tracking module for Opencart by Extensa Web Development
 *
 * Copyright © 2013 Extensa Web Development Ltd. All Rights Reserved.
 * This file may not be redistributed in whole or significant part.
 * This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author 		Extensa Web Development Ltd. (www.extensadev.com)
 * @copyright	Copyright (c) 2013, Extensa Web Development Ltd.
 * @package 	Google Analytics Ecommerce Tracking module
 * @link		http://www.opencart.com/index.php?route=extension/extension/info&extension_id=11242
 */
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" onclick="$('#form').submit();" form="form-bestseller" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
	  </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
		<div class="panel-body">
		  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $entry_sku; ?></label>
				<div class="col-sm-10">
				  <select name="ecommerce_tracking_sku" class="form-control">
					<?php foreach ($skus as $sku) { ?>
					<?php if ($sku['id'] == $ecommerce_tracking_sku) { ?>
					<option value="<?php echo $sku['id']; ?>" selected="selected"><?php echo $sku['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $sku['id']; ?>"><?php echo $sku['name']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-ecommerce-tracking-convert-currency"><?php echo $entry_convert_currency; ?></label>
				<div class="col-sm-10">
				  <select id="convert_currency" name="ecommerce_tracking_convert_currency" class="form-control">
					<?php if ($ecommerce_tracking_convert_currency) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				  </select>
				</div>
			</div>
			<div class="form-group" id="currency">
				<label class="col-sm-2 control-label" for="input-ecommerce-tracking-currency"><?php echo $entry_currency; ?></label>
				<div class="col-sm-10">
				  <select id="currency_select" name="ecommerce_tracking_currency" class="form-control">
					<?php foreach ($currencies as $currency) { ?>
						<?php if ($currency['code'] == $ecommerce_tracking_currency) { ?>
							<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
						<?php } ?>
					<?php } ?>
				  </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-ecommerce-tracking-tax"><?php echo $entry_product_price; ?></label>
				<div class="col-sm-10">
					<select name="ecommerce_tracking_tax" class="form-control">
						<?php if ($ecommerce_tracking_tax) { ?>
						<option value="1" selected="selected"><?php echo $text_incl_tax; ?></option>
						<option value="0"><?php echo $text_excl_tax; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_incl_tax; ?></option>
						<option value="0" selected="selected"><?php echo $text_excl_tax; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">
					<?php echo $store_name; ?>
					<br />
					<?php echo $entry_google_analytics; ?>
				</label>
				<div class="col-sm-10">
				  <textarea name="config_google_analytics[0]" rows="10" placeholder="" class="form-control"><?php echo $config_google_analytics; ?></textarea>
				</div>
			</div>

			<?php foreach ($stores as $store) { ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">
						<?php echo $store['name']; ?></b>
						<br />
						<span data-toggle="tooltip" data-html="true" title="<?php echo $help_google_analytics; ?>"><?php echo $entry_google_analytics; ?></span>
					</label>
					<div class="col-sm-10">
					  <textarea name="config_google_analytics[<?php echo $store['store_id']; ?>]" rows="10" placeholder="" class="form-control"><?php echo $store['google_analytics']; ?></textarea>
					</div>
				</div>
			<?php } ?>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-ecommerce-tracking-status"><?php echo $entry_status; ?></label>
				<div class="col-sm-10">
				  <select name="ecommerce_tracking_status" class="form-control">
					<?php if ($ecommerce_tracking_status) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				  </select>
				</div>
			</div>
			<script type="text/javascript">
				$(function() {
					$('#convert_currency').change(function(){
						if($('#convert_currency').val() == '1') {
							$('#currency').show();
						} else {
							$('#currency').hide();
						} 
					});

					$('#convert_currency').trigger('change');
				});
			</script>
		  </form>
		</div>
    </div>
  </div>
</div>
<?php echo $footer; ?>