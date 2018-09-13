<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title;?></h3>
      </div>
      <div class="panel-body">
        <div id="pim"></div>      
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$().ready(function() {
		var elf = $('#pim').elfinder({
			url : 'index.php?route=common/filemanager/connector&token=<?php echo $token; ?>',  // connector URL (REQUIRED)
			lang : '<?php echo $lang;?>', /* Setup your language here! */
			dirimage: '<?php echo HTTP_CATALOG."image/";?>', 
			height: '<?php echo ($height);?>',
      uiOptions : {toolbar : [['home', 'back', 'forward'],['reload'],['mkdir', 'upload'],['open', 'download', 'getfile'],['info'],['quicklook'],['copy', 'cut', 'paste'],['rm'],['duplicate', 'rename', 'edit', 'resize'],['extract', 'archive', 'sort'],['search'],['view'],['help']]},		
      contextmenu: {navbar: ["open", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "info"],cwd: ["reload", "back", "|", "upload", "mkdir", "mkfile", "paste", "|", "sort", "|", "info"],files: ["getfile", "|", "open", "quicklook", "|", "download", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "edit", "rename", "resize", "|", "archive","extract", "|", "info"]},
		}).elfinder('instance');
	});
//--></script>
<?php echo $footer; ?>