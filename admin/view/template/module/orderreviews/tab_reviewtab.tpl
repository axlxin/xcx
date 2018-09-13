<?php 
   $reviewmail_name = $moduleName.'[ReviewMail]['.$reviewmail['id'].']';
   $reviewmail_data = (isset($moduleData['ReviewMail'][$reviewmail['id']])) ? $moduleData['ReviewMail'][$reviewmail['id']] : array();
?>
<div id="reviewmail_<?php echo $reviewmail['id']; ?>" class="tab-pane reviews" style="width:99%;overflow:hidden;">
   <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#general_settings_<?php echo $reviewmail['id'] ?>">General</a></li>
        <li><a data-toggle="tab" href="#conditions_<?php echo $reviewmail['id'] ?>">Configuration</a></li>
        <li><a data-toggle="tab" href="#email_template_<?php echo $reviewmail['id'] ?>">Email Template</a></li>
        <li><a data-toggle="tab" href="#discount_<?php echo $reviewmail['id'] ?>">Discount Settings</a></li>
        <li id="discountMailTab_<?php echo $reviewmail['id']; ?>"><a data-toggle="tab" href="#discount_email_template_<?php echo $reviewmail['id'] ?>">Discount Email Template</a></li>
    </ul>

    <div class="tab-content">
        <div id="general_settings_<?php echo $reviewmail['id'] ?>" class="tab-pane fade in active">
            <?php require(DIR_APPLICATION.'view/template/module/orderreviews/tab_general.php'); ?>
        </div>
        <div id="conditions_<?php echo $reviewmail['id'] ?>" class="tab-pane fade in">
            <?php require(DIR_APPLICATION.'view/template/module/orderreviews/tab_conditions.php'); ?>
        </div>
        <div id="discount_<?php echo $reviewmail['id'] ?>" class="tab-pane fade in">
            <?php require(DIR_APPLICATION.'view/template/module/orderreviews/tab_discount.php'); ?>
        </div>
        <div id="email_template_<?php echo $reviewmail['id'] ?>" class="tab-pane fade in">
            <?php require(DIR_APPLICATION.'view/template/module/orderreviews/tab_email.php'); ?>
        </div>
         <div id="discount_email_template_<?php echo $reviewmail['id'] ?>" class="tab-pane fade in">
            <?php require(DIR_APPLICATION.'view/template/module/orderreviews/tab_discount_email.php'); ?>
        </div>
        
    </div>
    <?php if (isset($newAddition) && $newAddition==true) { ?>
   <script type="text/javascript">
      <?php foreach ($languages as $language) { ?>
         $('#message_<?php echo $reviewmail['id']; ?>_<?php echo $language['language_id']; ?>').summernote({
               height: 320
         });
      <?php } ?>
      selectorsForDiscount();
   </script>
   <?php } ?>
</div>
<script>
$('#livePreview_<?php echo $reviewmail['id']; ?>').click(function(e){
	//debugger;
	var email_container = $(this).parents('#reviewmail_'+$(this).attr('data-email-id'));
	var display_images = email_container.find('select[name*="DisplayImages"] option:selected').val();
	var email_type = $('#EmailType').val();
	var review_form;
	var textarea = email_container.find('textarea[name*="Message"]').code();
	var review_form;
	var ordered_products = '<a href="#"><strong>Our Test Product(s)</strong></a>';
	if(email_type == 'form'){
		var form_link = '<div style="font-family:inherit;font-size:11px;text-align:center;background: #f2f2f2;padding:3px;"><p>If this email is not displayed correctly or you cannot submit the form, please <a href="#"><strong>click here</strong></a>.</p></div>';
	
		review_form = '<table width="100%">';
		
		if(display_images == 'yes'){			
		review_form += '<tr style="text-align:center;"><td><img src="../image/iphone_1.jpg"></td></tr>';
		}
		review_form += '<tr>';
		review_form += '<td width="100%" style="font-family:Verdana;color:#f0ad4e;direction:ltr; text-align:center;">';
		review_form += '<span style="display:inline-block">';
		review_form += '<span style="display:inline-block;float:left;margin-right:15px">';
		review_form += '<input id="rat{number}_1" name="orderreviews[{number}][rating]" type="radio" value="1" style="font-family:inherit"><label for="rat{number}_1">';
		review_form += '<span style="font-size:21px;padding-left:0">★</span></label></span>';
		review_form += '<span style="display:inline-block;float:left;margin-right:15px">';
		review_form += '<input id="rat{number}_1" name="orderreviews[{number}][rating]" type="radio" value="1" style="font-family:inherit"><label for="rat{number}_1">';
		review_form += '<span style="font-size:21px;padding-left:0">★★</span></label></span>';
		review_form += '<span style="display:inline-block;float:left;margin-right:15px">';
		review_form += '<input id="rat{number}_1" name="orderreviews[{number}][rating]" type="radio" value="1" style="font-family:inherit"><label for="rat{number}_1">';
		review_form += '<span style="font-size:21px;padding-left:0">★★★</span></label></span>';
		review_form += '<span style="display:inline-block;float:left;margin-right:15px">';
		review_form += '<input id="rat{number}_1" name="orderreviews[{number}][rating]" type="radio" value="1" style="font-family:inherit"><label for="rat{number}_1">';
		review_form += '<span style="font-size:21px;padding-left:0">★★★★</span></label></span>';
		review_form += '<span style="display:inline-block;float:left;margin-right:15px">';
		review_form += '<input id="rat{number}_1" name="orderreviews[{number}][rating]" type="radio" value="1" style="font-family:inherit"><label for="rat{number}_1">';
		review_form += '<span style="font-size:21px;padding-left:0">★★★★</span></label></span>';
		review_form +=	'</span>';
		review_form += '</tr>';
		review_form += '<tr>';
		review_form += '<td>';
		review_form += '<ul style="margin:0;padding:0"><textarea name="orderreviews[{number}][text]" cols="40" rows="5"';
		review_form += 'style="font-size:12px;padding-left:3px;min-height:60px;width:99%;border:solid 1px #e1e1e1;font-family:inherit;margin:0 0 15px 0">';
		review_form += '</textarea></ul><br>';
		review_form += '</td>';
		review_form += '</tr>';
		review_form += '<tr><td style="font-family:Verdana;text-align:right">';
		review_form += '<input type="submit" style="font-family:inherit;border:1px solid #C57824;padding:6px 13px;text-transform:uppercase;';
		review_form += 'text-decoration:none;background-color:#DF9020;font-size:13px;color:#ffffff" value="✓ Submit "></td></tr>';
		review_form += '</table>';		
	}else{
		var form_link = '<div style="font-family:inherit;font-size:11px;text-align:center;background: #f2f2f2;padding:3px; height:25px;"></div>';
		review_form = '';
		review_form += '<table width="100%">';
		review_form += ' <tbody><tr><td width="5%" style="font-family:Verdana"></td>';
		review_form += '<td width="90%" style="font-family:Verdana"><table cellspacing="0" cellpadding="0" border="0" style="width:100%"><tbody>';
		review_form += '<tr><td  width="210px" height="25%" align="left" style="font-family:Verdana;font-size:inherit;padding:15px 0;letter-spacing:0; text-align:center;">';
		review_form += ' <a href="javascript:void(0)" style="display: block; width: 140px;height: 40px;background: #229ac8;padding: 10px;font-weight: bold;  margin: 0 auto; text-decoration: none; color: white;">Leave a review</a>';
		review_form += ' </td></tr></tbody></table></td><td width="5%" style="font-family:Verdana"></td></tr>';
		review_form += '</tbody>'
		review_form += '</table>';
	}
	
	
	var patterns = ['{reviewmail_link}', '{first_name}','{last_name}','{order_products}','{review_form}'];
	var replacement = [form_link,"John","Doe",ordered_products,review_form];
	
	for (var x = 0; x < patterns.length; x++){
		textarea = textarea.replace(patterns[x],replacement[x]);	
	}
	$('#emailPreview_<?php echo $reviewmail['id']; ?>').on('show.bs.modal', function (e) {
			var modalContent = $( ".modal-body" )
			modalContent.html(textarea);
	});
	
});
		
</script>
