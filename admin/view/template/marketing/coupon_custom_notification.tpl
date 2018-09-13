<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-coupon" onclick="$('#notificationform').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
   <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_notification; ?></h3>
      </div>
    <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="notificationform">
        <input type="hidden" name="notification_coupon_id" value="<?php echo $coupon_id;?>">  
       
        <div class="form-group">
                <label class="col-sm-2 control-label" for="input-customer_notification"><span data-toggle="tooltip" title="<?php echo $help_text_notification_customers; ?>"><?php echo $text_notification_customers; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="customer_notification" value="" placeholder="<?php echo $entry_customer; ?>" id="input_customer_notification" class="form-control" />
                  <div id="coupon_customer_notification" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($coupon_customer_notification as $coupon_customer_notification) { ?>
                    <div id="coupon_customer_notification<?php echo $coupon_customer_notification['customer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $coupon_customer_notification['name']; ?>
                      <input type="hidden" name="coupon_customer_notification[]" value="<?php echo $coupon_customer_notification['customer_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
         </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-customer_email"><span data-toggle="tooltip" title="<?php echo $help_text_extra_notification_customers; ?>"><?php echo $text_extra_notification_customers; ?></span></label>
            <div class="col-sm-10">
                <textarea id="extra_emails_notifications" name="extra_emails_notifications" cols="100" rows="5" class="form-control"></textarea>
                <span class='help'><b>For e.g. xyz@abc.com,user1@store.com,user2@store.com<br/></b></span><br/>
            </div>
        </div>
        
        <div class="form-group">
                <label class="col-sm-2 control-label" for="input-subject"><?php echo $text_notification_subject; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="subject" value="<?php echo $subject; ?>" placeholder="<?php echo $entry_uses_customer; ?>" class="form-control" /><br/>
                </div>
        </div>
        
        <div class="form-group">
               <label class="col-sm-2 control-label" for="input-subject"><span data-toggle="tooltip" title="<?php echo $help_text_notification_message; ?>"><?php echo $text_notification_message; ?></span></label>
               <div class="col-sm-10">
                <textarea name="message" id='message' class="form-control summernote"><?php echo $message ?></textarea>
               </div>
        </div>
</form>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>

<script type="text/javascript"><!--
$('input[name=\'customer_notification\']').autocomplete({ 
	delay: 500,
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name + ' ('+item.customer_id+')',
						value: item.customer_id
					}
				}));
			}
		});
		
	}, 
	select: function(item) {
			
                $('input[name=\'customer_notification\']').val('');
                $('#coupon_customer_notification' + item['value']).remove();
                $('#coupon_customer_notification').append('<div id="coupon_customer_notification' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="coupon_customer_notification[]" value="' + item['value'] + '" /></div>');
	}
});
$('#coupon_customer_notification').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

function sendnotification(){
    if(!$('#subject').val()){
        alert('Please enter subject!');
        $('#subject').focus();
        return false;
    }

    if(!$('#message').val()){
        alert('Please enter Message to be sent!');
        $("#message").focus();
        return false;
    }
    $("#notificationform").submit();
}
//--></script>
  </div>
</div>
</div>
</div>
<?php echo $footer; ?>