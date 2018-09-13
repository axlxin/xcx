<table class="table">
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">*</span><?php echo $entry_code; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $entry_code_help; ?></span>
        </td>
        <td>
            <div class="col-xs-4">
                <select name="SignUpCoupons[Enabled]" class="SignUpCouponsEnabled form-control">
                    <option value="yes" <?php echo (!empty($data[ 'SignUpCoupons'][ 'Enabled']) && $data[ 'SignUpCoupons'][ 'Enabled']=='yes' ) ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                    <option value="no" <?php echo (empty($data[ 'SignUpCoupons'][ 'Enabled']) || $data[ 'SignUpCoupons'][ 'Enabled']=='no' ) ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="col-xs-3" colspan="3" style="padding:10px;">
            <h4><strong><?php echo $coupon_settings; ?></strong></h4>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">*</span><?php echo $discount_type; ?></strong></h5>
        </td>
        <td>
            <div class="col-xs-4">
                <select name="SignUpCoupons[discount_type]" class="form-control">
                    <option value="P" <?php if(!empty($data[ 'SignUpCoupons'][ 'discount_type']) && $data[ 'SignUpCoupons'][ 'discount_type']=="P" ) echo "selected"; ?>><?php echo $text_percentage; ?></option>
                    <option value="F" <?php if(!empty($data[ 'SignUpCoupons'][ 'discount_type']) && $data[ 'SignUpCoupons'][ 'discount_type']=="F" ) echo "selected"; ?>><?php echo $text_fixed_amount; ?></option>
                </select>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">*</span><?php echo $discount_text; ?></strong></h5>
        </td>
        <td>
            <div class="col-xs-4">
                <div class="input-group">
                    <input type="text" class="brSmallField form-control" name="SignUpCoupons[discount]" id="brDiscount" value="<?php if(!empty($data['SignUpCoupons']['discount'])) echo $data['SignUpCoupons']['discount']?>">
                    <span class="input-group-addon"><p style="display:none; margin:0px;" id="currencyAddon"><?php echo $currency ?></p><p style="display:none; margin:0px;" id="percentageAddon">%</p></span>
                </div>
            </div>
            
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><?php echo $entry_total; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $entry_total_help; ?></span>
        </td>
        <td>
            <div class="col-xs-4">
                <div class="input-group">
                    <input type="text" class="brSmallField form-control" name="SignUpCoupons[total_amount]" value="<?php if(!empty($data['SignUpCoupons']['total_amount'])) echo $data['SignUpCoupons']['total_amount']?>">
                    <span class="input-group-addon"><?php echo $currency ?></span>
                </div>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">*</span><?php echo $coupon_validity; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $coupon_validity_help; ?></span>
        </td>
        <td>
            <div class="col-xs-4">
                <div class="input-group">
                    <input type="text" value="<?php if(!empty($data['SignUpCoupons']['days_after'])) echo (int)$data['SignUpCoupons']['days_after']; else echo 7; ?>" class="brSmallField form-control" name="SignUpCoupons[days_after]">
                    <span class="input-group-addon">days</span>
                </div>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><?php echo $entry_product; ?></strong></h5>
        </td>
        <td>
            <div class="col-xs-4">
                <select id="select_products" class="toggle-fade-next form-control" name="SignUpCoupons[selected_products]">
                    <option value="all" <?php if(!empty($data[ 'SignUpCoupons'][ 'selected_products']) && $data[ 'SignUpCoupons'][ 'selected_products']=='all' ) echo 'selected="selected"'?>><?php echo $text_all_products; ?></option>
                    <option value="specific" <?php if(!empty($data[ 'SignUpCoupons'][ 'selected_products']) && $data[ 'SignUpCoupons'][ 'selected_products']=='specific' ) echo 'selected="selected"'?>><?php echo $text_following_products; ?></option>
                </select>
            </div>
        </td>
    </tr>
    <tr id="select_product_row">
        <td class="col-xs-3" style="border-top:none;">
            </br>
        </td>
        <td style="border-top:none;">
            <div class="col-xs-4">
                <div style="display:block;">
                    <input type="text" name="product" value="" class="category-autocomplete form-control" placeholder="<?php echo $text_type_product; ?>" />
                    <div id="coupon-product" class="scrollbox well well-sm" style="height:140px;">
                        <?php $class='odd' ; ?>
                        <?php foreach ($data[ 'SignUpCoupons'][ 'coupon_product'] as $coupon_product) { ?>
                        <div class="coupon-product" id="coupon-product<?php echo $coupon_product['product_id']; ?>">
                            <i class="fa fa-minus-circle"></i>&nbsp;<?php echo $coupon_product[ 'name']; ?>
                            <input type="hidden" name="SignUpCoupons[coupon_product][]" value="<?php echo $coupon_product['product_id']; ?>" />
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><?php echo $entry_category; ?></strong></h5>
        </td>
        <td>
            <div class="col-xs-4">
                <select id="select_categories" class="toggle-fade-next form-control" name="SignUpCoupons[selected_categories]">
                    <option value="all" <?php if(!empty($data[ 'SignUpCoupons'][ 'selected_categories']) && $data[ 'SignUpCoupons'][ 'selected_categories']=='all' ) echo 'selected="selected"'?>><?php echo $text_all_categories; ?></option>
                    <option value="specific" <?php if(!empty($data[ 'SignUpCoupons'][ 'selected_categories']) && $data[ 'SignUpCoupons'][ 'selected_categories']=='specific' ) echo 'selected="selected"'?>><?php echo $text_following_categories; ?></option>
                </select>
            </div>
        </td>
    </tr>
    <tr id="select_categories_row">
        <td class="col-xs-3" style="border-top:none;">
            </br>
        </td>
        <td style="border-top:none;">
            <div class="col-xs-4">
                <div style="display:block;">
                    <input type="text" name="category" value="" class="category-autocomplete form-control" placeholder="<?php echo $text_type_category; ?>" />
                    <div id="coupon-category" class="scrollbox well well-sm" style="height: 140px;">
                        <?php $class='odd' ;?>
                        <?php foreach ($data['SignUpCoupons']['coupon_category'] as $coupon_category) { ?>
                        <div id="coupon-category<?php echo $coupon_category['category_id']; ?>">
                            <i class="fa fa-minus-circle"></i><?php echo $coupon_category['name']; ?>
                            <input type="hidden" name="SignUpCoupons[coupon_category][]" value="<?php echo $coupon_category['category_id']; ?>" />
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</tbody>
</table>
<script type="text/javascript">
		
    if ($('select[name="SignUpCoupons[discount_type]"]').val() == 'P') {
        $('#percentageAddon').show();
    } else {
        $('#currencyAddon').show();
    }

    $('select[name="SignUpCoupons[discount_type]"]').on('change', function (e) { 
        if ($(this).val() == 'P') {
            $('#percentageAddon').show();
            $('#currencyAddon').hide();
        } else {
            $('#currencyAddon').show();
            $('#percentageAddon').hide();
        }
    });
	
// coupon products, categories
    $('input[name=\'category[]\']').bind('change', function () {
        var filter_category_id = this;
        $.ajax({
            url: 'index.php?route=catalog/product/autocomplete&token=' + getURLVar('token') + '&filter_category_id=' + filter_category_id.value + '&limit=10000',
            dataType: 'json',
            success: function (json) {
                for (i = 0; i < json.length; i++) {
                    if ($(filter_category_id).attr('checked') == 'checked') {
                        $('#coupon-product' + json[i]['product_id']).remove();

                        $('#coupon-product').append('<div class="coupon-product" id="coupon-product' + json[i]['product_id'] + '">'+ '<i class="fa fa-minus-circle"></i>' + json[i]['name'] + '<input type="hidden" name="SignUpCoupons[coupon_product][]" value="' + json[i]['product_id'] + '" /></div>');
                    } else {
                        $('#coupon-product' + json[i]['product_id']).remove();
                    }
                }
            }
        });
    });


   $('input[name=\'product\']').autocomplete({
    delay: 500,
    source: function (request, response) {
      $.ajax({
        url: 'index.php?route=catalog/product/autocomplete&token=' + getURLVar('token') + '&filter_name=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
          response($.map(json, function (item) {
            return {
              label: item.name,
              value: item.product_id
            }
          }));
        }
      });
    },	
		'select': function(item) {
		  $('input[name=\'product\']').val('');
		  $('#coupon-product' + item['value']).remove();
		  
		  $('#coupon-product').append('<div id="coupon-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="SignUpCoupons[coupon_product][]" value="' + item['value'] + '" /></div>');	
		  $('input[name=\'product\']').val('');

		}
	});
	$('#coupon-product').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});	  


    $('input[name=\'category\']').autocomplete({
    delay: 500,
    source: function (request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&token=' + getURLVar('token') + '&filter_name=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
          response($.map(json, function (item) {
            return {
              label: item.name,
              value: item.category_id
            }
          }));
        }
      });
    },	
		'select': function(item) {
		  $('#coupon-category' + item['value']).remove();
		  
		 $('#coupon-category').append('<div id="coupon-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="SignUpCoupons[coupon_category][]" value="' + item['value'] + '" /></div>');	
		  $('input[name=\'category\']').val('');

		}
	});
	$('#coupon-category').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});	  
                      
    //-->
    
	$(document).ready(function(e) { 
		if ($('select[name="SignUpCoupons[selected_products]"]').val() == 'all') {
			$('select[name="SignUpCoupons[selected_products]"]').parent().next('tr').children().fadeOut();
		} else {
			$('select[name="SignUpCoupons[selected_products]"]').parent().next('tr').children().fadeIn();	
		}
		
		if ($('select[name="SignUpCoupons[selected_categories]"]').val() == 'all') {
			$('select[name="SignUpCoupons[selected_categories]"]').parent().next('tr').children().fadeOut();
		} else {
			$('select[name="SignUpCoupons[selected_categories]"]').parent().next('tr').children().fadeIn();	
		}
	});
	
	$(document).on('change','.toggle-fade-next', function(){
		if ($(this).val() == 'all') {
			$(this).parent().next('tr').children().fadeOut();
		} else {
			$(this).parent().next('tr').children().fadeIn();	
		}
	});
</script>	
<script>
$(function() { 
    var $typeSelector1 = $('#select_products');
    var $toggleArea1 = $('#select_product_row');   
	 if ($typeSelector1.val() != 'all') { 
            $toggleArea1.show(); 
        }
        else {
            $toggleArea1.hide(); 
        }
    $typeSelector1.change(function(){
        if ($typeSelector1.val() != 'all') {
            $toggleArea1.show(400); 
        }
        else {
            $toggleArea1.hide(400); 
        }
    });
});
$(function() { 
    var $typeSelector2 = $('#select_categories');
    var $toggleArea2 = $('#select_categories_row');   
	 if ($typeSelector2.val() != 'all') { 
            $toggleArea2.show(); 
        }
        else {
            $toggleArea2.hide(); 
        }
    $typeSelector2.change(function(){
        if ($typeSelector2.val() != 'all') {
            $toggleArea2.show(400); 
        }
        else {
            $toggleArea2.hide(400); 
        }
    });
});
</script>