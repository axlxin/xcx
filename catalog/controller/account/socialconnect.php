<?php

class ControllerAccountSocialconnect extends Controller {

    private $error = array();

    public function index() {

        if ($this->customer->isLogged()) {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }

        if (!isset($this->socialconnect)) {
            require_once(DIR_SYSTEM . 'vendor/facebook-sdk/autoload.php');

            $this->socialconnect = new Facebook\Facebook([
                'app_id' => $this->config->get('socialconnect_apikey'),
                'app_secret' => $this->config->get('socialconnect_apisecret'),
                'default_graph_version' => 'v2.4',
            ]);
        }

        $_SERVER_CLEANED = $_SERVER;
        $_SERVER = $this->clean_decode($_SERVER);

        $helper = $this->socialconnect->getRedirectLoginHelper($this->url->link('account/socialconnect', '', 'SSL'));

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error  
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {

            // When validation fails or other local issues  
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens  
        $oAuth2Client = $this->socialconnect->getOAuth2Client();

        // Get the access token metadata from /debug_token  
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // If you know the user ID this access token belongs to, you can validate it here  
        // $tokenMetadata->validateUserId('123');  
        $tokenMetadata->validateExpiration();

        $this->session->data['fb_access_token'] = (string) $accessToken;

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->socialconnect->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $fbuser_profile = $response->getGraphUser();

        $_SERVER = $_SERVER_CLEANED;

        if (isset($fbuser_profile['id']) && isset($fbuser_profile['email'])) {
            $this->load->model('account/customer');

            $email = $fbuser_profile['email'];
            $password = $this->get_password($fbuser_profile['id'], $email);

            if ($this->customer->login($email, $password)) {
                if (isset($this->session->data['redirect'])) {
                    $this->response->redirect($this->session->data['redirect']);
                } else {
                    $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                }
            }

            $email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

            if ($email_query->num_rows) {
                $this->model_account_customer->editPassword($email, $password);
                if ($this->customer->login($email, $password)) {
                    if (isset($this->session->data['redirect'])) {
                        $this->response->redirect($this->session->data['redirect']);
                    } else {
                        $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                    }
                }
            } else {
                $config_customer_approval = $this->config->get('config_customer_approval');
                $this->config->set('config_customer_approval', 0);

                $this->request->post['email'] = $email;

                $add_data = array();
                $add_data['email'] = $fbuser_profile['email'];
                $add_data['password'] = $password;
                $add_data['firstname'] = isset($fbuser_profile['first_name']) ? $fbuser_profile['first_name'] : '';
                $add_data['lastname'] = isset($fbuser_profile['last_name']) ? $fbuser_profile['last_name'] : '';
                $add_data['fax'] = '';
                $add_data['telephone'] = '';
                $add_data['company'] = '';
                $add_data['address_1'] = '';
                $add_data['address_2'] = '';
                $add_data['city'] = '';
                $add_data['postcode'] = '';
                $add_data['country_id'] = 0;
                $add_data['zone_id'] = 0;

                $this->model_account_customer->addCustomer($add_data);
                $this->config->set('config_customer_approval', $config_customer_approval);

                if ($this->customer->login($email, $password)) {
                    unset($this->session->data['guest']);
                    $this->response->redirect($this->url->link('account/success'));
                }
            }
        }

        if (isset($this->session->data['redirect'])) {
            $this->response->redirect($this->session->data['redirect']);
        } else {
            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
        }
    }

    public function google() {

        if ($this->customer->isLogged()) {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }

        $google_client_id = $this->config->get('socialconnect_client_id');
        $google_client_secret = $this->config->get('socialconnect_client_secret');
        $google_redirect_url = $this->url->link('account/socialconnect/google', '', 'SSL'); //path to your script
        $google_developer_key = $this->config->get('socialconnect_developer_key');

        require_once(DIR_SYSTEM . 'vendor/google/Google_Client.php');
        require_once(DIR_SYSTEM . 'vendor/google/contrib/Google_Oauth2Service.php');
        $gClient = new Google_Client();

        $gClient->setApplicationName('Login');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);

        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($this->request->get['code'])) {
            $gClient->authenticate($this->request->get['code']);
            $this->session->data['token'] = $gClient->getAccessToken();


            if (isset($this->session->data['token'])) {
                $gClient->setAccessToken($this->session->data['token']);
            }

            if ($gClient->getAccessToken()) {
                $this->load->model('account/customer');

                $user = $google_oauthV2->userinfo->get();
                $user_name = filter_var($user['given_name'], FILTER_SANITIZE_SPECIAL_CHARS);
                $last_name = filter_var($user['family_name'], FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
                
                $password = $this->get_password($user['id'], $user['email']);

                if ($this->customer->login($email, $password)) {
                    if (isset($this->session->data['redirect'])) {
                        $this->response->redirect($this->session->data['redirect']);
                    } else {
                        $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                    }
                }

                $email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

                if ($email_query->num_rows) {
                    $this->model_account_customer->editPassword($email, $password);
                    if ($this->customer->login($email, $password)) {
                        if (isset($this->session->data['redirect'])) {
                            $this->response->redirect($this->session->data['redirect']);
                        } else {
                            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                        }
                    }
                } else {
                    $config_customer_approval = $this->config->get('config_customer_approval');
                    $this->config->set('config_customer_approval', 0);

                    $add_data = array();
                    $add_data['email'] = $email;
                    $add_data['password'] = $password;
                    $add_data['firstname'] = isset($user_name) ? $user_name : '';
                    $add_data['lastname'] = isset($last_name) ? $last_name : '';
                    $add_data['fax'] = '';
                    $add_data['telephone'] = '';
                    $add_data['company'] = '';
                    $add_data['address_1'] = '';
                    $add_data['address_2'] = '';
                    $add_data['city'] = '';
                    $add_data['postcode'] = '';
                    $add_data['country_id'] = 0;
                    $add_data['zone_id'] = 0;

                    $this->model_account_customer->addCustomer($add_data);
                    $this->config->set('config_customer_approval', $config_customer_approval);

                    if ($this->customer->login($email, $password)) {
                        unset($this->session->data['guest']);
                        $this->response->redirect($this->url->link('account/success'));
                    }
                }

                $this->session->data['token'] = $gClient->getAccessToken();
            }
        } else {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }
    }
    
    public function twitter() {

        if ($this->customer->isLogged()) {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }

        require_once(DIR_SYSTEM . 'vendor/twitter/twitteroauth.php');
            
        $TWITTER_CONSUMER_KEY       = $this->config->get('socialconnect_twitter_consumer_key');
        $TWITTER_CONSUMER_SECRET    = $this->config->get('socialconnect_twitter_consumer_secret');
        $TWITTER_OAUTH_CALLBACK     = $this->url->link('account/socialconnect/twitter', '', 'SSL'); //path to your script
        
        $twitter_connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $this->session->data['request_token'], $this->session->data['request_token_secret']);
	$access_token = $twitter_connection->getAccessToken($_REQUEST['oauth_verifier']);


        if($access_token) {
            $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $params =array();
            $params['include_entities']='false';
            $params['include_email'] = 'true';
            $content = $connection->get('account/verify_credentials',$params);
            
            if($content && isset($content->screen_name) && isset($content->name)) {
                
                $this->load->model('account/customer');
                
                $user_id = filter_var($content->id, FILTER_SANITIZE_SPECIAL_CHARS);
                $user_name = filter_var($content->name, FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_var($content->email, FILTER_SANITIZE_EMAIL);// change email once its done.
                
                $password = $this->get_password($user_id, $email);

                if ($this->customer->login($email, $password)) {
                    if (isset($this->session->data['redirect'])) {
                        $this->response->redirect($this->session->data['redirect']);
                    } else {
                        $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                    }
                }

                $email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

                if ($email_query->num_rows) {
                    $this->model_account_customer->editPassword($email, $password);
                    if ($this->customer->login($email, $password)) {
                        if (isset($this->session->data['redirect'])) {
                            $this->response->redirect($this->session->data['redirect']);
                        } else {
                            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                        }
                    }
                } else {
                    $this->load->model('account/customer');
                    $config_customer_approval = $this->config->get('config_customer_approval');
                    $this->config->set('config_customer_approval', 0);
                    
                    $location = filter_var($content->location, FILTER_SANITIZE_SPECIAL_CHARS);
                    $city = explode(' ', $location);
                    
                    $add_data = array();
                    $add_data['email'] = $email;
                    $add_data['password'] = $password;
                    $add_data['firstname'] = isset($user_name) ? $user_name : '';
                    $add_data['lastname'] = '';
                    $add_data['fax'] = '';
                    $add_data['telephone'] = '';
                    $add_data['company'] = '';
                    $add_data['address_1'] = isset($location) ? $location : '';
                    $add_data['address_2'] = '';
                    $add_data['city'] = $city[0];
                    $add_data['postcode'] = '';
                    $add_data['country_id'] = 0;
                    $add_data['zone_id'] = 0;
                    
                    $this->model_account_customer->addCustomer($add_data);
                    $this->config->set('config_customer_approval', $config_customer_approval);

                    if ($this->customer->login($email, $password)) {
                        unset($this->session->data['guest']);
                        unset($this->session->data['request_token']);
                        unset($this->session->data['request_token_secret']);
                        $this->response->redirect($this->url->link('account/success'));
                    }
                } 

            } else {
                    echo "<h4> Login Error </h4>";
            }
	} else {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }
    }
    
    public function linkedin () {

        if ($this->customer->isLogged()) {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }

        require_once(DIR_SYSTEM . 'vendor/linkedin/http.php');
        require_once(DIR_SYSTEM . 'vendor/linkedin/oauth_client.php');

        $LINKEDIN_CLIENT_ID         = $this->config->get('socialconnect_linkedin_client_id');
        $LINKEDIN_CLIENT_SECRET     = $this->config->get('socialconnect_linkedin_client_secret');
        $LINKEDIN_OAUTH_CALLBACK    = $this->url->link('account/socialconnect/linkedin', '', 'SSL');
        $LINKEDIN_SCOPE = 'r_basicprofile r_emailaddress';
        
        $LOGIN_URL    = $this->url->link('account/login', '', 'SSL');
        
        if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
            // in case if user cancel the login. redirect back to home page.
            echo $_GET["oauth_problem"].'<a href="'.$LOGIN_URL.'">Try Again</a>';
            exit;
        }

        $linkedinvar = new oauth_client_class;

        $linkedinvar->debug = false;
        $linkedinvar->debug_http = true;
        $linkedinvar->redirect_uri = $LINKEDIN_OAUTH_CALLBACK;

        $linkedinvar->client_id = $LINKEDIN_CLIENT_ID;
        $application_line = __LINE__;
        $linkedinvar->client_secret = $LINKEDIN_CLIENT_SECRET;

        if (strlen($linkedinvar->client_id) == 0 || strlen($linkedinvar->client_secret) == 0)
            die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , ' .
                            'create an application, and in the line ' . $application_line .
                            ' set the client_id to Consumer key and client_secret with Consumer secret. ' .
                            'The Callback URL must be ' . $client->redirect_uri) . ' Make sure you enable the ' .
                    'necessary permissions to execute the API calls your application needs.';

        /* API permissions
         */
        $linkedinvar->scope = $LINKEDIN_SCOPE;
        if (($success = $linkedinvar->Initialize())) {
            if (($success = $linkedinvar->Process())) {
                if (strlen($linkedinvar->authorization_error)) {
                    $linkedinvar->error = $linkedinvar->authorization_error;
                    $success = false;
                } elseif (strlen($linkedinvar->access_token)) {
                    $success = $linkedinvar->CallAPI(
                        'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 'GET', 
                            array( 'format' => 'json' ), 
                            array('FailOnAccessError' => true), $user);
                }
            }
            $success = $linkedinvar->Finalize($success);
        }
        if ($linkedinvar->exit) { echo $linkedinvar->exit; echo '. <a href="'.$LOGIN_URL.'">It seems to be some technical issue, please try again</a>'; }
        
        if ($success) {
            
            $this->load->model('account/customer');
                
            $user_id = $user->id;
            $user_name = $user->firstName;
            $user_lastname = $user->lastName;
            $email = filter_var($user->emailAddress, FILTER_SANITIZE_EMAIL);

            $password = $this->get_password($user_id, $email);

            if ($this->customer->login($email, $password)) {
                if (isset($this->session->data['redirect'])) {
                    $this->response->redirect($this->session->data['redirect']);
                } else {
                    $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                }
            }
            
            

            $email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

            if ($email_query->num_rows) {
                $this->model_account_customer->editPassword($email, $password);
                if ($this->customer->login($email, $password)) {
                    if (isset($this->session->data['redirect'])) {
                        $this->response->redirect($this->session->data['redirect']);
                    } else {
                        $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                    }
                }
            } else {
                $this->load->model('account/customer');
                $config_customer_approval = $this->config->get('config_customer_approval');
                $this->config->set('config_customer_approval', 0);

                $add_data = array();
                $add_data['email'] = $email;
                $add_data['password'] = $password;
                $add_data['firstname'] = isset($user_name) ? $user_name : '';
                $add_data['lastname'] = isset($user_lastname) ? $user_lastname : '';;
                $add_data['fax'] = '';
                $add_data['telephone'] = '';
                $add_data['company'] = '';
                $add_data['address_1'] = '';
                $add_data['address_2'] = '';
                $add_data['city'] = '';
                $add_data['postcode'] = '';
                $add_data['country_id'] = 0;
                $add_data['zone_id'] = 0;

                $this->model_account_customer->addCustomer($add_data);
                $this->config->set('config_customer_approval', $config_customer_approval);

                if ($this->customer->login($email, $password)) {
                    unset($this->session->data['guest']);
                    $this->response->redirect($this->url->link('account/success'));
                }
            } 

        } else {
            if (isset($this->session->data['redirect'])) {
                $this->response->redirect($this->session->data['redirect']);
            } else {
                $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            }
        }
    }

    private function get_password($str, $email) {
        $password = $this->config->get('socialconnect_pwdsecret') ? $this->config->get('socialconnect_pwdsecret') : 'fb';
        $password.=substr($email, 0, 3) . substr($str, 0, 3) . substr($email, -3) . substr($str, -3);
        return strtolower($password);
    }

    private function clean_decode($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $data[$this->clean_decode($key)] = $this->clean_decode($value);
            }
        } else {
            $data = htmlspecialchars_decode($data, ENT_COMPAT);
        }

        return $data;
    }

}

?>