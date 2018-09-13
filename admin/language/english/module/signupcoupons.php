<?php
$_['heading_title'] 		= "SignUpCoupons";
$_['text_module']         = 'Modules';
$_['text_success']        = ' Success: You have modified module SignUpCoupons!';
$_['text_content_top']    = 'Content Top';
$_['text_content_bottom'] = 'Content Bottom';
$_['text_column_left']    = 'Column Left';
$_['text_column_right']   = 'Column Right';
$_['text_enabled']                = 'Enabled';
$_['text_disabled']               = 'Disabled';
$_['text_percentage']             = 'Percentage';
$_['text_fixed_amount']           = 'Fixed Amount';
$_['text_all_products']           = 'All products';
$_['text_following_products']     = 'The following products';
$_['text_all_categories']         = 'All categories';
$_['text_following_categories']   = 'The following categories';
$_['text_type_product']   		  = 'Type a product name here..';
$_['text_type_category']  		  = 'Type a category name here..';
$_['text_custom_colors']  		  = 'Custom design colors:';
$_['text_font_color']  			  = 'Font color:';
$_['text_background_color']  	  = 'Background color:';
$_['text_border_color']  		  = 'Border color:';
$_['text_type_css']  		      = 'Place your custom CSS here...';
$_['text_settings']  		      = 'Settings';
$_['text_mail']  		    	  = 'Mail';
$_['text_store_front_stripe'] 	  = 'Store Front Stripe';
$_['text_support'] 			 	  = 'Support';
$_['text_save_changes']			  = 'Save changes';
$_['text_module_settings']	      = 'Module Settings';
$_['text_toggle_dropdown']  	  = 'Toggle Dropdown';


// Entry
$_['entry_code']          = 'SignUpCoupons status:';
$_['entry_code_help']     = 'By enabling the module your sign up welcome email will be overriden by the email text specified in Mail tab';

// Error
$_['error_permission']    = 'Warning: You do not have permission to modify module SignUpCoupons!';
$_['subject_text']                = 'Subject';
$_['text_yes']                    = 'Yes';
$_['text_no']                     = 'No';

$_['user_email']                  = 'Message to the customer:';
$_['user_email_help']             = 'Message with discount code that will be sent when the user on sign up or approve. 
									<p>Use the following codes:<br />
									{firstname} - fist name<br />
									{lastname} - last name<br />
									{discount_code} - the code of discount coupon<br />
									{total_amount} - total amount<br /> 
									{date_end} - end date of coupon validity<br />
									{product_list} - the list of coupon products<br />
									{category_list} - the list of coupon categories<br /> 
									{discount_value} - discount value of coupon<br />
									</p>';
									
$_['email_overwrite_addon']		= 'Add on to signup email';											
$_['discount_code_text'] = 'Discount code';									
$_['default_message']             = '<p>Congratulations, {firstname} {lastname},<br />
										<br />
										With you registration in our site you have got a discount code <strong>{discount_code}</strong>. Enjoy a special {discount_value}% OFF. The discount code applies after you have spent ${total_amount}. The coupon expires on {date_end}.<br />
										<br />
										Enjoy shopping!</p>';

$_['total_amount']                = 'Total amount:';
$_['total_amount_help']           = 'The total amount that must reached before the coupon is valid';

$_['discount_codeoup_text']          = 'Discount code:';
$_['discount_codeoup_text_help']     = 'Unique code that will be added to database after sending mail';

$_['coupon_validity']             = 'Coupon Validity:';
$_['coupon_validity_help']        = 'Select how many days the coupon to be valid after recieved';

$_['entry_total']         = 'Total amount:';
$_['entry_total_help']    = 'The total amount that must reached before the coupon is valid';


$_['entry_category']      = ' Make the coupon available for specific categories:';

$_['entry_product']       = 'Make the coupon available for specific products:';
$_['coupon_validity']     = 'Coupon validity:';
$_['coupon_validity_help']= 'Select how many days the coupon will be valid after received';


$_['email_overwrite_text'] = 'Overwrite sign up email';

$_['subject_text'] = 'Subject';
$_['frontstore_notification'] = 'Store front notification:';
$_['custom_design'] = 'SignUpCoupons  Design:';
$_['custom_css'] = ' Custom CSS:';
$_['custom_css_help'] = 'You can modify the style of the notification by adding your CSS in this field';


$_['default_notification'] = 'Sign up now and get your discount coupon!' ;
$_['notification_message'] = 'Notification message:';
$_['notification_message_help'] = 'This is the message that will be shown in the Store Front for not sign in customers';


$_['font_color'] = 'FFFFFF';
$_['background_color'] = 'FF0F4B';
$_['border_color'] = 'FF0F4B';
$_['coupon_settings'] = 'Coupon properties';
$_['custom_design'] = 'SignUpCoupons custom design:';
$_['text_default'] = 'Default';

$_['discount_type'] = 'Type of discount';
$_['discount_text'] = 'Discount';


?>