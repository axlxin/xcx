<?php
//==============================================================================
// MailChimp Integration Pro v3
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

class ControllerModuleMailchimpIntegration extends Controller {
	private $type = 'module';
	private $name = 'mailchimp_integration';
	
	public function index() {
		$this->response->redirect($this->url->link('extension/' . $this->type . '/' . $this->name, 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>