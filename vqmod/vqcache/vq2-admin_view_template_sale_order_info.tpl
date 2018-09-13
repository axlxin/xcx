<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $link_pdfinv_invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_pdfinv_invoice; ?>" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i></a> <a href="<?php echo $link_pdfinv_packing; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_pdfinv_packing; ?>" class="btn btn-warning"><i class="fa fa-file-text-o"></i></a> <?php if($pdf_invoice_manual_backup) { ?><a href="<?php echo $link_pdfinv_backup; ?>" data-toggle="tooltip" title="<?php echo $button_invoice_backup; ?>" class="btn btn-warning"><i class="fa fa-toggle-down"></i></a><?php } ?> <a href="<?php echo $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a href="<?php echo $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-order" data-toggle="tab"><?php echo $tab_order; ?></a></li>
          <li><a href="#tab-payment" data-toggle="tab"><?php echo $tab_payment; ?></a></li>
          <?php if ($shipping_method) { ?>
          <li><a href="#tab-shipping" data-toggle="tab"><?php echo $tab_shipping; ?></a></li>
          <?php } ?>
          <li><a href="#tab-product" data-toggle="tab"><?php echo $tab_product; ?></a></li>
          <li><a href="#tab-history" data-toggle="tab"><?php echo $tab_history; ?></a></li>
          <?php if ($payment_action) { ?>
          <li><a href="#tab-action" data-toggle="tab"><?php echo $tab_action; ?></a></li>
          <?php } ?>
          <?php if ($frauds) { ?>
          <?php foreach ($frauds as $fraud) { ?>
          <li><a href="#tab-<?php echo $fraud['code']; ?>" data-toggle="tab"><?php echo $fraud['title']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-order">
            <table class="table table-bordered">
              <tr>
                <td><?php echo $text_order_id; ?></td>
                <td>#<?php echo $order_id; ?></td>
              </tr>
              <tr>
                <td><?php echo $text_invoice_no; ?></td>
                
				<td>
					<?php if ($pdf_invoice_manual_inv_no) { ?>
					<div id="manual_inv_no" style="display:none">
						<input type="text" name="manual_inv_prefix" value="<?php echo $invoice_prefix; ?>" size="10"/>
						<input type="text" name="manual_inv_number" value="<?php echo $invoice_number; ?>" size="6"/>
						<?php if($pdfinv_ocv2) { ?>
							<button id="invoice-manual-save" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> <?php echo $text_manual_invoice_save; ?></button>
						<?php } else { ?>
							[ <a id="invoice-manual-save"><?php echo $text_manual_invoice_save; ?></a> ]
						<?php } ?>
					</div>
					<?php if ($invoice_no) { ?>
						<?php if($pdfinv_ocv2) { ?>
							<span id="invoice"><?php echo $invoice_no; ?> <button id="invoice-manual-edit" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> <?php echo $text_manual_invoice_edit; ?></button></span>
						<?php } else { ?>
							<span id="invoice"><?php echo $invoice_no; ?> [ <a id="invoice-manual-edit"><?php echo $text_manual_invoice_edit; ?></a> ]</span>
						<?php } ?>
					  <?php } else { ?>
						<?php if($pdfinv_ocv2) { ?>
							<span id="invoice"><button id="invoice-manual-new" class="btn btn-success btn-xs"><i class="fa fa-cog"></i> <?php echo $button_generate; ?></button></span>
					  <?php } else { ?>
							<span id="invoice"><b>[</b> <a id="invoice-manual-new"><?php echo $text_generate; ?></a> <b>]</b></span>
					  <?php } ?>
					  <?php } ?>
  					<?php } else { ?>
						<?php if ($invoice_no) { ?>
						 <?php echo $invoice_no; ?>
					  <?php } else if($pdfinv_ocv2) { ?>
						<button id="button-invoice" class="btn btn-success btn-xs"><i class="fa fa-cog"></i> <?php echo $button_generate; ?></button>
					  <?php } else { ?>
						 <span id="invoice"><b>[</b> <a id="invoice-generate"><?php echo $text_generate; ?></a> <b>]</b></span>
					  <?php } ?>
					<?php } ?></td>
			




              </tr>
              <tr>
                <td><?php echo $text_store_name; ?></td>
                <td><?php echo $store_name; ?></td>
              </tr>
              <tr>
                <td><?php echo $text_store_url; ?></td>
                <td><a href="<?php echo $store_url; ?>" target="_blank"><?php echo $store_url; ?></a></td>
              </tr>
              <?php if ($customer) { ?>
              <tr>
                <td><?php echo $text_customer; ?></td>
                <td><a href="<?php echo $customer; ?>" target="_blank"><?php echo $firstname; ?> <?php echo $lastname; ?></a></td>
              </tr>
              <?php } else { ?>
              <tr>
                <td><?php echo $text_customer; ?></td>
                <td><?php echo $firstname; ?> <?php echo $lastname; ?></td>
              </tr>
              <?php } ?>
              <?php if ($customer_group) { ?>
              <tr>
                <td><?php echo $text_customer_group; ?></td>
                <td><?php echo $customer_group; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_email; ?></td>
                <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
              </tr>
              <tr>
                <td><?php echo $text_telephone; ?></td>
                <td><?php echo $telephone; ?></td>
              </tr>
              <?php if ($fax) { ?>
              <tr>
                <td><?php echo $text_fax; ?></td>
                <td><?php echo $fax; ?></td>
              </tr>
              <?php } ?>
              <?php foreach ($account_custom_fields as $custom_field) { ?>
              <tr>
                <td><?php echo $custom_field['name']; ?>:</td>
                <td><?php echo $custom_field['value']; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_total; ?></td>
                <td><?php echo $total; ?></td>
              </tr>
              <?php if ($customer && $reward) { ?>
              <tr>
                <td><?php echo $text_reward; ?></td>
                <td><?php echo $reward; ?>
                  <?php if (!$reward_total) { ?>
                  <button id="button-reward-add" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> <?php echo $button_reward_add; ?></button>
                  <?php } else { ?>
                  <button id="button-reward-remove" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i> <?php echo $button_reward_remove; ?></button>
                  <?php } ?></td>
              </tr>
              <?php } ?>
              <?php if ($order_status) { ?>
              <tr>
                <td><?php echo $text_order_status; ?></td>
                <td id="order-status"><?php echo $order_status; ?></td>
              </tr>
              <?php } ?>
              <?php if ($comment) { ?>
              <tr>
                <td><?php echo $text_comment; ?></td>
                <td><?php echo $comment; ?></td>
              </tr>
              <?php } ?>
              <?php if ($affiliate) { ?>
              <tr>
                <td><?php echo $text_affiliate; ?></td>
                <td><a href="<?php echo $affiliate; ?>"><?php echo $affiliate_firstname; ?> <?php echo $affiliate_lastname; ?></a></td>
              </tr>
              <tr>
                <td><?php echo $text_commission; ?></td>
                <td><?php echo $commission; ?>
                  <?php if (!$commission_total) { ?>
                  <button id="button-commission-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> <?php echo $button_commission_add; ?></button>
                  <?php } else { ?>
                  <button id="button-commission-remove" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i> <?php echo $button_commission_remove; ?></button>
                  <?php } ?></td>
              </tr>
              <?php } ?>
              <?php if ($ip) { ?>
              <tr>
                <td><?php echo $text_ip; ?></td>
                <td><?php echo $ip; ?></td>
              </tr>
              <?php } ?>
              <?php if ($forwarded_ip) { ?>
              <tr>
                <td><?php echo $text_forwarded_ip; ?></td>
                <td><?php echo $forwarded_ip; ?></td>
              </tr>
              <?php } ?>
              <?php if ($user_agent) { ?>
              <tr>
                <td><?php echo $text_user_agent; ?></td>
                <td><?php echo $user_agent; ?></td>
              </tr>
              <?php } ?>
              <?php if ($accept_language) { ?>
              <tr>
                <td><?php echo $text_accept_language; ?></td>
                <td><?php echo $accept_language; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_date_added; ?></td>
                <td><?php echo $date_added; ?></td>
              </tr>
              <tr>
                <td><?php echo $text_date_modified; ?></td>
                <td><?php echo $date_modified; ?></td>
              </tr>

				<tr>
					<td><?php echo $text_pdf_date_invoice; ?>:</td>
					<td>
						<span id="pdf_invoice_date_edit" style="display:none"><input type="text" id="pdf_date_input" value="<?php echo $date_invoice; ?>" /> [ <a id="pdf_date_save" href="javascript:pdf_invoice_date();"><?php echo $text_manual_invoice_save; ?></a> ]</span>
						<?php if($pdfinv_ocv2) { ?>
							<span id="pdf_invoice_date"><span title="<?php echo $text_pdf_edit; ?>"><?php echo $date_invoice; ?></span> <button onclick="pdf_invoice_date('now');" class="btn btn-success btn-xs"><i class="fa fa-calendar"></i> <?php echo $text_pdf_now; ?></button></span>
						<?php } else { ?>
							<span id="pdf_invoice_date"><span title="<?php echo $text_pdf_edit; ?>"><?php echo $date_invoice; ?></span> [ <a href="javascript:pdf_invoice_date('now');"><?php echo $text_pdf_now; ?></a> ]</span>
						<?php } ?>
						<script type="text/javascript">
							function pdf_invoice_date(date){
								if(date){
									$('#pdf_invoice_date span').fadeOut('fast').load('index.php?route=sale/order/pdf_invoice_date&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&date='+date).fadeIn();
								}
								else {
									$('#pdf_invoice_date_edit').fadeOut('fast', function(){
										$('#pdf_invoice_date span').load('index.php?route=sale/order/pdf_invoice_date&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&date='+$('#pdf_date_input').val(), function(){
											$('#pdf_invoice_date').fadeIn();
										});
									});
								}
							}
							$('body').on('click', '#pdf_invoice_date span', function() {
								$('#pdf_invoice_date_edit').show();
								$('#pdf_invoice_date').hide();
							});
						</script>
					</td>
				</tr>
			
            </table>
          </div>
          <div class="tab-pane" id="tab-payment">
            <table class="table table-bordered">
              <tr>
                <td><?php echo $text_firstname; ?></td>
                <td><?php echo $payment_firstname; ?></td>
              </tr>
              <tr>
                <td><?php echo $text_lastname; ?></td>
                <td><?php echo $payment_lastname; ?></td>
              </tr>
              <?php if ($payment_company) { ?>
              <tr>
                <td><?php echo $text_company; ?></td>
                <td><?php echo $payment_company; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_address_1; ?></td>
                <td><?php echo $payment_address_1; ?></td>
              </tr>
              <?php if ($payment_address_2) { ?>
              <tr>
                <td><?php echo $text_address_2; ?></td>
                <td><?php echo $payment_address_2; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_city; ?></td>
                <td><?php echo $payment_city; ?></td>
              </tr>
              <?php if ($payment_postcode) { ?>
              <tr>
                <td><?php echo $text_postcode; ?></td>
                <td><?php echo $payment_postcode; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_zone; ?></td>
                <td><?php echo $payment_zone; ?></td>
              </tr>
              <?php if ($payment_zone_code) { ?>
              <tr>
                <td><?php echo $text_zone_code; ?></td>
                <td><?php echo $payment_zone_code; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_country; ?></td>
                <td><?php echo $payment_country; ?></td>
              </tr>
              <?php foreach ($payment_custom_fields as $custom_field) { ?>
              <tr data-sort="<?php echo $custom_field['sort_order'] + 1; ?>">
                <td><?php echo $custom_field['name']; ?>:</td>
                <td><?php echo $custom_field['value']; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_payment_method; ?></td>
                <td><?php echo $payment_method; ?></td>
              </tr>
            </table>
          </div>
          <?php if ($shipping_method) { ?>
          <div class="tab-pane" id="tab-shipping">
            <table class="table table-bordered">
              <tr>
                <td><?php echo $text_firstname; ?></td>
                <td><?php echo $shipping_firstname; ?></td>
              </tr>
              <tr>
                <td><?php echo $text_lastname; ?></td>
                <td><?php echo $shipping_lastname; ?></td>
              </tr>
              <?php if ($shipping_company) { ?>
              <tr>
                <td><?php echo $text_company; ?></td>
                <td><?php echo $shipping_company; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_address_1; ?></td>
                <td><?php echo $shipping_address_1; ?></td>
              </tr>
              <?php if ($shipping_address_2) { ?>
              <tr>
                <td><?php echo $text_address_2; ?></td>
                <td><?php echo $shipping_address_2; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_city; ?></td>
                <td><?php echo $shipping_city; ?></td>
              </tr>
              <?php if ($shipping_postcode) { ?>
              <tr>
                <td><?php echo $text_postcode; ?></td>
                <td><?php echo $shipping_postcode; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_zone; ?></td>
                <td><?php echo $shipping_zone; ?></td>
              </tr>
              <?php if ($shipping_zone_code) { ?>
              <tr>
                <td><?php echo $text_zone_code; ?></td>
                <td><?php echo $shipping_zone_code; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $text_country; ?></td>
                <td><?php echo $shipping_country; ?></td>
              </tr>
              <?php foreach ($shipping_custom_fields as $custom_field) { ?>
              <tr data-sort="<?php echo $custom_field['sort_order'] + 1; ?>">
                <td><?php echo $custom_field['name']; ?>:</td>
                <td><?php echo $custom_field['value']; ?></td>
              </tr>
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <tr>
                <td><?php echo $text_shipping_method; ?></td>
                <td><?php echo $shipping_method; ?></td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <?php } ?>
          <div class="tab-pane" id="tab-product">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $column_product; ?></td>
                  <td class="text-left"><?php echo $column_model; ?></td>
                  <td class="text-right"><?php echo $column_quantity; ?></td>
                  <td class="text-right"><?php echo $column_price; ?></td>
                  <td class="text-right"><?php echo $column_total; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <?php foreach ($product['option'] as $option) { ?>
                    <br />
                    <?php if ($option['type'] != 'file') { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                    <?php } else { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
                    <?php } ?>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $product['model']; ?></td>
                  <td class="text-right"><?php echo $product['quantity']; ?></td>
                  <td class="text-right"><?php echo $product['price']; ?></td>
                  <td class="text-right"><?php echo $product['total']; ?></td>
                </tr>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <tr>
                  <td class="text-left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
                  <td class="text-left"></td>
                  <td class="text-right">1</td>
                  <td class="text-right"><?php echo $voucher['amount']; ?></td>
                  <td class="text-right"><?php echo $voucher['amount']; ?></td>
                </tr>
                <?php } ?>
                <?php foreach ($totals as $total) { ?>
                <tr>
                  <td colspan="4" class="text-right"><?php echo $total['title']; ?>:</td>
                  <td class="text-right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="tab-history">
            <div id="history"></div>
            <br />
            <fieldset>
              <legend><?php echo $text_history; ?></legend>
              <form class="form-horizontal">
                <div class="form-group">

				  <label class="col-sm-2 control-label" for="input-canned-message"><?php echo $entry_canned_message; ?></label>
				  <div class="col-sm-10">
                    <select name="canned_message_id" id="input-canned-message" class="form-control">
					  <option value=""></option>
                      <?php foreach ($canned_messages as $canned_message) { ?>
                      <option value="<?php echo $canned_message['canned_message_id']; ?>"><?php echo $canned_message['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
				</div>
				<div class="form-group">
			
                  <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                  <div class="col-sm-10">
                    <select name="order_status_id" id="input-order-status" class="form-control">
                      <?php foreach ($order_statuses as $order_statuses) { ?>
                      <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                      <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-notify"><?php echo $entry_notify; ?></label>
                  <div class="col-sm-10">
                    <input type="checkbox" name="notify" value="1" id="input-notify" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                  </div>
                </div>
              </form>
              <div class="text-right">
                <button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></button>
              </div>
            </fieldset>
          </div>
          <?php if ($payment_action) { ?>
          <div class="tab-pane" id="tab-action"><?php echo $payment_action; ?></div>
          <?php } ?>
          <?php if ($frauds) { ?>
          <?php foreach ($frauds as $fraud) { ?>
          <div class="tab-pane" id="tab-<?php echo $fraud['code']; ?>">
          <?php echo $fraud['content']; ?>
          </div>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--

$('body').on('click', '#invoice-manual-new', function() {
	$.ajax({
		url: 'index.php?route=sale/order/getnewinvoiceno&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
      <?php if($pdfinv_ocv21) { ?>
			$('#invoice-manual-new i').addClass('fa-spin');
      <?php } else { ?>
			$('#invoice').after('<img src="view/pdf_invoice_pro/img/loading.gif" class="loading" style="padding-left: 5px;" />');	
      <?php } ?>
		},
		complete: function() {
      <?php if($pdfinv_ocv21) { ?>
      $('#invoice-manual-new i').removeClass('fa-spin');
      <?php } else { ?>
			$('.loading').remove();
      <?php } ?>
		},
		success: function(json) {
			$('.success, .warning').remove();
						
			if (json['error']) {
				$('#tab-order').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			
			if (json.invoice_no) {
        <?php if($pdfinv_ocv21) { ?>
          $('#manual_inv_no input[name=manual_inv_number]').val(json['invoice_no']);
					$('#manual_inv_no input[name=manual_inv_prefix]').val(json['prefix']);
          $('#orig_invoice_no').hide();
          $('#invoice-manual-new').hide();
          $('.tooltip').fadeOut('fast');
          $('#orig_invoice_no').html(json['prefix']+json['invoice_no']);
          $('#orig_invoice_no').fadeIn('slow');
          $('#invoice-manual-edit').fadeIn('slow');
        <?php } else { ?>
				$('#invoice').fadeOut('slow', function() {
					$('#manual_inv_no input[name=manual_inv_number]').val(json['invoice_no']);
					$('#manual_inv_no input[name=manual_inv_prefix]').val(json['prefix']);
					$('#manual_inv_no').show();
            $('#invoice').hide();
				});
        <?php } ?>
			}
		}
	});
});
$('body').on('click', '#invoice-manual-edit', function() {
	$('#manual_inv_no').show();
	<?php if($pdfinv_ocv21) { ?>
    $('#orig_invoice_no').hide();
    $('#invoice-manual-edit').hide();
  <?php } else { ?>
    $('#invoice').hide();
  <?php } ?>
});
$('body').on('click', '#invoice-manual-save', function() {
	$.ajax({
		url: 'index.php?route=sale/order/manualinvoiceno&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		data:{prefix:$('#manual_inv_no input[name=manual_inv_prefix]').val(),number:$('#manual_inv_no input[name=manual_inv_number]').val()},
		success: function(json) {
			$('.success, .warning').remove();
						
			if (json['error']) {
				$('#tab-order').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			
			if (json.invoice_no) {
				$('#invoice').fadeOut('slow', function() {
          <?php if($pdfinv_ocv21) { ?>
            $('#orig_invoice_no').html(json['invoice_no']);
            $('#invoice-manual-edit').fadeIn('slow');
            $('#orig_invoice_no').fadeIn('slow');
					<?php } else if($pdfinv_ocv2) { ?>
						$('#invoice').html(json['invoice_no'] + ' <button id="invoice-manual-edit" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> <?php echo $text_manual_invoice_edit; ?></button>');
					<?php } else { ?>
						$('#invoice').html(json['invoice_no'] + ' [ <a id="invoice-manual-edit"><?php echo $text_manual_invoice_edit; ?></a> ]');
					<?php } ?>
					
					$('#manual_inv_no').hide();
					$('#invoice').fadeIn('slow');
				});
			}
		}
	});
});

$(document).delegate('#button-invoice', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/createinvoiceno&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-invoice').button('loading');			
		},
		complete: function() {
			$('#button-invoice').button('reset');
		},
		success: function(json) {
			$('.alert').remove();
						
			if (json['error']) {
				$('#tab-order').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['invoice_no']) {
				$('#button-invoice').replaceWith(json['invoice_no']);
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addreward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-add').button('loading');
		},
		complete: function() {
			$('#button-reward-add').button('reset');
		},									
		success: function(json) {
			$('.alert').remove();
						
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('#button-reward-add').replaceWith('<button id="button-reward-remove" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i> <?php echo $button_reward_remove; ?></button>');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removereward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-remove').button('loading');
		},
		complete: function() {
			$('#button-reward-remove').button('reset');
		},				
		success: function(json) {
			$('.alert').remove();
						
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('#button-reward-remove').replaceWith('<button id="button-reward-add" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> <?php echo $button_reward_add; ?></button>');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addcommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-add').button('loading');
		},
		complete: function() {
			$('#button-commission-add').button('reset');
		},			
		success: function(json) {
			$('.alert').remove();
						
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
                
				$('#button-commission-add').replaceWith('<button id="button-commission-remove" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i> <?php echo $button_commission_remove; ?></button>');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removecommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-remove').button('loading');
		
		},
		complete: function() {
			$('#button-commission-remove').button('reset');
		},		
		success: function(json) {
			$('.alert').remove();
						
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('#button-commission-remove').replaceWith('<button id="button-commission-add" class="btn btn-success btn-xs"><i class="fa fa-minus-circle"></i> <?php echo $button_commission_add; ?></button>');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();
	
	$('#history').load(this.href);
});			

$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#button-history').on('click', function() {
  if(typeof verifyStatusChange == 'function'){
    if(verifyStatusChange() == false){
      return false;
    }else{
      addOrderInfo();
    }
  }else{
    addOrderInfo();
  }

	$.ajax({
		url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order/history&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-history').button('loading');			
		},
		complete: function() {
			$('#button-history').button('reset');	
		},
		success: function(json) {
			$('.alert').remove();
			
			if (json['error']) {
				$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			} 
		
			if (json['success']) {
				$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
				
				$('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				
				$('textarea[name=\'comment\']').val('');
				
				$('#order-status').html($('select[name=\'order_status_id\'] option:selected').text());			
			}			
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function changeStatus(){
  var status_id = $('select[name="order_status_id"]').val();

  $('#openbay-info').remove();

  $.ajax({
    url: 'index.php?route=extension/openbay/getorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id='+status_id,
    dataType: 'html',
    success: function(html) {
      $('#history').after(html);
    }
  });
}

function addOrderInfo(){
  var status_id = $('select[name="order_status_id"]').val();

  $.ajax({
    url: 'index.php?route=extension/openbay/addorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id='+status_id,
    type: 'post',
    dataType: 'html',
    data: $(".openbay-data").serialize()
  });
}

$(document).ready(function() {
  changeStatus();
});

$('select[name="order_status_id"]').change(function(){ changeStatus(); });
//--></script>

<script type="text/javascript"><!--
// Sort the custom fields
$('#tab-payment tr[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-payment tr').length) {
		$('#tab-payment tr').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#tab-payment tr').length) {
		$('#tab-payment tr:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#tab-payment tr').length) {
		$('#tab-payment tr:first').before(this);
	}
});

$('#tab-shipping tr[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-shipping tr').length) {
		$('#tab-shipping tr').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#tab-shipping tr').length) {
		$('#tab-shipping tr:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#tab-shipping tr').length) {
		$('#tab-shipping tr:first').before(this);
	}
});
//--></script></div>
<?php echo $footer; ?> 

				<script type="text/javascript"><!--
				$('select[name=\'canned_message_id\']').on('change', function() {
					var canned_message_id = $(this).val();
					
					$.ajax({
						url: 'index.php?route=module/canned_messages/info&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&canned_message_id=' + canned_message_id,
						type: 'get',
						dataType: 'json',
						beforeSend: function() {
							$('select[name=\'canned_message_id\']').prop('disabled', true);
						},
						success: function(json) {
							$('select[name=\'canned_message_id\']').prop('disabled', false);
							
							$('select[name=\'order_status_id\']').val(json['order_status_id']);
							$('textarea[name=\'comment\']').val(json['comment']);
							
							if (json['notify'] == '1') {
								$('input[name=\'notify\']').prop('checked', true);
							} else {
								$('input[name=\'notify\']').prop('checked', false);
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				});
				//--></script>
			
