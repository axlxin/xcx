<?php

class ControllerModuleSocialconnect extends Controller {

    public function index() {

        $this->language->load('module/socialconnect');
        $data['heading_title'] = $this->language->get('heading_title');

        if (!$this->customer->isLogged()) {
            $data['socialconnect_facebook_active'] = $this->config->get('socialconnect_facebook_active');
            if($data['socialconnect_facebook_active'] == 'YES') {
                if (!isset($this->socialconnect)) {
                    require_once(DIR_SYSTEM . 'vendor/facebook-sdk/autoload.php');
                    $this->socialconnect = new Facebook\Facebook([
                        'app_id' => $this->config->get('socialconnect_apikey'),
                        'app_secret' => $this->config->get('socialconnect_apisecret'),
                        'default_graph_version' => 'v2.4',
                    ]);
                }
                $helper = $this->socialconnect->getRedirectLoginHelper();

                $permissions = ['email']; // Optional permissions
                $data['socialconnect_url'] = $helper->getLoginUrl($this->url->link('account/socialconnect', '', 'SSL'), $permissions);


                if ($this->config->get('socialconnect_button_' . $this->config->get('config_language_id'))) {
                    $data['socialconnect_button'] = html_entity_decode($this->config->get('socialconnect_button_' . $this->config->get('config_language_id')));
                }
                else
                    $data['socialconnect_button'] = $this->language->get('heading_title');
            }

            //GOOGLE LOGIN
            $data['socialconnect_google_active'] = $this->config->get('socialconnect_google_active');
            if($data['socialconnect_google_active'] == 'YES') {
                $google_client_id           = $this->config->get('socialconnect_client_id');
                $google_client_secret 	= $this->config->get('socialconnect_client_secret');
                $google_redirect_url 	= $this->url->link('account/socialconnect/google', '', 'SSL');
                $google_developer_key 	= $this->config->get('socialconnect_developer_key');

                require_once(DIR_SYSTEM . 'vendor/google/Google_Client.php');
                require_once(DIR_SYSTEM . 'vendor/google/contrib/Google_Oauth2Service.php');
                $gClient = new Google_Client();

                $gClient->setApplicationName('Login to Quick Mazad');
                $gClient->setClientId($google_client_id);
                $gClient->setClientSecret($google_client_secret);
                $gClient->setRedirectUri($google_redirect_url);
                $gClient->setDeveloperKey($google_developer_key);

                $google_oauthV2 = new Google_Oauth2Service($gClient);

                $data['authUrl'] = $gClient->createAuthUrl();

                if ($this->config->get('socialconnect_buttong_' . $this->config->get('config_language_id'))) {
                    $data['socialconnect_buttong'] = html_entity_decode($this->config->get('socialconnect_buttong_' . $this->config->get('config_language_id')));
                }
                else
                    $data['google_buttong'] = $this->language->get('heading_title');
            }
            
            //TWITTER LOGIN
            $data['socialconnect_twitter_active'] = $this->config->get('socialconnect_twitter_active');
            if($data['socialconnect_twitter_active'] == 'YES') {
                require_once(DIR_SYSTEM . 'vendor/twitter/twitteroauth.php');

                $TWITTER_CONSUMER_KEY       = $this->config->get('socialconnect_twitter_consumer_key');
                $TWITTER_CONSUMER_SECRET 	= $this->config->get('socialconnect_twitter_consumer_secret');
                $TWITTER_OAUTH_CALLBACK 	= $this->url->link('account/socialconnect/twitter', '', 'SSL');

                $twitter_connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET);
                $request_token = $twitter_connection->getRequestToken($TWITTER_OAUTH_CALLBACK); //get Request Token

                if(	$request_token) {
                    $token = $request_token['oauth_token'];
                    $this->session->data['request_token'] = $token ;
                    $this->session->data['request_token_secret'] = $request_token['oauth_token_secret'];

                    switch ($twitter_connection->http_code) {
                        case 200:
                            $data['socialconnect_twitter_url'] = $twitter_connection->getAuthorizeURL($token);
                            //redirect to Twitter .
                            break;
                        default:
                            echo "Connection with twitter Failed";
                        break;
                    }
                }

                if ($this->config->get('socialconnect_twitter_button_' . $this->config->get('config_language_id'))) {
                    $data['socialconnect_twitter_button'] = html_entity_decode($this->config->get('socialconnect_twitter_button_' . $this->config->get('config_language_id')));
                }
                else
                    $data['socialconnect_twitter_button'] = $this->language->get('heading_title');
            }
            
            //LINKEDIN LOGIN
            $data['socialconnect_linkedin_active'] = $this->config->get('socialconnect_linkedin_active');
            if($data['socialconnect_linkedin_active'] == 'YES') {
                
                $LINKEDIN_OAUTH_CALLBACK    = $this->url->link('account/socialconnect/linkedin', '', 'SSL');
                $data['socialconnect_linkedin_url'] = $LINKEDIN_OAUTH_CALLBACK;

                if ($this->config->get('socialconnect_linkedin_button_' . $this->config->get('config_language_id'))) {
                    $data['socialconnect_linkedin_button'] = html_entity_decode($this->config->get('socialconnect_linkedin_button_' . $this->config->get('config_language_id')));
                }
                else
                    $data['socialconnect_linkedin_button'] = $this->language->get('heading_title');
            }
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/socialconnect.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/module/socialconnect.tpl', $data);
            } else {
                return $this->load->view('default/template/module/socialconnect.tpl', $data);
            }
            

            $this->render();
        }
    }

}

?>