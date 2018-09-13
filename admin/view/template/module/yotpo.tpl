<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" onclick="$('#yotpo_form').submit();" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal"
			enctype="multipart/form-data" id="yotpo_form">

			<?php if(empty($yotpo_appkey) && empty($yotpo_secret)) { ?>
			<div class="heading">
				<h2>
				<?php echo $heading_signup_title; ?>
				</h2>
			</div>
			<?php if (!empty($text_yotpo_missing_app_key)) { ?>
			<br> <br> <strong><?php echo $text_yotpo_missing_app_key; ?><a
				href="<?php echo $yotpo_login_link; ?>" class="btn btn-primary" target="_blank"><?php echo $text_yotpo_log_in; ?>
			</a><br> </strong>
			<?php } ?>
			<table class="form" style="border-collapse: separate;border-spacing: 10px;">
				<tr>
					<td><?php echo $entry_user_name; ?></td>
					<td><input class="form-control" type="text" name="yotpo_user_name"
						value="<?php echo $yotpo_user_name; ?>"> <?php if ($error_user_name) { ?>
						<span class="error"><?php echo $error_user_name; ?> </span> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_email; ?></td>
					<td><input class="form-control"  type="text" name="yotpo_email"
						value="<?php echo $yotpo_email; ?>"> <?php if ($error_email) { ?>
						<span class="error"><?php echo $error_email; ?> </span> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_password; ?></td>
					<td><input class="form-control"  type="password" name="yotpo_password"
						value="<?php echo $yotpo_password; ?>"> <?php if ($error_password) { ?>
						<span class="error"><?php echo $error_password; ?> </span> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_confirm_password; ?></td>
					<td><input class="form-control"  type="password" name="yotpo_confirm_password"
						value="<?php echo $yotpo_confirm_password; ?>"> <?php if ($error_confirm_password) { ?>
						<span class="error"><?php echo $error_confirm_password; ?> </span>
						<?php } ?>
					</td>
				</tr>
			</table>

			<div class="buttons" style="padding-left:10px">
				<a onclick='submit_with_action("<?php echo $sign_up; ?>");'
					class="btn btn-primary"><span><?php echo $entry_sign_up_button; ?> </span> </a>
			</div>
			<br>
			<?php } ?>

			<div class="heading">
				<h2>
				<?php echo $heading_settings_title; ?>
				</h2>
			</div>
			
			<div class="version" style="color:#888888;">
				<span><?php echo $entry_yotpo_version; ?> </span>
			</div>
			<?php if ($yotpo_show_dashborad_link) { ?>
			<br> <br> <strong><?php echo $yotpo_dashborad_link_text; ?><a
				href="<?php echo $yotpo_dashborad_link; ?>" class="btn btn-primary" target="_blank"><?php echo $yotpo_dashborad_text; ?>
			</a><br> </strong>
			<?php } ?>
			<table class="form" style="border-collapse: separate;border-spacing: 10px;">
				<tr>
					<td><?php echo $entry_appkey; ?></td>
					<td><input class="form-control"  type="text" name="yotpo_appkey"
						value="<?php echo $yotpo_appkey; ?>"> <?php if ($error_appkey) { ?>
						<span class="error"><?php echo $error_appkey; ?> </span> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_secret; ?></td>
					<td><input class="form-control"  type="text" name="yotpo_secret"
						value="<?php echo $yotpo_secret; ?>"> <?php if ($error_secret) { ?>
						<span class="error"><?php echo $error_secret; ?> </span> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_language; ?></br><?php echo $entry_language_info;?><a href="http://support.yotpo.com/entries/21861473-Languages-Customization-" target="_blank"><?php echo $entry_here;?></a></td>
					<td><input class="form-control"  type="text" name="yotpo_language" maxlength="6"
						value="<?php echo $yotpo_language; ?>"> <?php if ($error_language) { ?>
						<span class="error"><?php echo $error_language; ?> </span> <?php } ?>
					</td>
				</tr>				
				<tr>
					<td><?php echo $entry_widget_location; ?></td>
					<td><select class="form-control"  name="yotpo_widget_location">
					<?php if($yotpo_widget_location == 'footer' ) { ?>
							<option value="footer" selected="selected">
							<?php echo $entry_widget_location_footer; ?>
							</option>
							<?php } else { ?>
							<option value="footer">
							<?php echo $entry_widget_location_footer; ?>
							</option>
							<?php } ?>
							<?php if($yotpo_widget_location == 'tab' ) { ?>
							<option value="tab" selected="selected">
							<?php echo $entry_widget_location_tab; ?>
							</option>
							<?php } else { ?>
							<option value="tab">
							<?php echo $entry_widget_location_tab; ?>
							</option>
							<?php } ?>
							<?php if($yotpo_widget_location == 'other' ) { ?>
							<option value="other" selected="selected">
							<?php echo $entry_widget_location_other; ?>
							</option>
							<?php } else { ?>
							<option value="other">
							<?php echo $entry_widget_location_other; ?>
							</option>
							<?php } ?>
					</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_review_tab_name; ?></td>
					<td><input class="form-control"  type="text" name="yotpo_review_tab_name"
						value="<?php echo $yotpo_review_tab_name; ?>">
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_bottom_line; ?></td>
					<td><?php if($yotpo_bottom_line_enabled == 'on') { ?> <input class="form-control" 
						type='checkbox' name='yotpo_bottom_line_enabled' checked='checked' />
						<?php } else { ?> <input type='checkbox'
						name='yotpo_bottom_line_enabled' /> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_completed_status; ?></td>
					<td>
						<div class="multiselect" style="width:20em;height:10em;border:solid 1px #c0c0c0;overflow:auto;">
						<?php foreach ($order_statuses as $status) { ?>
							<label style="display:block;"><input  type="checkbox" 
										  name="yotpo_map_status[]"										  
										  value="<?php echo $status['order_status_id'] ?>"
										  <?php if(in_array($status['order_status_id'], $yotpo_map_status)) { ?> checked <?php }?>/>
										  <?php echo $status['name'] ?>										  
							</label>
						<?php }?>
						</div>
					</td>
				</tr>					
			</table>
			<?php if($yotpo_widget_location == 'other' ) { ?>
			<div style="color: #8A8A8A">
			<?php echo $text_yotpo_widget_location_other; ?>
				<br> <br>
				<div
					style="font-family: courier, monospace; font-weight: lighter; background: rgb(236, 236, 236); padding: 15px; font-style: italic;">
					&lt;div class=&quot;yotpo yotpo-main-widget&quot; <br>
					data-product-id=&quot;&lt;?php echo $product_id; ?&gt;&quot;<br>
					data-name=&quot;&lt;?php echo $product_name; ?&gt;&quot; <br>
					data-url=&quot;&lt;?php echo $product_url; ?&gt;&quot;<br>
					data-image-url=&quot;&lt;?php echo $product_image_url; ?&gt;&quot;<br>
					data-description=&quot;&lt;?php echo $product_description; ?&gt;&quot;<br>
					data-lang=&quot;&lt;?php echo $language; ?&gt;&quot;&gt;<br>
					&gt;
					&lt;/div&gt;
				</div>
			</div>
			<br>
			<?php } ?>
			<?php if ($yotpo_show_past_orders_button) { ?>
			<div class="buttons" style="padding-left:10px;">
				<a onclick='submit_with_action("<?php echo $past_orders; ?>");'
					class="btn btn-primary"><span><?php echo $entry_past_orders; ?> </span> </a>
			</div>
			<?php } ?>

		</form>
      </div>
    </div>
  </div>
  

</div>


<script type="text/javascript">
	function submit_with_action(action) {
		$("#yotpo_form").attr("action", action);
		$('#yotpo_form').submit();
	}
</script>

<?php echo $footer; ?>