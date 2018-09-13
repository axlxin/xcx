<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-reward" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-reward" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="reward_status" id="input-status" class="form-control">
                <?php if ($reward_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="reward_sort_order" value="<?php echo $reward_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>

<?php $default_currency_code = $this->config->get('config_currency');?>

<div class="form-group">
    <label class="col-sm-2 control-label" for="input-exchange-1">Exchange Rate ( Points to <?php echo $default_currency_code; ?> )</label>
    <div class="col-sm-2">
        <div class="input-group">
            <input type="text" name="reward_points2money" value="<?php echo $reward_points2money; ?>" placeholder="" id="input-exchange-1" class="form-control" />
            <div class="input-group-addon">to 1<?php echo $default_currency_code; ?></div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="input-exchange-2">Exchange Rate ( <?php echo $default_currency_code; ?> to Points )</label>
    <div class="col-sm-2">
        <div class="input-group">
            <div class="input-group-addon">1<?php echo $default_currency_code; ?> to</div>
            <input type="text" name="reward_money2points" value="<?php echo $reward_money2points; ?>" placeholder="" id="input-exchange-2" class="form-control" />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="input-automatically"><span title="" data-toggle="tooltip" data-original-title="(It will add points when change the order status)">Automatically Allocate</span></label>
    <div class="col-sm-2">
        <select name="reward_order_status_id" class="form-control" id="input-automatically">
            <option value="0">-- Disabled --</option>
            <?php foreach ($order_statuses as $order_statuses) { ?>
            <?php if ($order_statuses['order_status_id'] == $reward_order_status_id) { ?>
            <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
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