<?php
class ControllerFeedGcrdevSitemap extends Controller {
	private $error=array();
	
	public function generateSitemap() {
		$group=$_GET['group'];
		$this->load->language('feed/gcrdev_sitemap');
		$this->load->model('feed/gcrdev_sitemap');
		
		if($group=='products'){$this->model_feed_gcrdev_sitemap->generateProducts();}
		elseif($group=='categories'){$this->model_feed_gcrdev_sitemap->generateCategories();}
		elseif($group=='brands'){$this->model_feed_gcrdev_sitemap->generateBrands();}
		elseif($group=='pages'){$this->model_feed_gcrdev_sitemap->generatePages();}
		elseif($group=='information'){$this->model_feed_gcrdev_sitemap->generateInformation();}
elseif ($group=='blog') {$this->model_feed_gcrdev_sitemap->generateBlog();} //新增调用方法
		//elseif ($group=='blog') {$this->model_feed_gcrdev_sitemap->generateBlog();} //新增调用方法
		$button_restore_title=$this->language->get('button_restore_title');
		$button_restore=$this->language->get('button_restore');
		
		echo '
		<td class="text-left">'.$group.'</td>
		
		<td class="text-left"><div data-toggle="tooltip" title="sitemap generated" class="btn invisi-btn-gcrdev"><i class="fa fa-check"></i></div></td>
		
		<td class="text-left">
		<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btnrstrplc'.$group.'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
		
		<div type="submit" name="restore_'.$group.'" id="btnrst'.$group.'" data-toggle="tooltip" title="'.$button_restore_title.'" class="btn invisi-btn-gcrdev" onclick="updateSitemap(\'restore\',\''.$group.'\',\'btnrst\',\'btnrstrplc\')">'.$button_restore.'</div>
		</td>
		
		<td class="text-left">
		<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btndltrplc'.$group.'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
		
		<div type="submit" id="btndlt'.$group.'" data-toggle="tooltip" title="delete sitemap" class="btn invisi-btn-gcrdev" onclick="deleteSitemap(\''.$group.'\',\'btndlt\',\'btndltrplc\')"><i class="fa fa-trash-o"></i></div>
		</td>
		
		<td class="text-left">'.date('d M Y').'<br>'.date('H:i:s').'</td>';
		exit();
	}
	
	public function restoreSitemap() {
		$group=$_GET['group'];
		$this->load->language('feed/gcrdev_sitemap');
		$this->load->model('feed/gcrdev_sitemap');
		$this->model_feed_gcrdev_sitemap->restoreSitemap($group);
		$button_restore_title=$this->language->get('button_restore_title');
		$button_restore=$this->language->get('button_restore');
		$text_generate=$this->language->get('text_generate');
		$text_sitemap_gen=$this->language->get('text_sitemap_gen');
		$button_generate_sitemap=$this->language->get('button_generate_sitemap');

		echo '
		<td class="text-left">'.$group.'</td>
		
		<td class="text-left"><div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btnrplc'.$group.'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div><div name="generate_'.$group.'" data-toggle="tooltip" title="'.$text_generate.$group.$text_sitemap_gen.'" class="btn invisi-btn-gcrdev" id="btn'.$group.'" onclick="updateSitemap(\'generate\',\''.$group.'\',\'btn\',\'btnrplc\')">'.$button_generate_sitemap.'</div>
		</td>';

		if($this->model_feed_gcrdev_sitemap->restoreSitemap($group)==true){
			echo '<td class="text-left"><div data-toggle="tooltip" title="sitemap restored" class="btn invisi-btn-gcrdev"><i class="fa fa-check"></i></div></td>';
		}else{
			echo '<td class="text-left"><div data-toggle="tooltip" title="sitemap can not be restored" class="btn invisi-btn-gcrdev"><i class="fa fa-times"></i></div></td>		';
		}

		echo '
		
		<td class="text-left">
		<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btndltrplc'.$group.'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
		
		<div type="submit" id="btndlt'.$group.'" data-toggle="tooltip" title="delete sitemap" class="btn invisi-btn-gcrdev" onclick="deleteSitemap(\''.$group.'\',\'btndlt\',\'btndltrplc\')"><i class="fa fa-trash-o"></i></div>
		</td>
		
		<td class="text-left">'.date('d M Y').'<br>'.date('H:i:s').'</td>';
		exit();
	}
	public function deleteSitemap() {
		$group=$_POST['group'];
		$this->load->language('feed/gcrdev_sitemap');
		$this->load->model('feed/gcrdev_sitemap');
		$this->model_feed_gcrdev_sitemap->deleteSitemap($group);
		$button_restore_title=$this->language->get('button_restore_title');
		$button_restore=$this->language->get('button_restore');
		$text_generate=$this->language->get('text_generate');
		$text_sitemap_gen=$this->language->get('text_sitemap_gen');
		$button_generate_sitemap=$this->language->get('button_generate_sitemap');

		echo '
		<td class="text-left">'.$group.'</td>
		
		<td class="text-left">
		<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btnrplc'.$group.'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
		
		<div name="generate_'.$group.'" data-toggle="tooltip" title="'.$text_generate.$group.$text_sitemap_gen.'" class="btn invisi-btn-gcrdev" id="btn'.$group.'" onclick="updateSitemap(\'generate\',\''.$group.'\',\'btn\',\'btnrplc\')">'.$button_generate_sitemap.'</div>
		</td>
		
		<td class="text-left">
		<div data-toggle="tooltip" class="btn invisi-btn-gcrdev" id="btnrstrplc'.$group.'" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
		
		<div type="submit" name="restore_'.$group.'" id="btnrst'.$group.'" data-toggle="tooltip" title="'.$button_restore_title.'" class="btn invisi-btn-gcrdev" onclick="updateSitemap(\'restore\',\''.$group.'\',\'btnrst\',\'btnrstrplc\')">'.$button_restore.'</div>
		</td>
		
		<td class="text-left"><div data-toggle="tooltip" title="sitemap deleted" class="btn invisi-btn-gcrdev"><i class="fa fa-check"></i></div></td>
		
		<td class="text-left" style="color:red">sitemap not live!</td>';

		exit();
	}
	
	public function updateDisabled() {
		$group=$_GET['group'];
		$this->load->language('feed/gcrdev_sitemap');
		$this->load->model('feed/gcrdev_sitemap');
		$this->model_feed_gcrdev_sitemap->updateIncStatus($group);

	}
	
	public function updateSettings() {
		$table=$_GET['table'];
		$group=$_GET['group'];
		$change=$_POST['change'];
		$this->load->model('feed/gcrdev_sitemap');
		$this->model_feed_gcrdev_sitemap->updateSet($table,$group,$change);
	}
	
	public function updateRobots() {
		$post=$_POST['robotsTxt'];
		$this->load->model('feed/gcrdev_sitemap');
		$this->model_feed_gcrdev_sitemap->generateRobots($post);
	}
	
	public function updateFootTxt() {
		$post=str_replace('\\r\\n', '', $_POST['footTxt']);
		$this->load->model('feed/gcrdev_sitemap');
		$this->model_feed_gcrdev_sitemap->updateFooter($post);
	}

	public function index() {   //GCRdev sitemap 2插件页面设置展示
		$this->load->language('feed/gcrdev_sitemap');
		$this->load->model('feed/gcrdev_sitemap');
		$this->document->setTitle($this->language->get('heading_title')); 

		$this->model_feed_gcrdev_sitemap->notinstalled(DB_PREFIX.'length_class');
		
	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
		if(isset($_POST['install'])){
		$this->model_feed_gcrdev_sitemap->install();
		}
		
		elseif(isset($_POST['save_settings'])){
		$count=count($_POST['indlim']);
		for($i=0;$i<$count;$i++){
		$id=$this->db->escape($_POST['id'][$i]);
		$change=$this->db->escape($_POST['prod_change_freq'][$i]);
		$priority=$this->db->escape($_POST['prod_priority'][$i]);
		$indlim=$this->db->escape($_POST['indlim'][$i]);
		$style=(isset($_POST['prod_style'][$i]))? 1 : 0;
		$this->model_feed_gcrdev_sitemap->updateSettings($id,$change,$priority,$style,$indlim);
		}
		$disprod=(isset($_POST['disprod']))? 1 : 0;
		$disinfo=(isset($_POST['disinfo']))? 1 : 0;
		$discat=(isset($_POST['discat']))? 1 : 0;
		$_SESSION['settingsSaved']=$this->language->get('text_settingsSaved');
		}
		
		elseif(isset($_POST['generate_robots'])){
		$post=$_POST['robots'];
		$this->model_feed_gcrdev_sitemap->generateRobots($post);
		$_SESSION['robGenTrue']=$this->language->get('text_robGenTrue');
		}
		$this->response->redirect($this->url->link('feed/gcrdev_sitemap', 'token='.$this->session->data['token'], true));
		exit();
	}

		$data['warning']=$this->model_feed_gcrdev_sitemap->installalert();
		$data['heading_title']=$this->language->get('heading_title');
		$data['text_sitemap_header']=$this->language->get('text_sitemap_header');
		$data['text_settings_header']=$this->language->get('text_settings_header');
		$data['text_robots_header']=$this->language->get('text_robots_header');
		$data['text_help_header']=$this->language->get('text_help_header');
		$data['text_sitemap']=$this->language->get('text_sitemap');
		$data['text_generate_sitemap']=$this->language->get('text_generate_sitemap');
		$data['text_view_sitemap']=$this->language->get('text_view_sitemap');
		$data['text_robots']=$this->language->get('text_robots');
		$data['text_group']=$this->language->get('text_group');
		$data['text_change']=$this->language->get('text_change');
		$data['text_priority']=$this->language->get('text_priority');
		$data['text_limit']=$this->language->get('text_limit');
		$data['text_style']=$this->language->get('text_style');
		$data['text_robGenTrue']=$this->language->get('text_robGenTrue');
		$data['text_generate']=$this->language->get('text_generate');
		$data['text_sitemap_gen']=$this->language->get('text_sitemap_gen');
		$data['text_resFalse']=$this->language->get('text_resFalse');
		$data['text_resProdTrue']=$this->language->get('text_resProdTrue');
		$data['text_resCatTrue']=$this->language->get('text_resCatTrue');
		$data['text_resBrandTrue']=$this->language->get('text_resBrandTrue');
		$data['text_resInfoTrue']=$this->language->get('text_resInfoTrue');
		$data['text_resPageTrue']=$this->language->get('text_resPageTrue');
		$data['text_sitemap_help']=$this->language->get('text_sitemap_help');
		$data['text_robots_help']=$this->language->get('text_robots_help');
		$data['text_settings_help']=$this->language->get('text_settings_help');
		
		$data['products_sitemap_generated']=$this->language->get('text_prodGenTrue');
		$data['categories_sitemap_generated']=$this->language->get('text_catGenTrue');
		$data['brands_sitemap_generated']=$this->language->get('text_brandGenTrue');
		$data['info_sitemap_generated']=$this->language->get('text_infoGenTrue');
		$data['page_sitemap_generated']=$this->language->get('text_pageGenTrue');
		
		$data['entry_status']=$this->language->get('entry_status');
		$data['entry_data_feed']=$this->language->get('entry_data_feed');
		
		$data['button_generate_robots_title']=$this->language->get('button_generate_robots_title');
		$data['button_generate_robots']=$this->language->get('button_generate_robots');
		$data['button_generate_sitemap_title']=$this->language->get('button_generate_sitemap_title');
		$data['button_generate_sitemap']=$this->language->get('button_generate_sitemap');
		$data['button_restore_title']=$this->language->get('button_restore_title');
		$data['button_restore']=$this->language->get('button_restore');
		$data['button_save_settings']=$this->language->get('button_save_settings');
		$data['button_save_settings_title']=$this->language->get('button_save_settings_title');
		$data['button_view_sitemap']=$this->language->get('button_view_sitemap');
		$data['button_cancel']=$this->language->get('button_cancel');
		
		$data['token']=$this->session->data['token'];
		
		$data['tab_general']=$this->language->get('tab_general');
		
		$data['select_changefreq']=$this->language->get('select_changefreq');
		$data['select_priority']=$this->language->get('select_priority');
		
		$data['error_warning']=(isset($this->error['warning']))? $this->error['warning'] : '';
		
		$data['breadcrumbs']=array();
		$data['breadcrumbs'][]=array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][]=array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true)
		);
		$data['breadcrumbs'][]=array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('feed/gcrdev_sitemap', 'token=' . $this->session->data['token'], true)
		);
		
		
		$data['action']=$this->url->link('feed/gcrdev_sitemap', 'token=' . $this->session->data['token'], true);
		$data['cancel']=$this->url->link('extension/feed', 'token=' . $this->session->data['token'], true);
		$data['header']=$this->load->controller('common/header');
		$data['column_left']=$this->load->controller('common/column_left');
		$data['footer']=$this->load->controller('common/footer');
		$data['prodCheck']=$this->model_feed_gcrdev_sitemap->getSet('products');
		$data['catCheck']=$this->model_feed_gcrdev_sitemap->getSet('categories');
		$data['infoCheck']=$this->model_feed_gcrdev_sitemap->getSet('information');
		$data['footerText']=$this->model_feed_gcrdev_sitemap->getFoot();
		$data['sitemaps']=array();
		
		$this->load->model('feed/gcrdev_sitemap');
		
		$results=$this->model_feed_gcrdev_sitemap->getData();			
		foreach ($results as $result) {
			$data['sitemaps'][]=array(
				'id' => $result['id'],
				'groups' => $result['groups'],
				'change' => $result['changefreq'],
				'priority' => $result['prio'],
				'indlim' => $result['indlim'],
				'style' => $result['prodstyle'],
				'status' => $result['status'],
				'live' => $result['live'],
				'last_update' => date('d M Y', strtotime($result['last_update'])),
				'last_update_time' => date('H:i:s', strtotime($result['last_update']))
			);
		}
		
		$data['store_url']='';
		$query=$this->db->query("SELECT DISTINCT store_id FROM ".DB_PREFIX."setting");
		$stores=$query->rows;
		foreach($stores as $store){
			$store_id=$store['store_id'];
			$query=$this->db->query("SELECT value,store_id FROM ".DB_PREFIX."setting WHERE `store_id`='$store_id' AND `key`='config_url'");
			$config_url=$query->rows;
		foreach($config_url as $config_url){
			$store_id=$config_url['store_id'];
			$data['store_url'] .='<tr>
<td class="text-left">'.preg_replace('#^https?://#', '', rtrim($config_url['value'],'/')).'</td>
<td class="text-left"><a href="http://www.bing.com/webmaster/ping.aspx?siteMap='.$config_url['value'].'sitemap/'.$store_id.'/sitemap-index.xml" target="_blank"><i class="fa fa-windows"></i> bing</td>
<td class="text-left"><a href="http://www.google.com/webmasters/sitemaps/ping?sitemap='.$config_url['value'].'sitemap/'.$store_id.'/sitemap-index.xml" target="_blank"><i class="fa fa-google"></i> google</a></td>
</tr>';
		}
		}
   
		$this->response->setOutput($this->load->view('feed/gcrdev_sitemap.tpl', $data));

	}
	
public function install(){
 $this->load->model('feed/gcrdev_sitemap');
 $this->model_feed_gcrdev_sitemap->install();
}

public function uninstall(){
 $this->load->model('feed/gcrdev_sitemap');
 $this->model_feed_gcrdev_sitemap->uninstall();
}

protected function validate(){
 if(!$this->user->hasPermission('modify', 'feed/gcrdev_sitemap')) {
  $this->error['warning']=$this->language->get('error_permission');
 }
 return !$this->error;
}

}