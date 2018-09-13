<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  
    <div class="page-header">
      
      
      
      <div class="container-fluid">
         <div class="pull-right">
        <button type="submit" form="form-backup" data-toggle="tooltip" id="export_button" title="<?php echo $button_export; ?>" class="btn btn-default"><i class="fa fa-download"></i></button>
              </div>
        
        
        
          <h1><img src="//www.bluebithosting.co.uk/images/export_pro.png" alt="" /> <?php echo $heading_title; ?></h1>
         
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
         
        </div>
      
      
      
      
      
      
  </div>
  
  
  <div class="container-fluid">

   
     
      <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
      <?php } ?>
      <?php if ($error_memory) { ?>
      <div class="warning memory">
        <?php echo $error_memory; ?>
      </div>
      <?php } ?>
      <div class="box">
        
        <div class="content table-responsive">
          <form action="<?php echo $export_url; ?>" method="post" id="export_form">
            <table class="form table table-bordered table-hover">
              <tr>
                <td style="width:200px"><label for="export_customers"><?php echo $entry_export_customers; ?></label></td>
                <td><input type="checkbox" id="export_customers" name="export_customers" value="1"></td>
              </tr>
              <tr class="joined_date">
                <td><label for="join_date_start"><?php echo $entry_joined_between; ?></label></td>
                <td>
                  <input id="join_date_start" name="join_date_start" type="text" class="date" size="12"> <?php echo $entry_and; ?> <input id="join_date_end" name="join_date_end" type="text" class="date" size="12">
                </td>
              </tr>
			  <tr class="joined_date">
                <td><label for="newsletter"><?php echo $entry_newsletter; ?></label></td>
                <td>
                  <select name="newsletter">
                    <option value="all"></option>
					<option value="0">No</option>
					<option value="1">Yes</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label for="export_orders"><?php echo $entry_export_orders; ?></label></td>
                <td><input type="checkbox" id="export_orders" name="export_orders"></td>
              </tr>
              <tr class="order_options">
                <td><label for="order_date_start"><?php echo $entry_order_date_between; ?></label></td>
                <td>
                  <input id="order_date_start" name="order_date_start" type="text" size="12" class="date"> <?php echo $entry_and; ?> <input id="order_date_end" name="order_date_end" type="text" size="12" class="date">
                </td>
              </tr>
              <tr class="order_options">
                <td><label for="order_id_start"><?php echo $entry_order_id_between; ?></label></td>
                <td>
                  <input id="order_id_start" name="order_id_start" type="text" size="12"> <?php echo $entry_and; ?> <input id="order_id_end" name="order_id_end" type="text" size="12">
                </td>
              </tr>
              <tr class="order_options">
                <td><label for="order_status_id"><?php echo $entry_order_status; ?></label></td>
                <td>
                  <select name="order_status_id">
                    <option value="all"></option>
					<option value="0">Missing Orders</option>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label for="export_order_products"><?php echo $entry_export_order_products; ?></label></td>
                <td><input type="checkbox" id="export_order_products" name="export_order_products"></td>
              </tr>
              <tr>
                <td><label for="filetype">Export as</label></td>
                <td>
                  <select name="filetype" id="filetype">
                    <optgroup label="<?php echo $text_separate_sheets; ?>">
                      <option value="csv"><?php echo $entry_filetype_csv; ?></option>
                      <option value="xls"><?php echo $entry_filetype_xls; ?></option>
                      <option value="xlsx"><?php echo $entry_filetype_xlsx; ?></option>
                    </optgroup>
                    <optgroup label="<?php echo $text_single_sheet; ?>">
                      <option value="csv_single"><?php echo $entry_filetype_csv_single; ?></option>
                      <option value="xls_single"><?php echo $entry_filetype_xls_single; ?></option>
                      <option value="xlsx_single"><?php echo $entry_filetype_xlsx_single; ?></option>
                    </optgroup>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label for="zipped"><?php echo $entry_zipped; ?></label></td>
                <td>
                  <input type="checkbox" name="zipped" id="zipped">
                </td>
              </tr>

            </table>
          </form>
        </div>
      </div>
    </div>

</div>
<script type="text/javascript">
    $('.date').datetimepicker({
        dateFormat: 'yy-mm-dd'
    });

    $('#export_form input[type="checkbox"], select').change(function (e) {
        if ($('#export_customers').is(':checked') && $('#export_orders').is(':not(:checked)') && $('#export_order_products').is(':not(:checked)')) {
            $('.joined_date').show();
        } else {
            $('.joined_date').hide();
        }
        if ($('#export_orders').is(':checked')) {
            $('.order_options').show();
        } else {
            $('.order_options').hide();
        }
        if ($('#filetype').val() == 'csv' && $('#export_customers:checked, #export_orders:checked, #export_order_products:checked').length > 1) {
            $('#zipped').prop('checked', true);
        }
    });

    $('#export_button').click(function () {
        $('#export_form').submit();
    })

</script>

<style type="text/css">
  .order_options {
      display: none;
  }
  .joined_date {
      display: none;
  }
  .warning.memory {
      background-position: 10px 10px;
  }
  .warning.memory p {
      margin: 0 0 10px;
  }
  .warning.memory ul {
      list-style: decimal inside none;
      margin: 0;
      padding: 0;
  }
</style>


<?php echo $footer; ?>