<?php echo $header; ?>
<div id="container" class="container j-container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
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
        <?php if (isset($success)) { ?>
          <div class="success">
            <?php echo $success; ?>
          </div>
          <br />
          <?php if (isset($discount_text)) { echo $discount_text; } ?>
          <br /><br />
        <?php } else if (isset($errors)) { ?>
          <div class="warning">
            <strong><?php echo (isset($errors)) ? $errors : ''; ?></strong><br />
            <ul>
              <?php if (isset($errorsArray)) { foreach ($errorsArray as $error) { ?>
                <li><?php echo $error; ?></li>
              <?php } } ?>
            </ul>
          </div>
        <?php } ?>
        <?php if (isset($FormData)) { ?>
            <?php echo $FormData; ?>
        <?php } else { ?>
              <div class="buttons">
               		<div class="pull-right"><?php if (isset($errors)) { ?><a href="javascript:history.back();" class="btn btn-warning"><?php echo $button_back; ?></a>&nbsp;&nbsp;<?php } ?><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
              	</div>
        <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?> 