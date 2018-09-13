<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a onclick="KPOpenDialog()" data-toggle="tooltip" title="Print Custom Invoice" class="btn btn-success"><i class="fa fa-print"></i></a> <a href="<?php echo $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
                
<td>#<?php echo 'SP'. str_pad($order_id, 8, '0', STR_PAD_LEFT); ?></td>

              </tr>
              <tr>
                <td><?php echo $text_invoice_no; ?></td>
                <td><?php if ($invoice_no) { ?>
                  <?php echo $invoice_no; ?>
                  <?php } else { ?>
                  <button id="button-invoice" class="btn btn-success btn-xs"><i class="fa fa-cog"></i> <?php echo $button_generate; ?></button>
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
                        <td class="text-right">Purchase Cost</td>
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
                        <td class="text-right">
                            <span class="data-purchase-cost">
                                <?php echo $product['purchase_cost']; ?>
                            </span>
                            <span class="edit-purchase-cost" style="display: block;float: right;width: 16px;cursor: pointer;" data-order-product-id="<?=$product['order_product_id']?>" data-purchase-cost="<?=$product['purchase_cost']?>"  data-purchase-cost-raw="<?=$product['purchase_cost_raw']?>"><i class="fa fa-pencil"></i></span>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php foreach ($vouchers as $voucher) { ?>
                      <tr>
                        <td class="text-left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
                        <td class="text-left"></td>
                        <td class="text-right">1</td>
                        <td class="text-right"><?php echo $voucher['amount']; ?></td>
                        <td class="text-right"><?php echo $voucher['amount']; ?></td>
                        <td class="text-right">&nbsp;</td>
                      </tr>
                      <?php } ?>
                      <?php foreach ($totals as $total) { ?>
                      <tr>
                        <td colspan="4" class="text-right"><?php echo $total['title']; ?>:</td>
                        <td class="text-right"><?php echo $total['text']; ?></td>
                        <td class="text-right">&nbsp;</td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>

                <div class="modal fade" id="edit-purchase-cost">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit Purchase Cost</h4>
                      </div>
                      <div class="modal-body">
                        <p>Please enter a new value to apply a new purchase cost for the current order.</p>
                        <div class="input-group" style="margin-top: 15px">
                          <span class="input-group-addon" id="data-purchase-cost">New Purchase Cost</span>
                          <input type="number" class="form-control" aria-describedby="data-purchase-cost" id="data-purchase-cost-input">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" id="data-order-product-id">
                        <input type="hidden" id="data-currency">
                        <button type="button" class="btn btn-primary save-purchase-cost">Save</button>
                      </div>
                    </div>
                  </div>
                </div>

                <script>
                    function formatCost(cost, currency) {
                        // 判断小数
                        cost = parseFloat(cost);
                        var cost_a = parseInt(cost);
                        var cost_b = (cost - cost_a).toFixed(2);

                        cost_a = (cost_a + '').split('');
                        var len = cost_a.length;
                        var flag = 1;
                        var value = '';
                        for (var i = len-1;i>=0;i--) {
                            value += cost_a[i];
                            if (flag % 3 == 0 && i > 0) value += ',';
                            flag++;
                        }

                        var temp = '';
                        value = value.split('');
                        len = value.length;
                        for (var i = len-1;i>=0;i--) {
                            temp += value[i];
                        }

                        var re = currency + temp + (cost_b > 0 ? ('' + cost_b).substr(1) : '.00');
                        return re;
                    }

                    $(function(){
                        $('.edit-purchase-cost').on('click', function(e){
                            var $self = $(this);
                            var order_product_id = $self.attr('data-order-product-id');
                            var purchase_cost = $self.attr('data-purchase-cost-raw');
                            var currency = $self.attr('data-purchase-cost');

                            // 获取前缀单位
                            currency = $.trim(currency);
                            currency = currency.substr(0,1);

                            $('#data-order-product-id').val(order_product_id);
                            $('#data-currency').val(currency);

                            purchase_cost = parseFloat(purchase_cost).toFixed(2);

                            $('#data-purchase-cost').parent().find('input').val(purchase_cost);
                            $('#edit-purchase-cost').modal('show');
                        });

                        // 点击按钮保存
                        $(document.body).on('click', '.save-purchase-cost', function(e){
                            var purchase_cost = $('#data-purchase-cost-input').val();
                            var order_product_id = $('#data-order-product-id').val();
                            var currency = $('#data-currency').val();
                            $.ajax({
                                url: 'index.php?route=sale/order/update_purchase_cost&token=<?=$_GET['token']?>&order_id=<?=$_GET['order_id']?>',
                                type: 'post',
                                data: {
                                    purchase_cost: parseFloat(purchase_cost),
                                    order_product_id: parseInt(order_product_id)
                                },
                                success: function(data) {

                                    if (data.status === 0) {
                                        var dom = $('<div>').css({width: '160px', lineHeight: '18px', backgroundColor: '#f44336', position: 'fixed', top: '60px', left: 0, right: 0, margin: '0 auto', padding: '8px', textAlign: 'center', color: '#fff', borderRadius: '4px'}).html(data.message).appendTo(document.body);
                                        setTimeout(function(){  dom.remove();  }, 3000);
                                    } else {
                                        $('[data-order-product-id="' + order_product_id + '"]').parent().find('.data-purchase-cost').html(formatCost(purchase_cost, currency));
                                        $('[data-order-product-id="' + order_product_id + '"]').attr('data-purchase-cost', formatCost(purchase_cost, currency));
                                        $('[data-order-product-id="' + order_product_id + '"]').attr('data-purchase-cost-raw', purchase_cost);

                                        var dom = $('<div>').css({width: '160px', lineHeight: '18px', backgroundColor: '#cddc39', position: 'fixed', top: '60px', left: 0, right: 0, margin: '0 auto', padding: '8px', textAlign: 'center', color: '#fff', borderRadius: '4px'}).html(data.message).appendTo(document.body);
                                        setTimeout(function(){  dom.remove();  }, 3000);

                                    }
                                },
                                error: function() {
                                    var dom = $('<div>').css({width: '160px', lineHeight: '18px', backgroundColor: '#f44336', position: 'fixed', top: '60px', left: 0, right: 0, margin: '0 auto', padding: '8px', textAlign: 'center', color: '#fff', borderRadius: '4px'}).html('未知错误：请刷新重试').appendTo(document.body);
                                    setTimeout(function(){  dom.remove();  }, 3000);
                                }

                            });

                            $('#edit-purchase-cost').modal('hide');
                        });

                    });
                </script>
            
          <div class="tab-pane" id="tab-history">
            <div id="history"></div>
            <br />
            <fieldset>
              <legend><?php echo $text_history; ?></legend>
              <form class="form-horizontal">
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


            var reward_order_status = "<?php echo $this->config->get('reward_order_status_id'); ?>";
            if($('#input-order-status').val()==reward_order_status){
                $('#button-reward-add').trigger('click');
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Please confirm the infomation before printing!</h4>
      </div>
      <div class="modal-body">
                
          <form id='customInvoiceForm' action="<?php echo $customUrl; ?>" method="post" target='_blank'>
<table  class='table table-bordered table-hover' style="background-color:#fff;margin-top:20px">
    <tbody>
        <tr>
            <td style='text-align:center;width:40%'><b>Store Info</b></td>
            <td>
                <textarea rows="5" cols="80" name="custom_store_info"><?php 
echo sprintf("%s\n%s\nTelephone:%s\n%s\n%s",$store_name, $config_address, $config_telephone, $config_email, $store_url); 
?></textarea>
            </td>
        </tr>
        <tr>
            <td style='text-align:center'><b>Sender</b></td>
            <td><textarea rows="5" cols="80" name="custom_sender"><?php 
echo "Smart-Prototyping
907 Tower 2 Silvercord
30 Canton Road
Tsim Sha Tsui, Kowloon
Hong Kong
Tel: +86 15813734594";
?></textarea></td>
        </tr>
        <tr>
            <td style='text-align:center'><b>Consignee</b></td>
            <td><textarea rows="5" cols="80" name="custom_consignee"><?php
echo "Customer Name: {$shipping_firstname} {$shipping_lastname}\n";
if ($shipping_company) { echo "Company Name: {$shipping_company}\n"; };
echo "Address 1: {$shipping_address_1}\n";
if ($shipping_address_2) { echo "Address 2: {$shipping_address_2}\n"; };
echo "{$shipping_city}, {$shipping_zone}, {$shipping_zone_code}\n";
echo "Post Code: {$shipping_postcode}\n";
echo "Country: {$shipping_country}\n";
echo "Phone Number: {$telephone}";
?></textarea></td>
        </tr>
        <tr>
            <td style='text-align:center;background-color:#f5f5f5' colspan='2'>
                <table class='table  table-bordered table-condensed'>
                    <thead>
                        <tr><td>Product Name</td><td>Model</td><td>Quantity</td><td>Unit Price (USD)</td><td>Action</td></tr>
                    </thead>
                    <tbody>
<?php 
foreach ($products as $k => $product) {
    $Pname = sprintf("<td class='left'><input type='text' value='%s' name='custom_product[%s][name]' class='form-control input-sm'></td>", $product['name'], $k);
    $Pmodel = sprintf("<td class='left'><input type='text' value='%s' name='custom_product[%s][model]' class='form-control input-sm'></td>", $product['model'], $k);
    $Pquantity = sprintf("<td class='left'><input type='text' value='%s' name='custom_product[%s][quantity]' class='form-control input-sm'></td>", $product['quantity'], $k);
    $Pprice = sprintf("<td class='left'><input type='text' value='%s' name='custom_product[%s][price]' class='form-control input-sm'></td>", $product['usd_price'], $k);
    $Paction = "<td class='right'><a class='btn btn-danger btn-sm' onclick='delProduct(this);'>Delete</a></td>";
    echo sprintf("<tr class='custom-product'>%s %s %s %s %s</tr>", $Pname, $Pmodel, $Pquantity, $Pprice, $Paction);           
}
?>
<tr><td colspan='5' class='right'><a class='btn btn-success pull-right' onclick='KPAddProduct(this);'>Add</a></td></tr>
                    </tbody>
                </table>
            </td>  
        </tr>
        <tr>
            <td style='text-align:center;background-color:#f5f5f5' colspan='2'>
                <table class='table table-bordered'>
                    <thead>
                        <tr><td>Total Item</td><td>Total Value (USD)</td></tr>
                    </thead>
                    <tbody>
<?php 
$custom_shipping_price = 0;
$tr = <<<HTML
<tr>
<td class='center'><input type='text' value='%s' name='totals[%s][title]' style='width:80%%' class='form-control input-sm text-right'></td>
<td class='center'><input type='text' value='%s' name='totals[%s][text]' style='width:80%%' class='form-control input-sm text-right'></td>
</tr>
HTML;

$filter_total = array("Sub-Total", "Total", "Reward Points", "Reward Points"); 
foreach($data['totals'] as $key=>$item){
    $hidden = false;
    foreach($filter_total as $filter_item){
        if(stripos($item['title'], $filter_item)!==false){
            $hidden = true;
            break;
        }
    }
    if(!$hidden){
        echo sprintf($tr, $item['title'], $key, $item['usd_text'], $key);
    }
}               
?>
                    </tbody>
                </table>
            </td>  
        </tr>        
   </tbody>
</table>
      </form>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="KPsubmitForm();">OK</button>
      </div>
    </div>
  </div>
</div>
<script>
function KPsubmitForm(){
    $('#customInvoiceForm').submit();
}
function KPOpenDialog(){
    $('#myModal').modal({});
}
function KPAddProduct(ele){
    var index = $('tr.custom-product').length,
        product_name = '<td class="left"><input type="text" name="custom_product['+index+'][name]" value="" class="form-control input-sm"></td>',
        product_model = '<td class="left"><input type="text" name="custom_product['+index+'][model]" value="" class="form-control input-sm"></td>',
        product_quantity = '<td class="left"><input type="text" name="custom_product['+index+'][quantity]" value="1" class="form-control input-sm"></td>',
        product_price = '<td class="left"><input type="text" name="custom_product['+index+'][price]" value="$0.00" class="form-control input-sm"></td>';
    var tr = '<tr class="custom-product">' + product_name + product_model + product_quantity + product_price + '<td class="right"><a class="btn btn-danger btn-sm" onclick="delProduct(this);">Delete</a></td></tr>';
    $(ele).parent().parent().before(tr);        
}
function delProduct(ele){
    $(ele).parent().parent().remove();
    $("tr.custom-product").each(function(index){
        var tds = $("input",this);
        tds.eq(0).attr("name", 'custom_product['+index+'][name]');
        tds.eq(1).attr("name", 'custom_product['+index+'][model]');
        tds.eq(2).attr("name", 'custom_product['+index+'][quantity]');
        tds.eq(3).attr("name", 'custom_product['+index+'][price]');
    });
}
</script>
           
