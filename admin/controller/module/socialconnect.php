<?php

class ControllerModulesocialconnect extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('module/socialconnect');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('socialconnect', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->load->model('localisation/language');

        $languages = $this->model_localisation_language->getLanguages();
        $data['languages'] = $languages;

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_updated'] = $this->language->get('entry_updated');

        $data['entry_facebook_heading'] = $this->language->get('entry_facebook_heading');
        $data['entry_google_heading'] = $this->language->get('entry_google_heading');
        $data['entry_twitter_heading'] = $this->language->get('entry_twitter_heading');
        $data['entry_linkedin_heading'] = $this->language->get('entry_linkedin_heading');
        
        $data['entry_apikey'] = $this->language->get('entry_apikey');
        $data['entry_apisecret'] = $this->language->get('entry_apisecret');
        $data['entry_pwdsecret'] = $this->language->get('entry_pwdsecret');
        $data['entry_pwdsecret_desc'] = $this->language->get('entry_pwdsecret_desc');
        
        $data['entry_socialconnect_twitter_consumer_key'] = $this->language->get('entry_socialconnect_twitter_consumer_key');
        $data['entry_socialconnect_twitter_consumer_key_desc'] = $this->language->get('entry_socialconnect_twitter_consumer_key_desc');
        $data['entry_socialconnect_twitter_consumer_secret'] = $this->language->get('entry_socialconnect_twitter_consumer_secret');
        $data['entry_socialconnect_twitter_consumer_secret_desc'] = $this->language->get('entry_socialconnect_twitter_consumer_secret_desc');


        $data['entry_socialconnect_client_id'] = $this->language->get('entry_socialconnect_client_id');
        $data['entry_socialconnect_client_secret'] = $this->language->get('entry_socialconnect_client_secret');
        $data['entry_socialconnect_developer_key'] = $this->language->get('entry_socialconnect_developer_key');
        $data['entry_socialconnect_client_id_desc'] = $this->language->get('entry_socialconnect_client_id');
        $data['entry_socialconnect_client_secret_desc'] = $this->language->get('entry_socialconnect_client_secret');
        $data['entry_socialconnect_developer_key_desc'] = $this->language->get('entry_socialconnect_developer_key');
        
        $data['entry_socialconnect_linkedin_client_id'] = $this->language->get('entry_socialconnect_linkedin_client_id');
        $data['entry_socialconnect_linkedin_client_secret'] = $this->language->get('entry_socialconnect_linkedin_client_secret');
        
        $data['entry_socialconnect_button'] = $this->language->get('entry_socialconnect_button');
        $data['entry_socialconnect_activate'] = $this->language->get('entry_socialconnect_activate');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/socialconnect', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('module/socialconnect', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


        foreach ($languages as $language) {
            if (isset($this->request->post['socialconnect_button_' . $language['language_id']])) {
                $data['socialconnect_button_' . $language['language_id']] = $this->request->post['socialconnect_button_' . $language['language_id']];
            } else {
                $data['socialconnect_button_' . $language['language_id']] = $this->config->get('socialconnect_button_' . $language['language_id']);
            }

            if (isset($this->request->post['socialconnect_buttong_' . $language['language_id']])) {
                $data['socialconnect_buttong_' . $language['language_id']] = $this->request->post['socialconnect_buttong_' . $language['language_id']];
            } else {
                $data['socialconnect_buttong_' . $language['language_id']] = $this->config->get('socialconnect_buttong_' . $language['language_id']);
            }
            if (isset($this->request->post['socialconnect_twitter_button_' . $language['language_id']])) {
                $data['socialconnect_twitter_button_' . $language['language_id']] = $this->request->post['socialconnect_twitter_button_' . $language['language_id']];
            } else {
                $data['socialconnect_twitter_button_' . $language['language_id']] = $this->config->get('socialconnect_twitter_button_' . $language['language_id']);
            }
            if (isset($this->request->post['socialconnect_linkedin_button_' . $language['language_id']])) {
                $data['socialconnect_linkedin_button_' . $language['language_id']] = $this->request->post['socialconnect_linkedin_button_' . $language['language_id']];
            } else {
                $data['socialconnect_linkedin_button_' . $language['language_id']] = $this->config->get('socialconnect_linkedin_button_' . $language['language_id']);
            }
        }


        if (isset($this->request->post['socialconnect_apikey'])) {
            $data['socialconnect_apikey'] = $this->request->post['socialconnect_apikey'];
        } else {
            $data['socialconnect_apikey'] = $this->config->get('socialconnect_apikey');
        }
        if (isset($this->request->post['socialconnect_apisecret'])) {
            $data['socialconnect_apisecret'] = $this->request->post['socialconnect_apisecret'];
        } else {
            $data['socialconnect_apisecret'] = $this->config->get('socialconnect_apisecret');
        }
        if (isset($this->request->post['socialconnect_pwdsecret'])) {
            $data['socialconnect_pwdsecret'] = $this->request->post['socialconnect_pwdsecret'];
        } else {
            $data['socialconnect_pwdsecret'] = $this->config->get('socialconnect_pwdsecret');
        }
        if (isset($this->request->post['socialconnect_status'])) {
            $data['socialconnect_status'] = $this->request->post['socialconnect_status'];
        } else {
            $data['socialconnect_status'] = $this->config->get('socialconnect_status');
        }


        if (isset($this->request->post['socialconnect_client_id'])) {
            $data['socialconnect_client_id'] = $this->request->post['socialconnect_client_id'];
        } else {
            $data['socialconnect_client_id'] = $this->config->get('socialconnect_client_id');
        }
        if (isset($this->request->post['socialconnect_client_secret'])) {
            $data['socialconnect_client_secret'] = $this->request->post['socialconnect_client_secret'];
        } else {
            $data['socialconnect_client_secret'] = $this->config->get('socialconnect_client_secret');
        }
        if (isset($this->request->post['socialconnect_developer_key'])) {
            $data['socialconnect_developer_key'] = $this->request->post['socialconnect_developer_key'];
        } else {
            $data['socialconnect_developer_key'] = $this->config->get('socialconnect_developer_key');
        }
        
        if (isset($this->request->post['socialconnect_twitter_consumer_key'])) {
            $data['socialconnect_twitter_consumer_key'] = $this->request->post['socialconnect_twitter_consumer_key'];
        } else {
            $data['socialconnect_twitter_consumer_key'] = $this->config->get('socialconnect_twitter_consumer_key');
        }
        if (isset($this->request->post['socialconnect_twitter_consumer_secret'])) {
            $data['socialconnect_twitter_consumer_secret'] = $this->request->post['socialconnect_twitter_consumer_secret'];
        } else {
            $data['socialconnect_twitter_consumer_secret'] = $this->config->get('socialconnect_twitter_consumer_secret');
        }
        
        if (isset($this->request->post['socialconnect_linkedin_client_id'])) {
            $data['socialconnect_linkedin_client_id'] = $this->request->post['socialconnect_linkedin_client_id'];
        } else {
            $data['socialconnect_linkedin_client_id'] = $this->config->get('socialconnect_linkedin_client_id');
        }
        if (isset($this->request->post['socialconnect_linkedin_client_secret'])) {
            $data['socialconnect_linkedin_client_secret'] = $this->request->post['socialconnect_linkedin_client_secret'];
        } else {
            $data['socialconnect_linkedin_client_secret'] = $this->config->get('socialconnect_linkedin_client_secret');
        }
        
        if (isset($this->request->post['socialconnect_facebook_active'])) {
            $data['socialconnect_facebook_active'] = $this->request->post['socialconnect_facebook_active'];
        } else {
            $data['socialconnect_facebook_active'] = $this->config->get('socialconnect_facebook_active');
        }
        if (isset($this->request->post['socialconnect_google_active'])) {
            $data['socialconnect_google_active'] = $this->request->post['socialconnect_google_active'];
        } else {
            $data['socialconnect_google_active'] = $this->config->get('socialconnect_google_active');
        }
        if (isset($this->request->post['socialconnect_twitter_active'])) {
            $data['socialconnect_twitter_active'] = $this->request->post['socialconnect_twitter_active'];
        } else {
            $data['socialconnect_twitter_active'] = $this->config->get('socialconnect_twitter_active');
        }
        if (isset($this->request->post['socialconnect_linkedin_active'])) {
            $data['socialconnect_linkedin_active'] = $this->request->post['socialconnect_linkedin_active'];
        } else {
            $data['socialconnect_linkedin_active'] = $this->config->get('socialconnect_linkedin_active');
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/socialconnect.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/socialconnect')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['socialconnect_apikey'] || !$this->request->post['socialconnect_apisecret'] || !$this->request->post['socialconnect_pwdsecret']) {
            $this->error['code'] = $this->language->get('error_code');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>