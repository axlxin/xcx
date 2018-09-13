<table class="table">
    <tr>
        <td class="col-xs-2">
            <h5><strong><?php echo $frontstore_notification; ?></strong></h5>
        </td>
        <td>
            <div class="col-xs-4">
                <select name="SignUpCoupons[frontstore_notification]" class="toggle-front-storenotification form-control">
                    <option value="yes" <?php echo (!empty($data['SignUpCoupons']['frontstore_notification']) && $data['SignUpCoupons']['frontstore_notification'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                    <option value="no"  <?php echo (empty($data['SignUpCoupons']['frontstore_notification']) || $data['SignUpCoupons']['frontstore_notification']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
        </td>
    </tr>
</table>
<table class="form notificationForm notificationMessage" style="display:none; width:100%;">
    <tr>
        <td colspan="2">
            <div class="tabbable nav-tabs">
                <ul class="nav nav-tabs">
                    <?php $i=1; foreach ($languages as $language) { ?>
                    <li <?php if($i-- >0) echo 'class="active"';?>>
                        <a href="#notification<?php echo $language['code'].$language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['flag_url']; ?>" title="<?php echo $language['name']; ?>" />
                            <?php echo $language['name']; ?>
                        </a>
                    </li>
                    <?php }?>
                </ul>
                
                <div class="container-fluid" style="padding-left: 0px;">
                    <div class="col-xs-3">
                        <h5><strong><span class="required">* </span><?php echo $notification_message; ?></strong></h5>
                        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $notification_message_help; ?></span>
                    </div>
                    <div class="tab-content col-xs-9">
                        <?php $i=1;  foreach($languages as $language) {  ?>
                        <div id="notification<?php echo $language['code'].$language['language_id']; ?>" class="tab-pane <?php if($i-- >0) echo "active"; ?> ">
                            <div class="notificationWrapper">
                                <textarea id="notification_<?php echo $language['code']; ?>" name="SignUpCoupons[notification][<?php echo $language['code']; ?>]">
                                <?php   if(!empty($data['SignUpCoupons']['notification'][$language['code']])) { echo $data['SignUpCoupons']['notification'][$language['code']]; } else { echo $default_notification; }?>
                                </textarea>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3" >
            <h5><strong><?php echo $custom_design ?></strong></h5>
        </td>
        <td style="padding-bottom: 10px;">
            <div class="col-xs-4">
                <select class="form-control" name="SignUpCoupons[customDesign]">
                    <option value="yes" <?php echo (!empty($data['SignUpCoupons']['customDesign']) && $data['SignUpCoupons']['customDesign'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                    <option value="no"  <?php echo (empty($data['SignUpCoupons']['customDesign']) || $data['SignUpCoupons']['customDesign']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
        </td>
    </tr>
</table>
<table  class="table notificationForm customCssForm" style="display:none">
    <tr id="custom_settings">
        <td class="col-xs-3">
            <h5><strong><?php echo $text_custom_colors; ?></strong></h5>
        </td>
        <td >
            <div class="col-xs-5">
                <div id="customDesignColors">
                    <label><?php echo $text_font_color; ?></label>
                    <div class="input-group"><span class="input-group-addon">#</span>
                    <input name="SignUpCoupons[FontColor]" class="span2 form-control" type="text" value="<?php if(!empty($data['SignUpCoupons']['FontColor'])){ echo $data['SignUpCoupons']['FontColor']; } else { echo  $font_color; }  ?>"></div><br>
                    <label><?php echo $text_background_color; ?></label>
                    <div class="input-group"><span class="input-group-addon">#</span>
                    <input name="SignUpCoupons[BackgroundColor]" class="span2 form-control" type="text" value="<?php  if(!empty($data['SignUpCoupons']['BackgroundColor'])) { echo $data['SignUpCoupons']['BackgroundColor']; } else {echo $background_color;} ?>"></div><br>
                    <label><?php echo $text_border_color; ?></label>
                    <div class="input-group"><span class="input-group-addon">#</span>
                    <input name="SignUpCoupons[BorderColor]" class="span2 form-control" type="text" value="<?php  if(!empty($data['SignUpCoupons']['BorderColor'])){ echo $data['SignUpCoupons']['BorderColor']; } else { echo $border_color;} ?>"></div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><?php echo $custom_css; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $custom_css_help; ?></span>
        </td>
        <td>
            <div class="col-xs-5">
                <textarea rows="10" class="customCss form-control" name="SignUpCoupons[customCss]" placeholder="<?php echo $text_type_css; ?>"><?php if(!empty($data['SignUpCoupons']['customCss'])){ echo $data['SignUpCoupons']['customCss']; } ?></textarea>
            </div>
        </td>
    </tr>
</div>
</table>

<script>
<?php foreach ($languages as $language) { ?>
	$("#notification_<?php echo $language['code']; ?>").summernote({height: 300});
<?php } ?>

</script>

<script type="text/javascript">
	$(document).ready(function(e) {
		if ($('select[name="SignUpCoupons[frontstore_notification]"]').val() == 'no') {
			$('.notificationMessage').fadeOut();
		} else {
			$('.notificationMessage').fadeIn();	
		}
		$(document).on('change','.toggle-front-storenotification', function(){
			if ($(this).val() == 'no') {
				$(this).parents('table').next().fadeOut();
				$('.customCssForm').fadeOut();
			} else {
				$(this).parents('table').next().fadeIn();	
				if($('select[name="SignUpCoupons[customDesign]"]').val() == 'yes') {
					$('.customCssForm').fadeIn();
				}
			}
		});
		
		if ($('select[name="SignUpCoupons[customDesign]"]').val() == 'no' || $('select[name="SignUpCoupons[frontstore_notification]"]').val() == 'no') {
			$('.customCssForm').fadeOut();
		} else {
			$('select[name="SignUpCoupons[customDesign]"]').parents('table').next().fadeIn();	
		}
		$(document).on('change','select[name="SignUpCoupons[customDesign]"]', function(){
			if ($('select[name="SignUpCoupons[customDesign]"]').val() == 'no' || $('select[name="SignUpCoupons[frontstore_notification]"]').val() == 'no') {
				$('.customCssForm').fadeOut();
			} else {
				$('.customCssForm').fadeIn();	
			}
		});
		
	});
	

</script>