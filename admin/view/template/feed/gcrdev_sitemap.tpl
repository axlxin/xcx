<?php
$robotstab='';
$settingtab='';
if(isset($_SESSION['settingsSaved'])){$settingtab=' checked';}
if(isset($_SESSION['robGenTrue'])){$robotstab=' checked';}
print $header.$column_left.'
<div id="content">
<div class="page-header">
<div class="container-fluid">
<div class="pull-right">
<a href="'.$cancel.'" data-toggle="tooltip" title="'.$button_cancel.'" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
<h1>'.$heading_title.'</h1>
<ul class="breadcrumb">';
foreach ($breadcrumbs as $breadcrumb){
print '<li><a href="'.$breadcrumb['href'].'">'.$breadcrumb['text'].'</a></li>';
}
print '</ul></div></div>';
echo $warning;
ModelFeedGcrdevSitemap::alert('success',$products_sitemap_generated,'products','alert_products');
ModelFeedGcrdevSitemap::alert('success',$categories_sitemap_generated,'categories','alert_categories');
ModelFeedGcrdevSitemap::alert('success',$brands_sitemap_generated,'brands','alert_brands');
ModelFeedGcrdevSitemap::alert('success',$page_sitemap_generated,'pages','alert_pages');
ModelFeedGcrdevSitemap::alert('success',$page_sitemap_generated,'blog','alert_blog');
ModelFeedGcrdevSitemap::alert('success',$info_sitemap_generated,'information','alert_information');
ModelFeedGcrdevSitemap::alert('success','Success! settings have been updated','','disalert');
ModelFeedGcrdevSitemap::alert('success','Success! robots.txt file has been updated','','robalert');
ModelFeedGcrdevSitemap::alert('success','Success! footer text has been updated','','footalert');

print ' 
<main>
<div class="tab-content"> 
<input id="tab1" type="radio" name="tabs" checked>
<label for="tab1">Sitemap</label>    
<input id="tab2" type="radio" name="tabs"'.$robotstab.'>
<label for="tab2">Robots</label>    
<input id="tab3" type="radio" name="tabs"'.$settingtab.'>
<label for="tab3">Settings</label>    
<input id="tab4" type="radio" name="tabs">
<label for="tab4">Help</label>     
<section id="content1">
<form method="post"> 
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-sitemap"></i> '.$text_sitemap_header.'</h3>
</div>    
<div class="panel-body">
<table class="table table-hover">
<thead>
<tr>
<td class="text-left">'.$text_group.'</td>
<td class="text-left">'.$text_generate.'</td>
<td class="text-left">restore</td>
<td class="text-left">delete</td>
<td class="text-left">last updated</td>
</tr>
</thead>
<tbody>';

$i=0;
if ($sitemaps) {
foreach ($sitemaps as $sitemap) {
print '<input type="hidden" name="id[]" value="'.$sitemap['id'].'">
<tr  id="Update'.$sitemap['groups'].'">

<td class="text-left">'.$sitemap['groups'].'</td>

<td class="text-left">
<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btnrplc'.$sitemap['groups'].'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>

<div name="generate_'.$sitemap['groups'].'" data-toggle="tooltip" title="'.$text_generate.$sitemap['groups'].$text_sitemap_gen.'" class="btn invisi-btn-gcrdev" id="btn'.$sitemap['groups'].'" onclick="updateSitemap(\'generate\',\''.$sitemap['groups'].'\',\'btn\',\'btnrplc\')">'.$button_generate_sitemap.'</div>
</td>

<td class="text-left">
<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btnrstrplc'.$sitemap['groups'].'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
<div type="submit" name="restore_'.$sitemap['groups'].'" id="btnrst'.$sitemap['groups'].'" data-toggle="tooltip" title="'.$button_restore_title.'" class="btn invisi-btn-gcrdev" onclick="updateSitemap(\'restore\',\''.$sitemap['groups'].'\',\'btnrst\',\'btnrstrplc\')">'.$button_restore.'</div>
</td>

<td class="text-left">
<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btndltrplc'.$sitemap['groups'].'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>


<div type="submit" id="btndlt'.$sitemap['groups'].'" data-toggle="tooltip" title="delete sitemap" class="btn invisi-btn-gcrdev" onclick="deleteSitemap(\''.$sitemap['groups'].'\',\'btndlt\',\'btndltrplc\')"><i class="fa fa-trash-o"></i></div>
</td>


<td class="text-left">';
if($sitemap['live']==1){
print ($sitemap['last_update']=='01 Jan 1970')? 'never' : $sitemap['last_update'].'<br>'.$sitemap['last_update_time'];
}else{
print '<font style="color:red">sitemap not live!</font>';
}
print '</td></tr>';
}}
print '
</tbody>
</table>
<table class="table table-hover">
<thead>
<tr>
<td class="text-left">submit sitemap</td>
</tr>
</thead>
<tbody>
'.$store_url.'
</tbody>
</table>
</div>
</div>
</div>
</form>
</section>  
<section id="content2">
<form method="post">
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-bug"></i>'.$text_robots_header.'</h3>
</div>      
<div class="panel-body">
<div class="panel-heading">        
<h3 class="panel-title">'.$text_robots.'</h3>
</div>
<textarea name="robots" id="robotsTxt" placeholder="enter sitemap information here" style="width:100%;height:100px;" onchange="updateRobots()">';
if(file_exists('../robots.txt')){
print file_get_contents('../robots.txt');
}
print '</textarea>
<div class="pull-right">
<div type="submit" name="generate_robots" data-toggle="tooltip" title="'.$button_generate_robots_title.'" class="btn invisi-btn-gcrdev">'.$button_generate_robots.'</div>
</div>
</div>
</div>
</div>
</form>
</section>    
<section id="content3">
<form method="post"> 
<div class="container-fluid">';
if($error_warning){
print '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '.$error_warning.'
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>';
}
print '<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-cogs"></i>'.$text_settings_header.'</h3>
</div>    
<div class="panel-body">
<table class="table table-hover">
<thead>
<tr>
<td>include disabled?</td>
</tr>
</thead>
<tbody>
<tr>';
print '<td class="text-centre" style="width:33%">
products<div class="switch">
<label>
<input type="checkbox" onclick="updateDisabled(\'products\')" name="disprod" class="ios-switch green"'.$prodCheck.' /><div><div></div></div>
</label>
</div></td>

<td class="text-centre" style="width:33%">
categories<div class="switch">
<label>
<input type="checkbox" onclick="updateDisabled(\'categories\')" name="discat" class="ios-switch green"'.$catCheck.' /><div><div></div></div>
</label>
</div></td>

<td class="text-centre" style="width:33%">information<div class="switch">
<label>
<input type="checkbox" onclick="updateDisabled(\'information\')" name="disinfo" class="ios-switch green"'.$infoCheck.' /><div><div></div></div>
</label>
</div></td>

</tr>
</tbody>
</table>
<table class="table table-bordered table-hover">
<thead>
<tr>
<td class="text-left">'.$text_group.'</td>
<td class="text-left">'.$text_change.'</td>
<td class="text-left">'.$text_priority.'</td>
<td class="text-left">'.$text_limit.'</td>
<td class="text-left" style="width:50px;">'.$text_style.'</td>
</tr>
</thead>
<tbody>';
$i=0;
if($sitemaps){
foreach($sitemaps as $sitemap){
print '
<input type="hidden" name="id[]" value="'.$sitemap['id'].'">
<tr>
<td class="text-left">'.$sitemap['groups'].'</td>
<td class="text-center">
<select id="change'.$sitemap['groups'].'changefreq" onChange="updateSelect(\''.$sitemap['groups'].'\',\'changefreq\')" class="form-control">
<option disabled>Change frequency</option>';
$change=array('never'=>'never','always'=>'always','hourly'=>'hourly','daily'=>'daily','weekly'=>'weekly','monthly'=>'monthly','yearly'=>'yearly');
foreach($change as $view=>$value){
$selected=($sitemap['change'] == $value)? " selected" : "";
echo '<option'.$selected.' value="'.$value.'">'.$view.'</option>';
}
print '
</select>
</td>
<td class="text-center">
<select id="change'.$sitemap['groups'].'prio" onChange="updateSelect(\''.$sitemap['groups'].'\',\'prio\')" class="form-control">
<option disabled>Priority</option>';
$priority=array('1.0'=>'1.0','0.9'=>'0.9','0.8'=>'0.8','0.7'=>'0.7','0.6'=>'0.6','0.5'=>'0.5','0.4'=>'0.4','0.3'=>'0.3','0.2'=>'0.2','0.1'=>'0.1','0.0'=>'0.0');
foreach($priority as $view=>$value){
$selected=($sitemap['priority'] == $value)? "selected" : "";
echo '<option '.$selected.' value="'.$value.'">'.$view.'</option>';
}
print '
</select>
</td>
<td class="text-center">
<input type="number" class="table-input" value="'.$sitemap['indlim'].'" min="1" max="10000" id="change'.$sitemap['groups'].'indlim" onChange="updateSelect(\''.$sitemap['groups'].'\',\'indlim\')">
</td>
<td class="text-center">';
echo ($sitemap['style']==1)? '<input type="checkbox" name="prod_style['.$i.']" id="change'.$sitemap['groups'].'prodstyle" onChange="updateSelect(\''.$sitemap['groups'].'\',\'prodstyle\')" checked>' : '<input type="checkbox" name="prod_style['.$i.']" id="change'.$sitemap['groups'].'prodstyle" onChange="updateSelect(\''.$sitemap['groups'].'\',\'prodstyle\')">';
$i++;
print '</td></tr>';
}}
print '</tbody></table>

<table class="table table-hover">
<thead>
<tr>
<td>foot text</td>
</tr>
</thead>
<tbody>
<tr>

<td class="text-centre">
<textarea class="table-input" id="footTxt" placeholder="enter footer text here" style="text-align:center;resize: none;" onchange="updateFootTxt()">'.$footerText.'</textarea>
</td>
</tbody>
</table>


</div>
</div>
</div>
</form>
</section>
<section id="content4">
<form>
<div class="container-fluid">
<input id="tab5" type="radio" name="tabs" checked>
<label for="tab5">Sitemap</label>
<input id="tab6" type="radio" name="tabs">
<label for="tab6">Robots</label>
<input id="tab7" type="radio" name="tabs">
<label for="tab7">Settings</label>
<section id="content5">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-question"></i>Sitemap '.$text_help_header.'</h3>
</div>         
<div class="panel-body">
'.$text_sitemap_help.'
</div>
</div>
</section>
<section id="content6">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-question"></i>Robots '.$text_help_header.'</h3>
</div>         
<div class="panel-body">
'.$text_robots_help.'
</div>
</div>
</section>
<section id="content7">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-question"></i>Settings '.$text_help_header.'</h3>
</div>         
<div class="panel-body">
'.$text_settings_help.'
</div>
</div>
</section>
</div>
</form>
</section>
</div>  
</main>
</div>
'.$footer.'
<style>*, *:before, *:after{ margin: 0;padding: 0;box-sizing: border-box;} p{ margin: 0 0 20px;line-height: 1.5;} .text-centre{ text-align:center;} main{ min-width: 320px;max-width: 100%;padding: 50px;padding-top:0;margin: 0 auto;} section { display: none;padding: 20px 0 0;border-top: 1px solid #ddd;} .tab-content input[type="radio"] { display: none;} .tab-content label{ display:inline-block;margin:0 0 -1px;padding:15px 25px;font-weight:600;text-align:center;color:#bbb;border:1px solid transparent;} .tab-content label:before{ font-family: fontawesome;font-weight: normal;margin-right: 10px;}.tab-content label[for*=\'1\']:before{ content: \'\f0e8\';}.tab-content label[for*=\'2\']:before{ content: \'\f188\';}.tab-content label[for*=\'3\']:before{ content: \'\f085\';}.tab-content label[for*=\'4\']:before{ content: \'\f128\';}.tab-content label[for*=\'5\']:before{ content: \'\f0e8\';}.tab-content label[for*=\'6\']:before{ content: \'\f188\';}.tab-content label[for*=\'7\']:before{ content: \'\f085\';}.tab-content label:hover{ color:#888;cursor:pointer;}.tab-content input[type="radio"]:checked+label{cursor:text;}input:checked + label{ color:#555;border:1px solid #ddd;border-top:2px solid #737373;border-bottom:1px solid #fff;}#tab1:checked ~ #content1, #tab2:checked ~ #content2, #tab3:checked ~ #content3, #tab4:checked ~ #content4, #tab5:checked ~ #content5, #tab6:checked ~ #content6, #tab7:checked ~ #content7 { display: block;}

::-webkit-scrollbar {width:5px;height:5px;} 
::-webkit-scrollbar-track {background-color:#DBDBDB;} 
::-webkit-scrollbar-thumb {background-color:rgba(0, 0, 0, 0.2);} 
::-webkit-scrollbar-corner {background-color:black;} 
::-webkit-scrollbar {width:5px;height:5px;} 
::-webkit-scrollbar-track {background-color:#DBDBDB;} 
::-webkit-scrollbar-thumb {background-color:#737373;} 
::-webkit-scrollbar-corner {background-color:#DBDBDB;} 

.invisi-btn-gcrdev{ font-weight:bold;font-size:20px;background-color:transparent;border:0;outline:0;cursor:pointer;} .btn-gcrdev-save{ font-weight:bold;font-size:20px;background-color:transparent;border:0;outline:0;cursor:pointer;padding:15px;} .btn-gcrdev{ font-weight:bold;font-size:18px;background-color:transparent;border:0;outline:0;cursor:pointer;padding:10px;margin-top:1%;box-shadow: 0px 0px 0px, 0 2px 3px 0;} .btn-gcrdev:active{ color:#737373;box-shadow: 0px 0px 0px, 0 1px 5px 0;} .table-input{ width:100%;padding:5px;} input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none;-moz-appearance: none;appearance: none;margin: 0;}select::-ms-expand { display: none;} select{ -webkit-appearance: none;-moz-appearance: none;text-indent: 1px;text-overflow: \'\';cursor:pointer;} .switch input[type="checkbox"]{ position:absolute;opacity:0;} .switch input[type="checkbox"].ios-switch + div{ vertical-align:middle;width:100%;height:20px;border:1px solid rgba(0,0,0,.4);border-radius:999px;background-color:#FFFFF;-webkit-transition-duration:.4s;-webkit-transition-property:background-color, box-shadow;box-shadow:inset 0 0 0 0px rgba(0,0,0,0.4);content:"x";} .switch input[type="checkbox"].green.ios-switch:checked + div{background-color:#02C24D;border:1px solid #02C24D;box-shadow:inset 0 0 0 10px #02C24D;-webkit-transition-timing-function:cubic-bezier(.54,1.85,.5,1);} .switch input[type="checkbox"].ios-switch + div > div{ float:left;width:100%;height:100%;border-radius:inherit;background:#F10202;-webkit-transition-timing-function:cubic-bezier(.54,1.85,.5,1);-webkit-transition-duration:0.4s;-webkit-transition-property:transform, background-color, box-shadow;-moz-transition-timing-function:cubic-bezier(.54,1.85,.5,1);-moz-transition-duration:0.4s;-moz-transition-property:transform, background-color;box-shadow:0px 0px 5px #F10202, 0px 0px 0 1px #F10202;pointer-events:none;}.switch input[type="checkbox"].green.ios-switch:checked + div > div{ display:none;} .panel-default{ overflow:auto;} @media screen and (max-width: 650px){label {font-size: 0;}.tab-content  label:before {margin: 0;font-size: 18px;}} @media screen and (max-width: 400px){ label{ padding: 15px;} }.alert{float:right;margin-right:50px;}</style>';
?>
<script type="text/javascript">
function deleteSitemap(id,btn,btnrplc) {
	document.getElementById(btn+id).style.display= 'none' ;
	document.getElementById(btnrplc+id).style.display= 'inherit' ;
	$.ajax({
		type: 'POST',
		url: 'index.php?route=feed/gcrdev_sitemap/deleteSitemap&group='+id+'&token=<?php echo $token;?>',
		data: {group: id},
		success: (function (result) {
			$("#Update"+id).html(result);
			document.getElementById('alert_products').style.display= 'none' ;
			document.getElementById('alert_categories').style.display= 'none' ;
			document.getElementById('alert_brands').style.display= 'none' ;
			document.getElementById('alert_pages').style.display= 'none' ;
			document.getElementById('alert_information').style.display= 'none';
			document.getElementsById('alert_blog').style.display = 'none'; //增加代码
			document.getElementById('alert_'+id).style.display= 'block' ;
			$("#alert_" +id).delay(3000).fadeOut();
		})
	})
};
function updateSitemap(action,id,btn,btnrplc) {
	document.getElementById(btn+id).style.display= 'none' ;
	document.getElementById(btnrplc+id).style.display= 'inherit' ;
	$.ajax({
		type: 'POST',
		url: 'index.php?route=feed/gcrdev_sitemap/'+action+'Sitemap&group='+id+'&token=<?php echo $token;?>',
		success: (function (result) {
			$("#Update"+id).html(result);
			document.getElementById('alert_products').style.display= 'none' ;
			document.getElementById('alert_categories').style.display= 'none' ;
			document.getElementById('alert_brands').style.display= 'none' ;
			document.getElementById('alert_pages').style.display= 'none' ;
			document.getElementById('alert_information').style.display= 'none' ;
			document.getElementById('alert_blog').style.display = 'none';//增加代码
			document.getElementById('alert_'+id).style.display= 'block' ;
			$("#alert_" +id).delay(3000).fadeOut();
		})
	})
};

function updateDisabled(id) {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=feed/gcrdev_sitemap/updateDisabled&group='+id+'&token=<?php echo $token;?>',
		success: (function (result) {
			document.getElementById('disalert').style.display= 'none' ;
			document.getElementById('disalert').style.display= 'block' ;
		$("#disalert").delay(3000).fadeOut();
		})
	})
};

function updateSelect(id,tbl) {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=feed/gcrdev_sitemap/updateSettings&table='+tbl+'&group='+id+'&token=<?php echo $token;?>',
		data: {change: $('#change'+id+tbl).val()},
		success: (function (result) {
			document.getElementById('disalert').style.display= 'none' ;
			document.getElementById('disalert').style.display= 'block' ;
			$("#disalert").delay(3000).fadeOut();
		})
	})
};

function updateRobots() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=feed/gcrdev_sitemap/updateRobots&token=<?php echo $token;?>',
		data: {robotsTxt: $('#robotsTxt').val()},
		success: (function (result) {
			document.getElementById('robalert').style.display= 'block' ;
			$("#robalert").delay(3000).fadeOut();
		})
	})
};

function updateFootTxt() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=feed/gcrdev_sitemap/updateFootTxt&token=<?php echo $token;?>',
		data: {footTxt: $('#footTxt').val()},
		success: (function (result) {
			document.getElementById('footalert').style.display= 'block' ;
			$("#footalert").delay(3000).fadeOut();
		})
	})
};
</script>