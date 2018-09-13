<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-guest-name"><?php echo $entry_guest_name; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $guest_name; ?>" name="guest_name" placeholder="<?php echo $entry_guest_name; ?>" id="input-guest-name" class="form-control" size="10" />
              <?php if ($error_guest_name) { ?>
              <div class="text-danger"><?php echo $error_guest_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-guest-message"><?php echo $entry_guest_message; ?></label>
            <div class="col-sm-10">
              <textarea name="guest_message" placeholder="<?php echo $entry_guest_message; ?>" id="input-guest-message" class="form-control"><?php echo $guest_message; ?></textarea>
              <?php if ($error_guest_message) { ?>
              <div class="text-danger"><?php echo $error_guest_message; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-10">
              <input type="submit" value="<?php echo $entry_submit; ?>" class="btn btn-primary" />
            </div>
          </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>