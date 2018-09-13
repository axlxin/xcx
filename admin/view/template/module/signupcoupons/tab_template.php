<table class="table">
    <tr> 
        <td colspan="4">
            <div class="tabbable nav-tabs"> 
            	<ul class="nav nav-tabs">
					<?php $i=1; foreach ($languages as $language) { ?>
                    <li <?php if($i-- >0) echo 'class="active"';?>>
                    	<a href="#<?php echo $language['code'].$language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['flag_url']; ?>" title="<?php echo $language['name']; ?>" />
							<?php echo $language['name']; ?>
                      	</a>
               		</li> 
                    <?php }?>
              	</ul>
                <div class="container-fluid" style="padding-left: 0px;">
                  <div class="col-md-3">
                        <h5><strong><span class="required">* </span><?php echo $user_email; ?></strong></h5>
                        <?php echo $user_email_help; ?>
                  </div>
                  <div class="tab-content col-md-9"> 
                        <?php $i=1;  foreach($languages as $language) {  ?>
                        <div id="<?php echo $language['code'].$language['language_id']; ?>" class="tab-pane <?php if($i-- > 0) echo "active"; ?> ">
                            <div class="col-xs-10">    
                                <div class="emailLanguageWrapper">
                                        <label for="subject[<?php echo $language['code']; ?>]"><span class="required">*</span> <?php echo $subject_text;  ?> :</label>  
                                        <input type="text" id="subject_<?php echo $language['code']; ?>" class="subject form-control" name="SignUpCoupons[subject][<?php echo $language['code']; ?>]" value="<?php if(!empty($data['SignUpCoupons']['subject'][$language['code']])) {
                                                echo $data['SignUpCoupons']['subject'][$language['code']];
                                             } else {
                                                echo $subject[$language['code']];
                                             } ?>" />     
                                    <textarea rows="10" class="form-control" id="message_<?php echo $language['code']; ?>" name="SignUpCoupons[message][<?php echo $language['code']; ?>]">
                                        <?php   if(!empty($data['SignUpCoupons']['message'][$language['code']])) { echo $data[ 'SignUpCoupons'][ 'message'][$language['code']]; } else { echo $default_message ; }?>
                                    </textarea>
                                </div>
                             </div>
                         </div>
                        <?php }?>  
                    </div>
                </div>
			</div>       
    	</td>  
    </tr>
</table>

<script type="text/javascript">
<?php foreach ($languages as $language) { ?>
	$("#message_<?php echo $language['code']; ?>").summernote({height: 300});
<?php } ?>
</script>