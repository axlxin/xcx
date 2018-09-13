<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
	    <div class="form-horizontal">
		  <ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
			<li><a href="#tab-about" data-toggle="tab"><i class="fa fa-question-circle"></i> About</a></li>
		  </ul>
		  <div class="tab-content">
			<div class="tab-pane active" id="tab-general">
			  <div id="add" class="well">
			    <div class="row">
				  <div class="col-sm-4">
				    <div class="form-group">
				      <label class="col-sm-4 control-label" for="input-name"><?php echo $entry_name; ?></label>
				      <div class="col-sm-8">
					    <input type="text" name="name" value="" placeholder="<?php echo $entry_name ;?>" id="input-name" class="form-control" />
				      </div>
				    </div>
					<div class="form-group">
				      <label class="col-sm-4 control-label" for="input-notify"><?php echo $entry_notify; ?></label>
				      <div class="col-sm-8">
					    <input type="checkbox" name="notify" value="1" id="input-notify" />
				      </div>
				    </div>
					<div class="form-group">
				      <label class="col-sm-4 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
				      <div class="col-sm-8">
					    <input type="text" name="sort_order" value="" placeholder="<?php echo $entry_sort_order ;?>" id="input-sort-order" class="form-control" />
				      </div>
				    </div>
				  </div>
				  <div class="col-sm-8">
				    <div class="form-group">
				      <label class="col-sm-4 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
				      <div class="col-sm-8">
					    <select name="order_status_id" id="input-order-status" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						</select>
				      </div>
				    </div>
					<div class="form-group">
				      <label class="col-sm-4 control-label" for="input-name"><?php echo $entry_comment; ?></label>
				      <div class="col-sm-8">
					    <textarea name="comment" class="form-control" rows="4"></textarea>
				      </div>
				    </div>
					<div class="text-right">
					  <button type="button" id="button-add" class="btn btn-success"><?php echo $button_add; ?></button>
					</div>
				  </div>
				</div>
			  </div>
			  <table class="table table-hover table-bordered table-striped">
			    <thead>
				<tr>
				  <td class="text-left"><?php echo $entry_name; ?></td>
				  <td class="text-left"><?php echo $entry_notify; ?></td>
				  <td class="text-left"><?php echo $entry_order_status; ?></td>
				  <td class="text-left"><?php echo $entry_comment; ?></td>
				  <td class="text-right"><?php echo $entry_sort_order; ?></td>
				  <td></td>
				</tr>
				</thead>
				<tbody>
				  <?php if ($messages) { ?>
				    <?php foreach ($messages as $message) { ?>
				    <tr id="row-<?php echo $message['canned_message_id']; ?>">
				      <td class="text-left">
					    <div class="default"><?php echo $message['name']; ?></div>
						<div class="edit"><input type="text" name="name" value="<?php echo $message['name']; ?>" class="form-control" /></div>
					  </td>
				      <td class="text-left">
					    <div class="default"><?php echo $message['notify_text']; ?></div>
						<div class="edit"><input type="checkbox" name="notify" value="1"<?php echo $message['notify'] ? 'checked="checked"' : ''; ?> /></div>
					  </td>
				      <td class="text-left">
					    <div class="default"><?php echo $message['order_status']; ?></div>
						<div class="edit"><select name="order_status_id" class="form-control"><?php foreach ($order_statuses as $order_status) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"<?php echo $order_status['order_status_id'] == $message['order_status_id'] ? 'selected="selected"' : ''; ?>><?php echo $order_status['name']; ?></option>
						  <?php } ?></select></div>
					  </td>
				      <td class="text-left">
					    <div class="default"><?php echo $message['comment']; ?></div>
						<div class="edit"><textarea name="comment" class="form-control" rows="5"><?php echo $message['comment_raw']; ?></textarea></div>  
					  </td>
				      <td class="text-right">
					    <div class="default"><?php echo $message['sort_order']; ?></div>
						<div class="edit"><input type="text" name="sort_order" value="<?php echo $message['sort_order']; ?>" class="form-control" /></div>  
					  </td>
					  <td class="text-right">
					    <div class="default">
					      <button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?php echo $button_edit; ?>" onClick="confirmEdit('<?php echo $message['canned_message_id']; ?>');"><i class="fa fa-pencil"></i></button>
					      <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" title="<?php echo $button_delete; ?>" onClick="confirmDelete('<?php echo $message['canned_message_id']; ?>');"><i class="fa fa-trash"></i></button>
					    </div>
						<div class="edit">
						  <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo $button_save; ?>" onClick="confirmSave('<?php echo $message['canned_message_id']; ?>');"><i class="fa fa-save"></i></button>
						</div>
					  </td>
				    </tr>
				    <?php } ?>
				  <?php } else { ?>
				    <tr>
					  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
					</tr>
				  <?php } ?>
				</tbody>
			  </table>
			</div>
			<?php require_once(substr_replace(DIR_SYSTEM, '', -7) . 'vendor/equotix/' . $code . '/equotix.tpl'); ?>
		  </div>
		</div>
      </div>
    </div>
	{version}
  </div>
</div>
<style type="text/css">
.edit {
	display: none;
}
</style>
<script type="text/javascript"><!--//
$('#button-add').on('click', function() {
	$.ajax({
		url: 'index.php?route=module/canned_messages/add&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#add input[type=\'text\'], #add input:checked, #add select, #add textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-add').prop('disabled', true);
			$('#button-add').after('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(json) {
			$('#button-add').prop('disabled', false);
			$('.fa-spinner').remove();
			
			var html = '<tr>';
			html += '<td class="text-left">' + $('#add  input[name=\'name\']').val() + '</td>';
			
			if ($('#add input[name=\'notify\']').prop('checked')) {
				html += '<td class="text-left"><?php echo $text_yes; ?></td>';
			} else {
				html += '<td class="text-left"><?php echo $text_no; ?></td>';
			}
			
			html += '<td class="text-left">' + $('#add option:selected').text() + '</td>';
			html += '<td class="text-left">' + $('#add textarea').val() + '</td>';
			html += '<td class="text-right">' + $('#add input[name=\'sort_order\']').val() + '</td>';
			html += '<td class="text-right"><?php echo $text_refresh; ?></td>';
			html += '</tr>';
			
			$('#add input[type=\'text\']').val('');
			$('#add textarea').val('');
			
			$('#tab-general table tbody').prepend(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function confirmEdit(canned_message_id) {
	$('#row-' + canned_message_id + ' .default').hide();
	$('#row-' + canned_message_id + ' .edit').fadeIn();
}

function confirmSave(canned_message_id) {
	if (!confirm('<?php echo $text_are_you_sure; ?>')) {
		return false;
	}
	
	var element = $(this);
	
	$.ajax({
		url: 'index.php?route=module/canned_messages/edit&token=<?php echo $token; ?>&canned_message_id=' + canned_message_id,
		type: 'post',
		data: $('#row-' + canned_message_id + ' input[type=\'text\'], #row-' + canned_message_id + ' input:checked, #row-' + canned_message_id + ' select, #row-' + canned_message_id + ' textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#row-' + canned_message_id + ' .edit button').prop('disabled', true);
			$('#row-' + canned_message_id + ' .edit button').after('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(json) {
			$('#row-' + canned_message_id + ' .edit button').prop('disabled', false);
			$('.fa-spinner').remove();
			$('#row-' + canned_message_id + ' .edit button').html('<i class="fa fa-check-circle"></i>');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function confirmDelete(canned_message_id) {
	if (!confirm('<?php echo $text_are_you_sure; ?>')) {
		return false;
	}
	
	var element = $(this);
	
	$.ajax({
		url: 'index.php?route=module/canned_messages/delete&token=<?php echo $token; ?>&canned_message_id=' + canned_message_id,
		type: 'get',
		dataType: 'json',
		beforeSend: function() {
			element.prop('disabled', true);
		},
		success: function(json) {
			$('#row-' + canned_message_id).remove();
			$('.tooltip').remove();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
//--></script>
<?php echo $footer; ?>