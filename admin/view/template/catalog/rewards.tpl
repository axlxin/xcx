<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
		<button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_generate; ?>" class="btn btn-primary"><i class="fa fa-save"></i> Save & Generate </button>	  
        <a href="Cancel" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
    <div class="panel-body">
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
		<div class="form-group">
                <label class="col-lg-2 control-label" for="input-points"><span  data-toggle="tooltip" title="(Number of $$$ than can be substituite by 100 points)<br> If you don't want products to be purchased with points leave as 0 or empty."><?php echo $entry_points; ?></span></label>
                <div class="col-lg-10">
                  <input type="text" name="rewards_points" id="input-points" value="<?php if (isset($rewards_points)) {echo $rewards_points;} ?>" placeholder="<?php echo $entry_points; ?>" id="input-points" class="form-control" />
                </div>
        </div>
		
		<div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_customer_group; ?></td>
                      <td class="text-right"><?php echo $entry_reward; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <tr>
                      <td class="text-left"><?php echo $customer_group['name']; ?></td>
					  <td class="text-right"><input type="text" name="rewards_product_reward[<?php echo $customer_group['customer_group_id']; ?>][points]" value="<?php if (isset($rewards_product_reward[$customer_group['customer_group_id']])) {echo $rewards_product_reward[$customer_group['customer_group_id']]['points'];} ?>" class="form-control"/></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
			
			<div class="form-group">
                <label class="col-sm-2 control-label" for="input-order-id"> Auto add reward points when orders statuses are manually changed into</label>
                <div class="col-sm-10">
                  <select name="rewards_auto_order_id" id="input-order-id" class="form-control">
                    <?php array_unshift($orderstatuses, array('order_status_id' => 0, 'name' => '' )); foreach ($orderstatuses as $orderstatus) { ?>
                  <?php if (isset($rewards_auto_order_id) && ($orderstatus['order_status_id'] == $rewards_auto_order_id)) { ?>
                  <option value="<?php echo $orderstatus['order_status_id']; ?>" selected="selected"><?php echo $orderstatus['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $orderstatus['order_status_id']; ?>"><?php echo $orderstatus['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                  </select>
                </div>
             </div>
	      
		 
	</form>
	
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>