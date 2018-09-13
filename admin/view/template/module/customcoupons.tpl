<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
   <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" onclick="$('#form').submit();" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
   </div>
 </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>

  <div class="box">
    <div class="container-fluid">      
        <?php if ($error_warning) { ?>
       <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
         <button type="button" class="close" data-dismiss="alert">&times;</button>
       </div>
       <?php } ?>
       <?php if($success) { ?>
       <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
         <button type="button" class="close" data-dismiss="alert">&times;</button>
       </div>
       <?php } ?>
    <div class="panel panel-default">
    <div class="panel-body">      
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" id="form" >
      <div id="tab-general">
        <table id="module" class="table table-striped table-bordered table-hover">
            <tr>
              <td class="text-left"><?php echo $text_enable_custom_coupons; ?></td>
              <td class="text-left">
		<input type='radio' name="config_custom_coupons" id="config_custom_coupons" value="Y" <?php if ($config_custom_coupons == 'Y'){ echo 'checked'; }?> > Yes
                <input type='radio' name="config_custom_coupons" id="config_custom_coupons" value="N" <?php if ($config_custom_coupons !== 'Y'){ echo 'checked'; }?> > No
	      </td>              
           </tr>           
        </table>
      </div>
      </form>
    </div>
   <div style="text-align:right;color:#ccc;font-size10px;padding:7px;"><?php echo $heading_title; ?> v2.0 - powered by Bytes Technolab<br><a mailto='info@bytestechnolab.com'>info@bytestechnolab.com</a></div>   
  </div>
 </div>     
</div>
<?php echo $footer; ?>
<script lang="javascript">
    $('#form').submit(function(){
        return true;
    });
</script>