<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
   <div class="page-header">
    <div class="container-fluid">
      <h1>&nbsp;<?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">   
 <?php echo (empty($data['SignUpCoupons']['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNzdXBwb3J0XScpLnRyaWdnZXIoJ2NsaWNrJykiPkVudGVyIHlvdXIgbGljZW5zZSBjb2RlPC9hPg0KICAgIDwvZGl2Pg==') : '' ?>
  <?php if ($error_warning) { ?>
            <div class="alert alert-danger autoSlideUp"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
             <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success autoSlideUp"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
  <script> $('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
      <?php } ?>    
  <div class="panel panel-default">
        <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;"><?php echo $text_module_settings; ?></span></h3>
            <div class="storeSwitcherWidget">
              <div class="form-group">
                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-pushpin"></span>&nbsp;<?php echo $store['name']; if($store['store_id'] == 0) echo $text_default; ?>&nbsp;<span class="caret"></span><span class="sr-only"><?php echo $text_toggle_dropdown; ?>/span></button>
                  <ul class="dropdown-menu" role="menu">
                      <?php foreach ($stores  as $st) { ?>
                        <li><a href="index.php?route=module/signupcoupons&store_id=<?php echo $st['store_id'];?>&token=<?php echo $token; ?>"><?php echo $st['name']; ?></a></li>
                      <?php } ?> 
                  </ul>
              </div>
            </div>
        </div>
        <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
            <input type="hidden" name="signupcoupons_status" value="1" />
                <div class="tabbable">
          <div class="tab-navigation">
            <ul class="nav nav-tabs mainMenuTabs">
              <li class="active"><a href="#controlpanel" data-toggle="tab"><i class="icon-wrench"></i><?php echo $text_settings; ?></a></li>
              <li><a href="#template" data-toggle="tab"><i class="icon-envelope"></i><?php echo $text_mail; ?></a></li>
                            <li><a href="#notification" data-toggle="tab"><i class="icon-bookmark"></i><?php echo $text_store_front_stripe; ?></a></li>
              <li><a href="#support" data-toggle="tab"><i class="icon-share"></i><?php echo $text_support; ?></a></li>
            </ul>
            <div class="tab-buttons">
              <button type="submit" class="btn btn-primary save-changes"><i class="icon-ok"></i><?php echo $text_save_changes; ?></button>
            </div>
          </div>
          <div class="tab-content">
                    
                     <?php
                        if (!function_exists('modification_vqmod')) {
                          function modification_vqmod($file) {
                            if (class_exists('VQMod')) {
                              return VQMod::modCheck(modification($file), $file);
                            } else {
                              return modification($file);
                            }
                          }
                        }
            ?>
                    
                    
            <div id="controlpanel" class="tab-pane active">

              <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/'.$module_path.'/tab_settings.php'); ?>
            </div>
            <div id="template" class="tab-pane">
              <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/'.$module_path.'/tab_template.php'); ?>
            </div>
                        <div id="notification" class="tab-pane">
              <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/'.$module_path.'/tab_notification.php'); ?>
            </div>
            <div id="support" class="tab-pane">
              <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/'.$module_path.'/tab_support.php'); ?>
            </div>
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.tabbable -->
      </form>
    </div>
  </div>
<script>
  if (window.localStorage && window.localStorage['currentTab']) {
    $('.mainMenuTabs a[href='+window.localStorage['currentTab']+']').trigger('click');  
  }
  if (window.localStorage && window.localStorage['currentSubTab']) {
    $('a[href='+window.localStorage['currentSubTab']+']').trigger('click');  
  }
  $('.fadeInOnLoad').css('visibility','visible');
  $('.mainMenuTabs a[data-toggle="tab"]').click(function() {
    if (window.localStorage) {
      window.localStorage['currentTab'] = $(this).attr('href');
    }
  });
  $('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"])').click(function() {
    if (window.localStorage) {
      window.localStorage['currentSubTab'] = $(this).attr('href');
    }
  });
</script>
<?php echo $footer; ?>