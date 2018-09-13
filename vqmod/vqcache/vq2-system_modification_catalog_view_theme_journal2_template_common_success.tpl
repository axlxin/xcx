<?php echo $header; ?>
<div id="container" class="container j-container success-page">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1 class="heading-title"><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>

            <?php if(isset($yotpoConversionUrl)) { ?>
          <img 
              src="<?php echo $yotpoConversionUrl ?>"
            width="1"
            height="1"></img>
        <?php } ?>
        
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary button"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
</div>

				<?php if (isset($ecommerce_tracking_status)) { ?>
					<?php if ($ecommerce_tracking_status && $order && $order_products) { ?>
						<?php echo $start_google_code; ?>

						<?php if ($ecommerce_global_object) { ?>
							<?php echo $ecommerce_global_object; ?>('require', 'ecommerce', 'ecommerce.js');

							<?php echo $ecommerce_global_object; ?>('ecommerce:addTransaction', {
								'id': "<?php echo $order['order_id']; ?>",
								'affiliation': "<?php echo $order['store_name']; ?>",
								'revenue': "<?php echo($ecommerce_tracking_tax  == 0 ? $order['order_sub_total'] : $order['order_total'] ) ?>",
								'shipping': "<?php echo $order['order_shipping']; ?>",
								'tax': "<?php echo $order['order_tax']; ?>",
								'currency': "<?php echo $order['currency_code']; ?>"
							});

							<?php foreach($order_products as $order_product) { ?>
							<?php echo $ecommerce_global_object; ?>('ecommerce:addItem', {
								'id': "<?php echo $order_product['order_id']; ?>",
								'name': "<?php echo $order_product['name']; ?>",
								'sku': "<?php echo $order_product['sku']; ?>",
								'category': "<?php echo $order_product['category']; ?>",
								'price': "<?php echo $order_product['price']; ?>",
								'quantity': "<?php echo $order_product['quantity']; ?>"
							});
							<?php } ?>

							<?php echo $ecommerce_global_object; ?>('ecommerce:send');
						<?php } else { ?>
							_gaq.push(['_set', 'currencyCode', '<?php echo $order['currency_code']; ?>']);

							_gaq.push(['_addTrans',
								"<?php echo $order['order_id']; ?>",
								"<?php echo $order['store_name']; ?>",
								"<?php echo($this->config->get('ecommerce_tracking_tax') == 0 ? $order['order_sub_total'] : $order['order_total'] ) ?>",
								"<?php echo $order['order_tax']; ?>",
								"<?php echo $order['order_shipping']; ?>",
								"<?php echo $order['payment_city']; ?>",
								"<?php echo $order['payment_zone']; ?>",
								"<?php echo $order['payment_country']; ?>"
							]);

							<?php foreach($order_products as $order_product) { ?>
							_gaq.push(['_addItem',
								"<?php echo $order_product['order_id']; ?>",
								"<?php echo $order_product['sku']; ?>",
								"<?php echo $order_product['name']; ?>",
								"<?php echo $order_product['category']; ?>",
								"<?php echo $order_product['price']; ?>",
								"<?php echo $order_product['quantity']; ?>"
							]);
							<?php } ?>

							_gaq.push(['_trackTrans']);
						<?php } ?>

						<?php echo $end_google_code; ?>
					<?php } else { ?>
						<?php echo $google_analytics; ?>
					<?php } ?>
				<?php } ?>
			
<?php echo $footer; ?>