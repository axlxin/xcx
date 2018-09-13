<?php
class ControllerModuleMyLiveChat extends Controller {
	public function index() {
		$this->load->language ( 'module/mylivechat' );
		
		$data ['heading_title'] = $this->language->get ( 'heading_title' );
		$mylivechatid = $this->config->get ( 'mylivechat_code' );
		$displaytype = $this->config->get ( 'mylivechat_displaytype' );
		$tempstr = "<script type=\"text/javascript\" defer=\"defer\" src=\"https://www.mylivechat.com/chatinline.aspx?hccid=" . $mylivechatid . "\"></script>";
		switch ($displaytype) {
			case "0" :
				$tempstr = "<script type=\"text/javascript\" defer=\"defer\" src=\"https://www.mylivechat.com/chatinline.aspx?hccid=" . $mylivechatid . "\"></script>";
				break;
			case "1" :
				$tempstr = "<div id=\"MyLiveChatContainer\"></div><script type=\"text/javascript\" defer=\"defer\" src=\"https://www.mylivechat.com/chatbutton.aspx?hccid=" . $mylivechatid . "\"></script>";
				break;
			case "2" :
				$tempstr = "<script type=\"text/javascript\" defer=\"defer\" src=\"https://www.mylivechat.com/chatwidget.aspx?hccid=" . $mylivechatid . "\"></script>";
				break;
			case "3" :
				$tempstr = "<div id=\"MyLiveChatContainer\"></div><script type=\"text/javascript\" defer=\"defer\" src=\"https://www.mylivechat.com/chatbox.aspx?hccid=" . $mylivechatid . "\"></script>";
				break;
			case "4" :
				$tempstr = "<div id=\"MyLiveChatContainer\"></div><script type=\"text/javascript\" defer=\"defer\" src=\"https://www.mylivechat.com/chatlink.aspx?hccid=" . $mylivechatid . "\"></script>";
				break;
			default :
				break;
		}
		$data ['code'] = $tempstr;
		
		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/module/mylivechat.tpl' )) {
			return $this->load->view ( $this->config->get ( 'config_template' ) . '/template/module/mylivechat.tpl', $data );
		} else {
			return $this->load->view ( 'default/template/module/mylivechat.tpl', $data );
		}
	}
}