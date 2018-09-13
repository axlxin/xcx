<?php
class ControllerShippingapiShipping extends Controller {
private $extension 				= 'ocaaspro';
	private $type 					= 'shipping';
	private $db_table				= 'advanced_shipping_pro';
	
	private $debugStatus;
	
	private $cartGeoZones;
	private $cartProducts;
	
	private $savedCart;
	
	private $ukFormats;
	
	private $rateTypes;
	
	private $rateFormat1;
	private $rateFormat2;
	private $rateFormat3;
	private $rateFormat4;
	
	private $combinations;
	private $rateGroups;
	
	private function construct($address, $pcb=false, $pcb_cartProducts=null, $pcb_savedCart=null) {
		$this->debugStatus			= $this->field('debug');
		$this->cartGeoZones			= $this->getGeoZones($address);
		
		if(!$pcb){
		   // $this->cartProducts			= $this->getProducts();
		     $this->cartProducts			= array();
		   // $this->savedCart			= $this->saveCart();
		}else{
		    $this->cartProducts			= $pcb_cartProducts;
		    $this->savedCart			= $pcb_savedCart;
		}

		
		$uk_formats 	= array();
		$uk_formats[]	= array(
			'regex'	=> '/^([A-Z]{2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2})$/',
			'start'	=> 'AA0A0AA',
			'end'	=> 'ZZ9Z9ZZ'
		);
		$uk_formats[]	= array(
			'regex'	=> '/^([A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2})$/',
			'start'	=> 'A0A0AA',
			'end'	=> 'Z9Z9ZZ'
		);
		$uk_formats[]	= array(
			'regex'	=> '/^([A-Z]{1}[0-9]{2}[A-Z]{2})$/',
			'start'	=> 'A00AA',
			'end'	=> 'Z99ZZ'
		);
		$uk_formats[]	= array(
			'regex'	=> '/^([A-Z]{1}[0-9]{3}[A-Z]{2})$/',
			'start'	=> 'A000AA',
			'end'	=> 'Z999ZZ'
		);
		$uk_formats[]	= array(
			'regex'	=> '/^([A-Z]{2}[0-9]{2}[A-Z]{2})$/',
			'start'	=> 'AA00AA',
			'end'	=> 'ZZ99ZZ'
		);
		$uk_formats[]	= array(
			'regex'	=> '/^([A-Z]{2}[0-9]{3}[A-Z]{2})$/',
			'start'	=> 'AA000AA',
			'end'	=> 'ZZ999ZZ'
		);
		$this->ukFormats	= $uk_formats;
		
		$this->rateTypes	= array('cart_quantity', 'cart_total', 'cart_weight', 'cart_volume', 'cart_dim_weight', 'cart_distance', 'product_quantity', 'product_total', 'product_weight', 'product_volume', 'product_dim_weight');
		
		$this->rateFormat1	= '/^([0-9.]+|~):([0-9.%]+)$/';
		$this->rateFormat2	= '/^([0-9.]+|~):([0-9.%]+)\+([0-9.%]+)$/';
		$this->rateFormat3	= '/^([0-9.]+|~):([0-9.%]+)\/([0-9.]+)$/';
		$this->rateFormat4	= '/^([0-9.]+|~):([0-9.%]+)\/([0-9.]+)\+([0-9.%]+)$/';
		
		$rate_groups 		= array();
		$this->combinations = $this->field('combinations');
		if ($this->combinations) {
			foreach ($this->combinations as $key => $value) {
				$rate_groups[] = $value['rate_group'];
			}
		}
		$this->rateGroups = $rate_groups;
	}
  
   public function getallcountry()
   {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE  status = '1'");
      $brr = array();
      if ($query->rows) {
      	
      	foreach ($query->rows as $key => $value) {
      		$brr[]= $value['iso_code_2'];
      	}
      }
      $this->writeDebug($brr);

   }
   

    public function  Shipping_Cost_API()
    {



      //http://localhost/html/index.php?route=shippingapi/shipping/Shipping_Cost_API&weight=90&country_code=US
       $data = array();

       $data['product'] = 'www';
       $json = array();
       $returnjson = array();
       //$data['shipping'] = $this->load->controller('checkout/shipping/country');

       //取出所有国家
       //$this->load->model('localisation/country');

	   //$data['countries'] = $this->model_localisation_country->getCountries();

        //取出某个国家
        $this->load->model('localisation/country');
        //判断某个国家iso_code_2是否存在
        $code = @$this->request->get['country_code'];
        $weight =@ $this->request->get['weight'] ;
        if (empty($code)  ||  empty($weight)) {
        	$arr1 = array('country_code'=>$code,'weight'=>$weight,'Error'=>'country_code or weight can not be empty');
            $this->response->addHeader('Content-Type: application/json');
        	
		    $this->response->setOutput(json_encode($arr1));
        }else{
          
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE iso_code_2 = '" . $code . "' AND status = '1'");
          
           if (empty($query->row)) {
           	   $arr2 = array('country_code'=>$code,'weight'=>$weight,'Error'=>'country_code is wrong or not existed!');
           	   $this->response->addHeader('Content-Type: application/json');
           	   $this->response->setOutput(json_encode($arr2));
           }else{
              $query = 	$query->row;
           	   // $query = $this->value($query);
               $country_id = $query['country_id'];
               $country_info = $this->model_localisation_country->getCountry($country_id); 
		       //$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
                $get_weight = empty($this->request->get['weight'])  ?   0  :   $this->request->get['weight'];
				if ($country_info ) {
					$this->load->model('localisation/zone');

					$json = array(
						'country_id'        => $country_info['country_id'],
						'name'              => $country_info['name'],
						'iso_code_2'        => $country_info['iso_code_2'],
						'iso_code_3'        => $country_info['iso_code_3'],
						'address_format'    => $country_info['address_format'],
						'postcode_required' => $country_info['postcode_required'],
						'zone'              => $this->model_localisation_zone->getZonesByCountryId(@$this->request->get['country_id']),
						'status'            => $country_info['status']
					);
				}

				$returnjson['country_code'] = $code;
                $returnjson['weight'] = $weight;
		       
					
		        $this->shipping_method($json, $get_weight,$returnjson);
           }
        }    
        
    }


   private function diqu()
   {

     //根据国家和地区确定运输方式和运费
			if (!$json) {
			$this->tax->setShippingAddress(1, 2);
           
			if ($country_info) {
				$country = $country_info['name'];
				$iso_code_2 = $country_info['iso_code_2'];
				$iso_code_3 = $country_info['iso_code_3'];
				$address_format = $country_info['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}
             
			$this->load->model('localisation/zone');

			$zone_info = $this->model_localisation_zone->getZone(2);
            
			if ($zone_info) {
				$zone = $zone_info['name'];
				$zone_code = $zone_info['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

			$this->session->data['shipping_address'] = array(
				'firstname'      => '',
				'lastname'       => '',
				'company'        => '',
				'address_1'      => '',
				'address_2'      => '',
				'postcode'       => '',
				'city'           => '',
				'zone_id'        => 2,
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => 1,
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);

			$quote_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('shipping');

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);

					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);

					if ($quote) {
						$quote_data[$result['code']] = array(
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $quote_data);

			$this->session->data['shipping_methods'] = $quote_data;

			if ($this->session->data['shipping_methods']) {
				$json['shipping_method'] = $this->session->data['shipping_methods'];
			} else {
				$json['error']['warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
			}
		}
      

   }


   private function shipping_method($country_zone ,  $get_weight,$returnjson) {
		$this->load->language('checkout/checkout');

		if (isset($country_zone)) {
			// Shipping Methods
			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('shipping');
            
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					//$this->load->model('shipping/' . $result['code']);
                   
					//$quote = $this->{'model_shipping_' . $result['code']}->getQuote($country_zone);
					$this->load->model('shipping/ocaaspro');
                   
					//$quote = $this->model_shipping_ocaaspro->getQuote($country_zone);

					$quote = $this->get_Quote($country_zone ,  $get_weight);
                     //$this->writeDebug($quote); //写入记事本
					 //$quote = $this->get_Quote($this->session->data['shipping_address']);

					if ($quote) {
						$method_data[$result['code']] = array(
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			//$this->session->data['shipping_methods'] = $method_data;
		}

		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_continue'] = $this->language->get('button_continue');

		if (empty($this->session->data['shipping_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['shipping_methods'])) {
			//$data['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$data['shipping_methods'] = array();
		}

		if (isset($this->session->data['shipping_method']['code'])) {
			//$data['code'] = $this->session->data['shipping_method']['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->session->data['comment'])) {
			//$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}
         //替换上面
		  $data['shipping_methods'] = $method_data;
		  $data['code'] = @$method_data['code'];

		
		if (empty($quote['quote'])) {
			$returnjson['Error'] = 'Out of Range';
		}else{
               $i = 0 ;
			foreach ($quote['quote'] as $k => $val) {
				$Smothod = preg_replace('/\(.*?\)/', '',$val['title']);//去掉括号及括号中内容
				
				$returnjson['Shipping_method'][$i]['Carrier'] = trim($Smothod);
				$returnjson['Shipping_method'][$i]['Cost']= trim($val['cost']);
				
				$result = array();
                preg_match_all("/(?:\()(.*)(?:\))/i",$val['title'], $result);//提取括号中的内容
                
                $returnjson['Shipping_method'][$i]['Delivery_Time']  = trim($result[1][0]);
                $i++;
			}
		}

	 
        $this->response->setOutput(json_encode($returnjson));

	

	}

    	public function get_Quote($address,$get_weight, $pcb=false, $pcb_cartProducts=null, $pcb_savedCart=null) {
    		
		$this->construct($address, $pcb, $pcb_cartProducts, $pcb_savedCart);
		$this->load->language($this->type . '/' . $this->extension);
		
		if ( $this->rates() &&  $address) {	
			$language_code = !empty($this->session->data['language']) ? $this->session->data['language'] : $this->config->get('config_language');
			if ($this->customer->isLogged()) {  //判断用户是否登陆
				$customer_group_id = ($this->version() >= 200) ? (int)$this->customer->getGroupId() : (int)$this->customer->getCustomerGroupId();
			} else {
				$customer_group_id = 0;
			}
			
			
			$destination = $this->getDestination($address);
            
			$rates = $this->rates();//取出所有运费计算规则
           
			$quote_data		= array();
			$method_data	= array();
			$combined_data	= array();
			
			if ($rates) {
				foreach ($rates as $rate_info) {  //分为一条的数组
					$rate 	= array();
					$debug  = 'START RATE CALCULATION';
					$debug .= ($this->ocapps_status && $this->field('ocapps_status')) ? ' | PerProductShippingIntegration: ENABLED' : '';
					$debug .= ' | RateID: ' . $rate_info['rate_id'];
					$debug .= ' | Description: ' . strtoupper($rate_info['description']);
					
					foreach ($rate_info as $key => $value) {
						$rate[$key] = $this->value($value);    //键数组
					}
					
					if ($rate['status']) {  //状态
						$status = true;
						
						$instruction 	= '';
						$rate_name 		= $this->language->get('text_name');
						$shipping_name	= $this->language->get('text_name');
						$title 			= $this->language->get('text_title');
						
						$adjusted_values = array();
						
						if (in_array($rate['rate_type'], $this->rateTypes) && empty($rate['rates'])) {
							$status = false;
							if (!$this->debugStatus) { continue; }
							$debug .= ' | checkRates: FAILED';
						}
						
						if ($status && strpos($rate['rate_type'], 'dim_weight') !== false && empty($rate['shipping_factor'])) {
							$status = false;
							$debug .= ' | ShippingFactorCheck: FAILED';
						}
						
						if ($status) {
							$status_store = $this->checkStores($rate['stores']);
							if (!$status_store['status']) {
								$status = false;
								if (!$this->debugStatus) { continue; }
								$debug .= $status_store['debug'];
								$debug .= ' | checkStores: FAILED';
							}
						}

						if ($status) {
							$status_customer = $this->checkCustomer($customer_group_id, $rate['customer_groups']);
							$debug .= $status_customer['debug'];
							if (!$status_customer['status']) {
								$status = false;
								if (!$this->debugStatus) { continue; }
								$debug .= ' | checkCustomer: FAILED';
							}
						}
						
						if ($status) {
							$status_geozones = $this->checkGeoZones($rate['geo_zones']);
							$debug .= $status_geozones['debug'];
							if (!$status_geozones['status']) {
								$status = false;
								if (!$this->debugStatus) { continue; }
								$debug .= ' | checkGeoZones: FAILED';
							}
						}
						
						
						$customer_info = array();
						
						
						$origin = array(
							'origin'	=> $rate['origin'],
							'lat' 		=> $rate['geocode_lat'],
							'lng' 		=> $rate['geocode_lng'],
						);
						
						//Build Values
						$products = $this->cartProducts; 
						$cart = array();
						$customer = array();
						$other = array(
							'currency'			=> $this->currency->getCode(),
							'day'				=> date('w')+1,
							'date'				=> date('Y-m-d'),
							'time'				=> date('H:i'),
						);

							
						//Build Requirements
						$temp_requirements = array();
						if ($status && !empty($rate['requirements'])) {   //判断必要条件
							foreach ($rate['requirements'] as $key => $requirement) {
								if (!in_array($requirement['operation'], array('add', 'sub'))) {
									if (strpos($requirement['type'], 'cart_') === 0 || strpos($requirement['type'], 'product_') === 0 || strpos($requirement['type'], 'customer_') === 0) {
										$group = explode('_', $requirement['type']);
										$group = $group[0];
									} else {
										$group = 'other';
									}
									$temp_requirements[$group][$requirement['type']][] = array(
										'operation'		=> $requirement['operation'],
										'value'			=> $requirement['value'],
										'parameter'	=> $requirement['parameter'],
									);
								} else {
									if (isset($adjusted_values[$requirement['type']])) { 
										$adjusted_values[$requirement['type']] += ($requirement['operation'] == 'add') ? $requirement['value'] : '-' . $requirement['value'];
									} else {
										$adjusted_values[$requirement['type']] = ($requirement['operation'] == 'add') ? $requirement['value'] : '-' . $requirement['value'];
									}
								}
							}
						}
					
						$requirements = array();
						if (!empty($temp_requirements['product'])) { $requirements['product'] = $temp_requirements['product']; }
						if (!empty($temp_requirements['cart'])) { $requirements['cart'] = $temp_requirements['cart']; }
						if (!empty($temp_requirements['customer'])) { $requirements['customer'] = $temp_requirements['customer']; }
						if (!empty($temp_requirements['other'])) { $requirements['other'] = $temp_requirements['other']; }
						
						if ($status && $requirements) {
							$requirement_match = false;
							$debug .= ' | START REQUIREMENTS CHECK';
							$debug .= ' | RequirementMatch: ' . strtoupper($rate['requirement_match']);
							$debug .= ' | IncludeProducts: ' . strtoupper($rate['requirement_cost']);
							foreach ($requirements as $group => $types) {
								foreach ($types as $type => $values) {
									foreach ($values as $value) {
										if ($group == 'cart' && empty($cart)) { $cart = $this->calculateCart($products, $adjusted_values, $rate['shipping_factor'], $origin, $destination, $rate['currency'], $rate['total_type']); }
										$requirement_status = $this->checkRequirement($rate['requirement_cost'], $group, $type, $value['operation'], $value['value'], $value['parameter'], $products, $cart, $customer, $other, $adjusted_values);
										if ($rate['requirement_match'] == 'all' && !$requirement_status) { $status = false; }
										if ($rate['requirement_match'] == 'any' && $requirement_status) { $requirement_match = true; }
										if ($rate['requirement_match'] == 'none' && $requirement_status) { $status = false; }
										if ((!$status || !$requirement_status) && $this->debugStatus) {
											$debug .= ' | RequirementType: ' . strtoupper(str_replace('_', ' ', $type));
											$debug .= ' | RequirementOperation: ' . strtoupper(str_replace(array('eq', 'neq', 'gte', 'lte', 'strpos', 'nstrpos'), array('equals', 'does not equal', 'greater than or equals', 'less than or equal', 'contains', 'does not contain'), $value['operation']));
											if (!is_array($value['value'])) {
												$debug .= ' | RequirementValue: ' . strtoupper($value['value']);
											}
											if ($value['parameter']) {
												foreach ($value['parameter'] as $parameter) {
													$debug .= ' | RequirementParameter: ' . strtoupper($parameter);
												}
											}
											$debug .= ' | RequirementCheck: FAILED';
											break;
										}
									}
									if (!$status) { break; }
								}
								if (!$status) { break; }
							}
							if ($rate['requirement_match'] == 'any' && !$requirement_match) {
								$debug .= ' | RequirementMatch: ' . strtoupper($rate['requirement_match']);
								$debug .= ' | RequirementMatch: FAILED';
								$status = false;
							}
							$debug .= ' | END REQUIREMENTS CHECK';
						}
						 
						
						 
						//if (empty($cart)) { $cart = $this->calculateCart($products, $adjusted_values, $rate['shipping_factor'], $origin, $destination, $rate['currency'], $rate['total_type']); }
						
						if ($status ) {
							$cost = '';
							
							if (in_array($rate['rate_type'], $this->rateTypes)) {
								$debug .= ' | RateType: ' . strtoupper(str_replace('_', ' ', $rate['rate_type']));
								if (strpos($rate['rate_type'], 'product_') === 0) {
									$value = str_replace('product_', '', $rate['rate_type']);
									
										$value  = $product[str_replace('product_', '', $rate['rate_type'])];
										$cost_data = ($rate['final_cost'] == 1) ? $this->getRateCumulative($get_weight, $rate['rates'], $get_weight) : $this->getRateSingle($get_weight, $rate['rates'], $get_weight);
										if ((string)$cost_data['cost'] != '') {
											$cost += $cost_data['cost'];
										}
										$debug .= $cost_data['debug'];
									
								} else {
									$value  = @$cart[str_replace('cart_', '', $rate['rate_type'])];
									if ($rate['split']) {
										$debug .= ' | SplitStatus: ENABLED';
										$max_rate	= $this->getRateMax($rate['rates']);
										$divide 	= ceil($value / $max_rate);
									} else {
										$divide		= 1;
									}
									$x = 1;
									while ($divide >= $x) {
										$split_value	= ($rate['split']) ? ($divide == $x) ? $value - ($max_rate * ($x - 1)) : $max_rate: $get_weight;
										$cost_data 		= ($rate['final_cost'] == 1) ? $this->getRateCumulative($split_value, $rate['rates'], $cart['total']) : $this->getRateSingle($split_value, $rate['rates'], $get_weight);
										if ((string)$cost_data['cost'] != '') {
											$cost += $cost_data['cost'];
										}
										$debug .= $cost_data['debug'];
										$x++;
									}
								}
							} else {
								$debug .= ' | RateType: ' . strtoupper($rate['rate_type']);
								
								//Temporarily Adjust Products In Cart
								//$this->cart->clear();
								
									
								
								
								$cost_data = $this->getShipping($rate['rate_type'], $rate['shipping_method'], $address);
								if ((string)$cost_data['cost'] != '') {
									$cost += $cost_data['cost'];
								}
								$debug .= $cost_data['debug'];
								
								//Restore Cart
								
							}
							
							//Get Per Product Shipping Costs
							if ($this->ocapps_status && $this->field('ocapps_status')) {
								$pps_cost = $this->getPerProductShipping($address, $rate['geo_zones']);
								if ((string)$pps_cost != '') {
									$cost 	+= $pps_cost;
									$debug	.= ' | AddPerProductShipping: ' . $pps_cost;
								}
							}
							
							if ((string)$cost != '') {
								if ($rate['cost']['min']) {
									if ($cost < $rate['cost']['min']) {
										$cost 	= $rate['cost']['min'];
										$debug .= ' | CostMin: COST ADJUSTED';
									}
								}
								
								if ($rate['cost']['max']) {
									if ($cost > $rate['cost']['max']) {
										$cost 	= $rate['cost']['max'];
										$debug .= ' | CostMax: COST ADJUSTED';
									}
								}
								
								if ($rate['cost']['add']) {
									if (strpos($rate['cost']['add'], '%')) {
										$cost += $cost * ($rate['cost']['add'] / 100);
									} else {
										$cost  += $rate['cost']['add'];
									}
									$debug .= ' | CostAdd: SUCCESS';
								}
								
								if ($rate['freight_fee']) {
									$pos = strpos($rate['freight_fee'], '%');
									if ($pos) {
										$cost += $cost * ($rate['freight_fee'] / 100);
									} else {
										$cost += $rate['freight_fee'];
									}
									$debug .= ' | FreightFee: ADDED';
								}				

								//Convert Currency
								if (in_array($rate['rate_type'], $this->rateTypes)) {
									$debug .= ' | ' . ucfirst($this->type) . 'CostBeforeCurrencyConversion: ' . $cost;
									$cost = $this->currency->convert($cost, $rate['currency'], $this->config->get('config_currency'));
									$debug .= ' | ' . ucfirst($this->type) . 'CostAfterCurrencyConversion: ' . $cost;
								}
								
								if ($rate['image'] && file_exists(DIR_IMAGE . $rate['image'])) {
									$this->load->model('tool/image');
									$image = $this->model_tool_image->resize($rate['image'], $rate['image_width'], $rate['image_height']);
								} else {
									$image = '';
								}
								
								$instruction 	= !empty($rate['instruction'][$language_code]) ? $rate['instruction'][$language_code] : '';
								$rate_name  	= !empty($rate['name'][$language_code]) ? $rate['name'][$language_code] : $rate_name;
								$shipping_name 	= !empty($rate['name'][$language_code]) ? $rate['name'][$language_code] : $shipping_name;
								
								if ($this->field('display_value') && in_array($rate['rate_type'], $this->rateTypes) && strpos($rate['rate_type'], 'cart_') === 0) {
									if (strpos($rate['rate_type'], 'cart_quantity') !== false) {
										$name_value = $value;
									} elseif (strpos($rate['rate_type'], 'cart_total') !== false) {
										$name_value = $this->currency->format($value, $rate['currency'], 1);
									} elseif (strpos($rate['rate_type'], 'cart_weight') !== false || strpos($rate['rate_type'], 'cart_dim_weight') !== false) {
										$name_value = $this->weight->format($value, $this->config->get('config_' . $this->weight()));
									} elseif (strpos($rate['rate_type'], 'cart_volume') !== false) {
										$name_value = $this->length->format($value, $this->config->get('config_' . $this->length())) . '&sup3;';
									} elseif (strpos($rate['rate_type'], 'cart_distance') !== false) {
										$name_value = round($value, 2) . 'km';
									}
									$shipping_name .= ' (' . $name_value . ')';
								}
								
								$debug .= ' | Name: ' . $rate_name;
								$debug .= ' | Image: ' . $image;
								$debug .= ' | Instruction: ' . $instruction;
								
								if ($rate['group'] && in_array($rate['group'], $this->rateGroups)) {
									$debug .= ' | Rate Groups: ' . $rate['group'];
									$groups = explode(',', $rate['group']);
									foreach ($groups as $key) {
										$key = trim($key);
										$combined_data[$key][] = array(
											'title'			=> $shipping_name,
											'image'			=> $image,
											'instruction'	=> $instruction,
											'sort_order'	=> $rate['sort_order'],
											'tax_class_id'	=> $rate['tax_class_id'],
											'cost'			=> $cost
										);
									}
								} else {
									$rate_data = array(
										'title'			=> $shipping_name,
										'image'			=> $image,
										'instruction'	=> $instruction,
										'sort_order'	=> $rate['sort_order'],
										'tax_class_id'	=> $rate['tax_class_id'],
										'cost'			=> $cost,
										'code'			=> $rate['rate_id'],
									);  
									$quote_data[$this->extension . '_' . $rate['rate_id']] = $this->getQuoteData($rate_data);
									$debug .= ' | Rate Groups: NONE';
								}
							} else {
								$debug .= ' | Cost: NOT FOUND';
							}
						}
					} else {
						if (!$this->debugStatus) { continue; }
						$debug .= ' | RateStatus: DISABLED';
					}
					$debug .= ' | END RATE CALCULATION';
					if ($this->debugStatus) {
						$this->writeDebug($debug);
					}
				}
			}
			
			$combination_row	= 1;
						if ($this->combinations) {
				foreach ($this->combinations as $key => $value) {
					$debug	= 'START COMBINE RATES';
					$rate_data = array();
					$title 	= '';
					$cost 	= '';
					$count	= 0;
					if (isset($combined_data[$value['rate_group']])) {
						if ($value['calculation_method'] == 0) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								$sort_order		= $rate['sort_order'];
								$tax_class_id 	= $rate['tax_class_id'];
								$cost 			+= $rate['cost'];
								$count++;
								
								if ($this->field('title_display') == 0 && !$title) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 1) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 2) {
									$title			.= ($title) ? ' + ' . $rate['title'] : $rate['title'];
									$image			= '';
									$instruction 	= '';
								} elseif ($this->field('title_display') == 3) {
									$title			.= ($title) ? ' + ' . $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')' : $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')';
									$image			= '';
									$instruction 	= '';
								}
							}
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: SUM';
						} elseif ($value['calculation_method'] == 1) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								$sort_order		= $rate['sort_order'];
								$tax_class_id 	= $rate['tax_class_id'];
								$cost 			+= $rate['cost'];
								$count++;
								
								if ($this->field('title_display') == 0 && !$title) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 1) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 2) {
									$title			.= ($title) ? ' + ' . $rate['title'] : $rate['title'];
									$image			= '';
									$instruction 	= '';
								} elseif ($this->field('title_display') == 3) {
									$title			.= ($title) ? ' + ' . $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')' : $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')';
									$image			= '';
									$instruction 	= '';
								}
							}
							$cost   = $cost/$count;
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: AVERAGE';
						} elseif ($value['calculation_method'] == 2) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								if ((string)$cost != '') {
									if ($cost > $rate['cost']) {
										$sort_order		= $rate['sort_order'];
										$tax_class_id 	= $rate['tax_class_id'];
										$cost 			= $rate['cost'];
										$title 			= $rate['title'];
										$image			= $rate['image'];
										$instruction	= $rate['instruction'];
									}
								} else {
									$sort_order		= $rate['sort_order'];
									$tax_class_id 	= $rate['tax_class_id'];
									$cost 			= $rate['cost'];
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								}
							}
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: LOWEST';
						} elseif ($value['calculation_method'] == 3) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								if ((string)$cost != '') {
									if ($cost < $rate['cost']) {
										$sort_order		= $rate['sort_order'];
										$tax_class_id 	= $rate['tax_class_id'];
										$cost 			= $rate['cost'];
										$title 			= $rate['title'];
										$image			= $rate['image'];
										$instruction	= $rate['instruction'];
									}
								} else {
									$sort_order		= $rate['sort_order'];
									$tax_class_id 	= $rate['tax_class_id'];
									$cost 			= $rate['cost'];
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								}
							}
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: HIGHEST';
						}
						if ((string)$cost != '') {
							$rate_data = array(
								'title'			=> $title,
								'image'			=> $image,
								'instruction'	=> $instruction,
								'sort_order'	=> $sort_order,
								'tax_class_id'	=> $tax_class_id,
								'cost'			=> $cost,
								'code'			=> 'C' . $value['rate_group'] . $combination_row,
							);
							$quote_data[$this->extension . '_C' . $value['rate_group'] . $combination_row] = $this->getQuoteData($rate_data);
							
							$debug .= ' | Title: ' . $title;
							$debug .= ' | Image: ' . $image;
							$debug .= ' | Instruction: ' . $instruction;
							$debug .= ' | Sort Order: ' . $sort_order;
							$debug .= ' | Tax Class ID: ' . $tax_class_id;
							$debug .= ' | Cost: ' . $cost;
							$debug .= ' | Code: C' . $value['rate_group'] . $combination_row;
						}
					} else {
						$debug .= ' | Combined Data: NONE FOUND';
					}
					if ($this->debugStatus) {
						$this->writeDebug($debug);
					}
					$combination_row++;
				}
				$debug .= ' | END COMBINE RATES';
			}
			//$this->writeDebug($quote_data);
			if ($quote_data) {
				$sort_order = array();
				foreach ($quote_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
					$sort_cost[$key] = $value['value'];
				}
				
				if ($this->field('sort_quotes') == 0) {
					array_multisort($sort_order, SORT_ASC, $quote_data);
				} elseif ($this->field('sort_quotes') == 1) {
					array_multisort($sort_order, SORT_DESC, $quote_data);
				} elseif ($this->field('sort_quotes') == 2) {
					array_multisort($sort_cost, SORT_ASC, $quote_data);
				} elseif ($this->field('sort_quotes') == 3) {
					array_multisort($sort_cost, SORT_DESC, $quote_data);
				} else {
					array_multisort($sort_order, SORT_ASC, $quote_data);
				}
				
				$title_data = $this->field('title');
				
				$method_data = array(
					'id'       		=> $this->extension,
					'code'       	=> $this->extension,
					'title'      	=> !empty($title_data[$language_code]) ? $title_data[$language_code] : $title,
					'quote'      	=> $quote_data,
					'sort_order' 	=> $this->field('sort_order'),
					'error'      	=> false
				);
			}
			return $method_data;
		} 
	}

	public function getQuote_test($address) {
		//$this->construct($address);
        $geo_zones = array();
			
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
		foreach ($query->rows as $result) {
			$query_z2g = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			if ($query_z2g->num_rows) {
				$geo_zones[] = $result;
			}
		}
		
		if (!$geo_zones) {
			$geo_zones[] = array(
				'geo_zone_id'	=> 0,
				'name'			=> 'All Other Zones',
			);
		}

		$this->load->language($this->type . '/' . $this->extension);
		
		if ($this->field('status') && $this->rates() && $this->cartProducts && $address) {	
			$language_code = !empty($this->session->data['language']) ? $this->session->data['language'] : $this->config->get('config_language');
			
			
			
			//$destination = $this->getDestination($address);
			if (!empty($address)) {
			$country_query 	= $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$address['country_id'] . "'");
			$zone_query		= $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$address['zone_id'] . "'");
			if ($country_query) {
				$destination .= isset($address['address_1']) ? $address['address_1'] : '';
				$destination .= (isset($address['address_2']) && $address['address_2']) ? ' ' . $address['address_2'] : '';
				$destination .= isset($address['city']) ? ' ' . $address['city'] : '';
				$destination .= isset($address['postcode']) ? ' ' . $address['postcode'] : '';
				$destination .= isset($zone_query->row['name']) ? ' ' . $zone_query->row['name'] : '';
				$destination .= isset($country_query->row['name']) ? ' ' . $country_query->row['name'] : '';
			}	
		}

			//$rates = $this->rates();
			$rates = array();
		if ($this->cache->get($this->type . $this->extension)) {
			$rates = $this->cache->get($this->type . $this->extension);
		}	
		if (!$rates) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->db_table . " WHERE status = '1' ORDER BY sort_order, rate_id ASC");
			$rates = $query->rows;
			$this->cache->set($this->type . $this->extension, $rates);
		}

			$quote_data		= array();
			$method_data	= array();
			$combined_data	= array();
			
			if ($rates) {
				foreach ($rates as $rate_info) {
					$rate 	= array();
					$debug  = 'START RATE CALCULATION';
					$debug .= ($this->ocapps_status && $this->field('ocapps_status')) ? ' | PerProductShippingIntegration: ENABLED' : '';
					$debug .= ' | RateID: ' . $rate_info['rate_id'];
					$debug .= ' | Description: ' . strtoupper($rate_info['description']);
					
					foreach ($rate_info as $key => $value) {
						$rate[$key] = $this->value($value);
					}
					
					if ($rate['status']) {
						$status = true;
						
						$instruction 	= '';
						$rate_name 		= $this->language->get('text_name');
						$shipping_name	= $this->language->get('text_name');
						$title 			= $this->language->get('text_title');
						
						$adjusted_values = array();
						
						if (in_array($rate['rate_type'], $this->rateTypes) && empty($rate['rates'])) {
							$status = false;
							if (!$this->debugStatus) { continue; }
							$debug .= ' | checkRates: FAILED';
						}
						
						if ($status && strpos($rate['rate_type'], 'dim_weight') !== false && empty($rate['shipping_factor'])) {
							$status = false;
							$debug .= ' | ShippingFactorCheck: FAILED';
						}
						
						if ($status) {
							//$status_store = $this->checkStores($rate['stores']);
                              $debug = ' | StoreId: ' . (int)$this->config->get('config_store_id');
		if (!in_array((int)$this->config->get('config_store_id'), $stores)) {
			$status = false;
		}
		$status_store = array(
			'status'	=> $status,
			'debug'		=> $debug
		);

                            $status = true;
		
		




							if (!$status_store['status']) {
								$status = false;
								if (!$this->debugStatus) { continue; }
								$debug .= $status_store['debug'];
								$debug .= ' | checkStores: FAILED';
							}
						}
						
						if ($status) {
							$status_customer = $this->checkCustomer($customer_group_id, $rate['customer_groups']);
							$debug .= $status_customer['debug'];
							if (!$status_customer['status']) {
								$status = false;
								if (!$this->debugStatus) { continue; }
								$debug .= ' | checkCustomer: FAILED';
							}
						}
						
						if ($status) {
							$status_geozones = $this->checkGeoZones($rate['geo_zones']);
							$debug .= $status_geozones['debug'];
							if (!$status_geozones['status']) {
								$status = false;
								if (!$this->debugStatus) { continue; }
								$debug .= ' | checkGeoZones: FAILED';
							}
						}
						
						$customer_info = array();
						if ($this->customer->isLogged()) {
							$this->load->model('account/customer');
							$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
						}
						
						$origin = array(
							'origin'	=> $rate['origin'],
							'lat' 		=> $rate['geocode_lat'],
							'lng' 		=> $rate['geocode_lng'],
						);
						
						//Build Values
						$products = $this->cartProducts;
						$cart = array();
						$customer = array(
							'name'				=> (!empty($address['firstname']) ? trim($address['firstname']) : '') . ' ' . (!empty($address['lastname']) ? trim($address['lastname']) : ''),
							'email'				=> ($this->customer->isLogged()) ? trim($customer_info['email']) : (!empty($this->session->data['guest']['email']) ? trim($this->session->data['guest']['email']) : ''),
							'telephone'			=> ($this->customer->isLogged()) ? trim($customer_info['telephone']) : (!empty($this->session->data['guest']['telephone']) ? trim($this->session->data['guest']['telephone']) : ''),
							'fax'				=> ($this->customer->isLogged()) ? trim($customer_info['fax']) : (!empty($this->session->data['guest']['fax']) ? trim($this->session->data['guest']['fax']) : ''),
							'company'			=> (!empty($address['company'])) ? trim($address['company']) : '',
							'address'			=> (!empty($address['address_1']) ? trim($address['address_1']) : '') . ' ' . (!empty($address['address_2']) ? trim($address['address_2']) : ''),
							'city'				=> (!empty($address['city'])) ? trim($address['city']) : '',
							'postcode'			=> (!empty($address['postcode'])) ? trim($address['postcode']) : '',
						);
						$other = array(
							'currency'			=> $this->currency->getCode(),
							'day'				=> date('w')+1,
							'date'				=> date('Y-m-d'),
							'time'				=> date('H:i'),
						);

						//Remove Products With Per Product Shipping Assigned
						if ($this->ocapps_status && $this->field('ocapps_status') && $products) {
							foreach ($products as $key => $product) {
								foreach ($this->cartGeoZones as $geo_zone) {
									if (in_array($geo_zone['geo_zone_id'], $rate['geo_zones'])) {
										if ($this->checkPerProductShipping($product['product_id'], $geo_zone['geo_zone_id'])) {
											unset($products[$key]);
											break;
										}
									}
								}
							}
						}
							
						//Build Requirements
						$temp_requirements = array();
						if ($status && !empty($rate['requirements'])) {
							foreach ($rate['requirements'] as $key => $requirement) {
								if (!in_array($requirement['operation'], array('add', 'sub'))) {
									if (strpos($requirement['type'], 'cart_') === 0 || strpos($requirement['type'], 'product_') === 0 || strpos($requirement['type'], 'customer_') === 0) {
										$group = explode('_', $requirement['type']);
										$group = $group[0];
									} else {
										$group = 'other';
									}
									$temp_requirements[$group][$requirement['type']][] = array(
										'operation'		=> $requirement['operation'],
										'value'			=> $requirement['value'],
										'parameter'	=> $requirement['parameter'],
									);
								} else {
									if (isset($adjusted_values[$requirement['type']])) { 
										$adjusted_values[$requirement['type']] += ($requirement['operation'] == 'add') ? $requirement['value'] : '-' . $requirement['value'];
									} else {
										$adjusted_values[$requirement['type']] = ($requirement['operation'] == 'add') ? $requirement['value'] : '-' . $requirement['value'];
									}
								}
							}
						}
						
						$requirements = array();
						if (!empty($temp_requirements['product'])) { $requirements['product'] = $temp_requirements['product']; }
						if (!empty($temp_requirements['cart'])) { $requirements['cart'] = $temp_requirements['cart']; }
						if (!empty($temp_requirements['customer'])) { $requirements['customer'] = $temp_requirements['customer']; }
						if (!empty($temp_requirements['other'])) { $requirements['other'] = $temp_requirements['other']; }
						
						if ($status && $requirements) {
							$requirement_match = false;
							$debug .= ' | START REQUIREMENTS CHECK';
							$debug .= ' | RequirementMatch: ' . strtoupper($rate['requirement_match']);
							$debug .= ' | IncludeProducts: ' . strtoupper($rate['requirement_cost']);
							foreach ($requirements as $group => $types) {
								foreach ($types as $type => $values) {
									foreach ($values as $value) {
										if ($group == 'cart' && empty($cart)) { $cart = $this->calculateCart($products, $adjusted_values, $rate['shipping_factor'], $origin, $destination, $rate['currency'], $rate['total_type']); }
										$requirement_status = $this->checkRequirement($rate['requirement_cost'], $group, $type, $value['operation'], $value['value'], $value['parameter'], $products, $cart, $customer, $other, $adjusted_values);
										if ($rate['requirement_match'] == 'all' && !$requirement_status) { $status = false; }
										if ($rate['requirement_match'] == 'any' && $requirement_status) { $requirement_match = true; }
										if ($rate['requirement_match'] == 'none' && $requirement_status) { $status = false; }
										if ((!$status || !$requirement_status) && $this->debugStatus) {
											$debug .= ' | RequirementType: ' . strtoupper(str_replace('_', ' ', $type));
											$debug .= ' | RequirementOperation: ' . strtoupper(str_replace(array('eq', 'neq', 'gte', 'lte', 'strpos', 'nstrpos'), array('equals', 'does not equal', 'greater than or equals', 'less than or equal', 'contains', 'does not contain'), $value['operation']));
											if (!is_array($value['value'])) {
												$debug .= ' | RequirementValue: ' . strtoupper($value['value']);
											}
											if ($value['parameter']) {
												foreach ($value['parameter'] as $parameter) {
													$debug .= ' | RequirementParameter: ' . strtoupper($parameter);
												}
											}
											$debug .= ' | RequirementCheck: FAILED';
											break;
										}
									}
									if (!$status) { break; }
								}
								if (!$status) { break; }
							}
							if ($rate['requirement_match'] == 'any' && !$requirement_match) {
								$debug .= ' | RequirementMatch: ' . strtoupper($rate['requirement_match']);
								$debug .= ' | RequirementMatch: FAILED';
								$status = false;
							}
							$debug .= ' | END REQUIREMENTS CHECK';
						}
						
						if (empty($cart)) { $cart = $this->calculateCart($products, $adjusted_values, $rate['shipping_factor'], $origin, $destination, $rate['currency'], $rate['total_type']); }
						
						if ($status && $products) {
							$cost = '';
							
							if (in_array($rate['rate_type'], $this->rateTypes)) {
								$debug .= ' | RateType: ' . strtoupper(str_replace('_', ' ', $rate['rate_type']));
								if (strpos($rate['rate_type'], 'product_') === 0) {
									$value = str_replace('product_', '', $rate['rate_type']);
									foreach ($products as $product) {
										$value  = $product[str_replace('product_', '', $rate['rate_type'])];
										$cost_data = ($rate['final_cost'] == 1) ? $this->getRateCumulative($value, $rate['rates'], $cart['total']) : $this->getRateSingle($value, $rate['rates'], $cart['total']);
										if ((string)$cost_data['cost'] != '') {
											$cost += $cost_data['cost'];
										}
										$debug .= $cost_data['debug'];
									}
								} else {
									$value  = $cart[str_replace('cart_', '', $rate['rate_type'])];
									if ($rate['split']) {
										$debug .= ' | SplitStatus: ENABLED';
										$max_rate	= $this->getRateMax($rate['rates']);
										$divide 	= ceil($value / $max_rate);
									} else {
										$divide		= 1;
									}
									$x = 1;
									while ($divide >= $x) {
										$split_value	= ($rate['split']) ? ($divide == $x) ? $value - ($max_rate * ($x - 1)) : $max_rate: $value;
										$cost_data 		= ($rate['final_cost'] == 1) ? $this->getRateCumulative($split_value, $rate['rates'], $cart['total']) : $this->getRateSingle($split_value, $rate['rates'], $cart['total']);
										if ((string)$cost_data['cost'] != '') {
											$cost += $cost_data['cost'];
										}
										$debug .= $cost_data['debug'];
										$x++;
									}
								}
							} else {
								$debug .= ' | RateType: ' . strtoupper($rate['rate_type']);
								
								//Temporarily Adjust Products In Cart
								$this->cart->clear();
								foreach ($products as $product) {
									if ($this->version() >= 210) {
										$option_data = array();
										foreach ($product['option'] as $option) {
											if (in_array($option['type'], array('select', 'radio', 'image'))) {
												$option_data[$option['product_option_id']] = $option['product_option_value_id'];
											} elseif ($option['type'] == 'checkbox') {
												$option_data[$option['product_option_id']][] = $option['product_option_value_id'];
												$option_data[$option['option_id']][] = $option['value'];
											} elseif (in_array($option['type'], array('text', 'textarea', 'file', 'date', 'datetime', 'time'))) {
												$option_data[$option['product_option_id']] = $option['value'];
											}
										}
										$quantity	= $product['quantity'] + (!empty($adjusted_values['product_quantity']) ? $adjusted_values['product_quantity'] : 0);
										$recurring	= $product['recurring'];
										$this->cart->add($product['product_id'], $quantity, $option_data, $recurring['recurring_id']);
									} else {
										$this->session->data['cart'][$product['key']] = (int)$product['quantity'];
									}
								}
								
								$cost_data = $this->getShipping($rate['rate_type'], $rate['shipping_method'], $address);
								if ((string)$cost_data['cost'] != '') {
									$cost += $cost_data['cost'];
								}
								$debug .= $cost_data['debug'];
								
								//Restore Cart
								$this->cart->clear();
								if ($this->version() >= 210) {
									foreach ($this->savedCart as $product) {
										$this->cart->add($product['product_id'], $product['quantity'], $product['option'], $product['recurring_id']);
									}
								} else {
									$this->session->data['cart'] = $this->savedCart;
								}
							}
							
							//Get Per Product Shipping Costs
							if ($this->ocapps_status && $this->field('ocapps_status')) {
								$pps_cost = $this->getPerProductShipping($address, $rate['geo_zones']);
								if ((string)$pps_cost != '') {
									$cost 	+= $pps_cost;
									$debug	.= ' | AddPerProductShipping: ' . $pps_cost;
								}
							}
							
							if ((string)$cost != '') {
								if ($rate['cost']['min']) {
									if ($cost < $rate['cost']['min']) {
										$cost 	= $rate['cost']['min'];
										$debug .= ' | CostMin: COST ADJUSTED';
									}
								}
								
								if ($rate['cost']['max']) {
									if ($cost > $rate['cost']['max']) {
										$cost 	= $rate['cost']['max'];
										$debug .= ' | CostMax: COST ADJUSTED';
									}
								}
								
								if ($rate['cost']['add']) {
									if (strpos($rate['cost']['add'], '%')) {
										$cost += $cost * ($rate['cost']['add'] / 100);
									} else {
										$cost  += $rate['cost']['add'];
									}
									$debug .= ' | CostAdd: SUCCESS';
								}
								
								if ($rate['freight_fee']) {
									$pos = strpos($rate['freight_fee'], '%');
									if ($pos) {
										$cost += $cost * ($rate['freight_fee'] / 100);
									} else {
										$cost += $rate['freight_fee'];
									}
									$debug .= ' | FreightFee: ADDED';
								}				

								//Convert Currency
								if (in_array($rate['rate_type'], $this->rateTypes)) {
									$debug .= ' | ' . ucfirst($this->type) . 'CostBeforeCurrencyConversion: ' . $cost;
									$cost = $this->currency->convert($cost, $rate['currency'], $this->config->get('config_currency'));
									$debug .= ' | ' . ucfirst($this->type) . 'CostAfterCurrencyConversion: ' . $cost;
								}
								
								if ($rate['image'] && file_exists(DIR_IMAGE . $rate['image'])) {
									$this->load->model('tool/image');
									$image = $this->model_tool_image->resize($rate['image'], $rate['image_width'], $rate['image_height']);
								} else {
									$image = '';
								}
								
								$instruction 	= !empty($rate['instruction'][$language_code]) ? $rate['instruction'][$language_code] : '';
								$rate_name  	= !empty($rate['name'][$language_code]) ? $rate['name'][$language_code] : $rate_name;
								$shipping_name 	= !empty($rate['name'][$language_code]) ? $rate['name'][$language_code] : $shipping_name;
								
								if ($this->field('display_value') && in_array($rate['rate_type'], $this->rateTypes) && strpos($rate['rate_type'], 'cart_') === 0) {
									if (strpos($rate['rate_type'], 'cart_quantity') !== false) {
										$name_value = $value;
									} elseif (strpos($rate['rate_type'], 'cart_total') !== false) {
										$name_value = $this->currency->format($value, $rate['currency'], 1);
									} elseif (strpos($rate['rate_type'], 'cart_weight') !== false || strpos($rate['rate_type'], 'cart_dim_weight') !== false) {
										$name_value = $this->weight->format($value, $this->config->get('config_' . $this->weight()));
									} elseif (strpos($rate['rate_type'], 'cart_volume') !== false) {
										$name_value = $this->length->format($value, $this->config->get('config_' . $this->length())) . '&sup3;';
									} elseif (strpos($rate['rate_type'], 'cart_distance') !== false) {
										$name_value = round($value, 2) . 'km';
									}
									$shipping_name .= ' (' . $name_value . ')';
								}
								
								$debug .= ' | Name: ' . $rate_name;
								$debug .= ' | Image: ' . $image;
								$debug .= ' | Instruction: ' . $instruction;
								
								if ($rate['group'] && in_array($rate['group'], $this->rateGroups)) {
									$debug .= ' | Rate Groups: ' . $rate['group'];
									$groups = explode(',', $rate['group']);
									foreach ($groups as $key) {
										$key = trim($key);
										$combined_data[$key][] = array(
											'title'			=> $shipping_name,
											'image'			=> $image,
											'instruction'	=> $instruction,
											'sort_order'	=> $rate['sort_order'],
											'tax_class_id'	=> $rate['tax_class_id'],
											'cost'			=> $cost
										);
									}
								} else {
									$rate_data = array(
										'title'			=> $shipping_name,
										'image'			=> $image,
										'instruction'	=> $instruction,
										'sort_order'	=> $rate['sort_order'],
										'tax_class_id'	=> $rate['tax_class_id'],
										'cost'			=> $cost,
										'code'			=> $rate['rate_id'],
									);
									$quote_data[$this->extension . '_' . $rate['rate_id']] = $this->getQuoteData($rate_data);
									$debug .= ' | Rate Groups: NONE';
								}
							} else {
								$debug .= ' | Cost: NOT FOUND';
							}
						}
					} else {
						if (!$this->debugStatus) { continue; }
						$debug .= ' | RateStatus: DISABLED';
					}
					$debug .= ' | END RATE CALCULATION';
					if ($this->debugStatus) {
						$this->writeDebug($debug);
					}
				}
			}
			
			$combination_row	= 1;
			if ($this->combinations) {
				foreach ($this->combinations as $key => $value) {
					$debug	= 'START COMBINE RATES';
					$rate_data = array();
					$title 	= '';
					$cost 	= '';
					$count	= 0;
					if (isset($combined_data[$value['rate_group']])) {
						if ($value['calculation_method'] == 0) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								$sort_order		= $rate['sort_order'];
								$tax_class_id 	= $rate['tax_class_id'];
								$cost 			+= $rate['cost'];
								$count++;
								
								if ($this->field('title_display') == 0 && !$title) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 1) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 2) {
									$title			.= ($title) ? ' + ' . $rate['title'] : $rate['title'];
									$image			= '';
									$instruction 	= '';
								} elseif ($this->field('title_display') == 3) {
									$title			.= ($title) ? ' + ' . $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')' : $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')';
									$image			= '';
									$instruction 	= '';
								}
							}
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: SUM';
						} elseif ($value['calculation_method'] == 1) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								$sort_order		= $rate['sort_order'];
								$tax_class_id 	= $rate['tax_class_id'];
								$cost 			+= $rate['cost'];
								$count++;
								
								if ($this->field('title_display') == 0 && !$title) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 1) {
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								} elseif ($this->field('title_display') == 2) {
									$title			.= ($title) ? ' + ' . $rate['title'] : $rate['title'];
									$image			= '';
									$instruction 	= '';
								} elseif ($this->field('title_display') == 3) {
									$title			.= ($title) ? ' + ' . $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')' : $rate['title'] . '(' . $this->currency->format($this->tax->calculate($rate['cost'], $rate['tax_class_id'], $this->config->get('config_tax'))) . ')';
									$image			= '';
									$instruction 	= '';
								}
							}
							$cost   = $cost/$count;
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: AVERAGE';
						} elseif ($value['calculation_method'] == 2) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								if ((string)$cost != '') {
									if ($cost > $rate['cost']) {
										$sort_order		= $rate['sort_order'];
										$tax_class_id 	= $rate['tax_class_id'];
										$cost 			= $rate['cost'];
										$title 			= $rate['title'];
										$image			= $rate['image'];
										$instruction	= $rate['instruction'];
									}
								} else {
									$sort_order		= $rate['sort_order'];
									$tax_class_id 	= $rate['tax_class_id'];
									$cost 			= $rate['cost'];
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								}
							}
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: LOWEST';
						} elseif ($value['calculation_method'] == 3) {
							foreach ($combined_data[$value['rate_group']] as $rate) {
								if ((string)$cost != '') {
									if ($cost < $rate['cost']) {
										$sort_order		= $rate['sort_order'];
										$tax_class_id 	= $rate['tax_class_id'];
										$cost 			= $rate['cost'];
										$title 			= $rate['title'];
										$image			= $rate['image'];
										$instruction	= $rate['instruction'];
									}
								} else {
									$sort_order		= $rate['sort_order'];
									$tax_class_id 	= $rate['tax_class_id'];
									$cost 			= $rate['cost'];
									$title 			= $rate['title'];
									$image			= $rate['image'];
									$instruction	= $rate['instruction'];
								}
							}
							$debug .= ' | Rate Group: ' . $value['rate_group'];
							$debug .= ' | Calculation Method: HIGHEST';
						}
						if ((string)$cost != '') {
							$rate_data = array(
								'title'			=> $title,
								'image'			=> $image,
								'instruction'	=> $instruction,
								'sort_order'	=> $sort_order,
								'tax_class_id'	=> $tax_class_id,
								'cost'			=> $cost,
								'code'			=> 'C' . $value['rate_group'] . $combination_row,
							);
							$quote_data[$this->extension . '_C' . $value['rate_group'] . $combination_row] = $this->getQuoteData($rate_data);
							
							$debug .= ' | Title: ' . $title;
							$debug .= ' | Image: ' . $image;
							$debug .= ' | Instruction: ' . $instruction;
							$debug .= ' | Sort Order: ' . $sort_order;
							$debug .= ' | Tax Class ID: ' . $tax_class_id;
							$debug .= ' | Cost: ' . $cost;
							$debug .= ' | Code: C' . $value['rate_group'] . $combination_row;
						}
					} else {
						$debug .= ' | Combined Data: NONE FOUND';
					}
					if ($this->debugStatus) {
						$this->writeDebug($debug);
					}
					$combination_row++;
				}
				$debug .= ' | END COMBINE RATES';
			}
			
			if ($quote_data) {
				$sort_order = array();
				foreach ($quote_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
					$sort_cost[$key] = $value['value'];
				}
				
				if ($this->field('sort_quotes') == 0) {
					array_multisort($sort_order, SORT_ASC, $quote_data);
				} elseif ($this->field('sort_quotes') == 1) {
					array_multisort($sort_order, SORT_DESC, $quote_data);
				} elseif ($this->field('sort_quotes') == 2) {
					array_multisort($sort_cost, SORT_ASC, $quote_data);
				} elseif ($this->field('sort_quotes') == 3) {
					array_multisort($sort_cost, SORT_DESC, $quote_data);
				} else {
					array_multisort($sort_order, SORT_ASC, $quote_data);
				}
				
				$title_data = $this->field('title');
				
				$method_data = array(
					'id'       		=> $this->extension,
					'code'       	=> $this->extension,
					'title'      	=> !empty($title_data[$language_code]) ? $title_data[$language_code] : $title,
					'quote'      	=> $quote_data,
					'sort_order' 	=> $this->field('sort_order'),
					'error'      	=> false
				);
			}
			return $method_data;
		} else {
			$debug  = $this->language->get('text_title');
			$debug .= ' | FAILED TO INITIALIZE';
			if ($this->field('status')) {
				$debug .= ' | ExtensionStatus: ENABLED';
			} else {
				$debug .= ' | ExtensionStatus: DISABLED';
			}
			if ($this->rates()) {
				$debug .= ' | Rates: EMPTY';
			} else {
				$debug .= ' | Rates: ' . count($this->rates()) . ' FOUND';
			}
			if ($this->cartProducts) {
				$debug .= ' | ProductsInCart: EMPTY';
			} else {
				$debug .= ' | ProductsInCart: ' . count($this->cart->hasProducts()) . ' FOUND';
			}
			if ($address) {
				$debug .= ' | CustomerAddress: NOT FOUND';
			} else {
				$debug .= ' | CustomerAddress: FOUND';
			}
			if ($this->debugStatus) {
				$this->writeDebug($debug);
			}
		}
	}



	private function field($field) {
		$value = $this->config->get($this->extension . '_' . $field);
		return $value = (!is_array($value) && is_array(json_decode($value, true))) ? json_decode($value, true) : $value;
	}

	private function rates() {
		$rates = array();
		if ($this->cache->get($this->type . $this->extension)) {
			$rates = $this->cache->get($this->type . $this->extension);
		}	
		if (!$rates) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->db_table . " WHERE status = '1' ORDER BY sort_order, rate_id ASC");
			$rates = $query->rows;
			$this->cache->set($this->type . $this->extension, $rates);
		}	
		return $rates;
	}


	private function getGeoZones($address) {
		$geo_zones = array();
			
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
		foreach ($query->rows as $result) {
			$query_z2g = @$this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			if ($query_z2g->num_rows) {
				$geo_zones[] = $result;
			}
		}
		
		if (!$geo_zones) {
			$geo_zones[] = array(
				'geo_zone_id'	=> 0,
				'name'			=> 'All Other Zones',
			);
		}
				
		return $geo_zones;
	}

	


	

	private function value($value) {
		return $value = (!is_array($value) && is_array(json_decode($value, true))) ? json_decode($value, true) : $value;
	}

	private function getQuoteData($data) {
		return array(
			'id'		   => $this->extension . '.' . $this->extension . '_' . $data['code'],
			'code'		   => $this->extension . '.' . $this->extension . '_' . $data['code'],
			'title'        => $data['title'],
			'image'        => $data['image'],
			'instruction'  => html_entity_decode($data['instruction']),
			'cost'         => $data['cost'],
			'value'        => $data['cost'],
			'text'         => $this->currency->format($this->tax->calculate($data['cost'], $data['tax_class_id'], $this->config->get('config_tax'))),
			'sort_order'   => $data['sort_order'],
			'tax_class_id' => $data['tax_class_id']
		);
	}

private function getDestination($address) {
		$destination = '';
		
		if (!empty($address)) {
			$country_query 	= $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$address['country_id'] . "'");
			$zone_query		= @$this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$address['zone_id'] . "'");
			if ($country_query) {
				$destination .= isset($address['address_1']) ? $address['address_1'] : '';
				$destination .= (isset($address['address_2']) && $address['address_2']) ? ' ' . $address['address_2'] : '';
				$destination .= isset($address['city']) ? ' ' . $address['city'] : '';
				$destination .= isset($address['postcode']) ? ' ' . $address['postcode'] : '';
				$destination .= isset($zone_query->row['name']) ? ' ' . $zone_query->row['name'] : '';
				$destination .= isset($country_query->row['name']) ? ' ' . $country_query->row['name'] : '';
			}	
		}
		return $destination;
	}

private function getRateSingle($value, $rates, $total) {
		$cost 	= '';
		$debug	= '';
		$rates 	= explode(',', $rates);
		
		$debug .= ' | Value: ' . $value;
	
		foreach ($rates as $rate) {
			$rate = trim($rate);
			$a = false;
			$b = false;
			$c = false;
			$d = 0;
			if (preg_match($this->rateFormat1, $rate)) {
				$data 	= explode(':',$rate);
				$a		= $data[0];
				$b		= $data[1];
			} elseif (preg_match($this->rateFormat2, $rate)) {
				$data 	= explode(':', $rate);
				$data2 	= explode('+', $data[1]);
				$a		= $data[0];
				$b		= $data2[0];
				$d		= $data2[1];
			} elseif (preg_match($this->rateFormat3, $rate)) {
				$data 	= explode(':', $rate);
				$data2 	= explode('/', $data[1]);
				$a		= $data[0];
				$b		= $data2[0];
				$c		= $data2[1];
			} elseif (preg_match($this->rateFormat4, $rate)) {
				$data 	= explode(':', $rate);
				$data2 	= explode('/', $data[1]);
				$data3 	= explode('+', $data2[1]);
				$a		= $data[0];
				$b		= $data2[0];
				$c		= $data3[0];
				$d		= $data3[1];
			}
			if (strpos($b, '%')) {
				$b = $total * ($b / 100);
			}
			if (strpos($d, '%')) {
				$d = $total * ($d / 100);
			}
			if ($a >= $value || $a == '~') {
				if ($b && $c) {
					$cost = ceil($value / $c) * $b;
				} else {
					$cost = $b;
				}
				$cost += $d;
				$debug .= ' | RatesFound: SUCCESS (' . $rate . ')';
				$debug .= ' | RateCost: ' . $cost;
				break;
			}
		}
		return array(
			'cost'	=> $cost,
			'debug'	=> $debug
		);
	}
	
	private function getRateCumulative($value, $rates, $total) {
		$cost 			= '';
		$debug			= '';
		$rates 			= explode(',', $rates);
		$prev 			= 0;
		$max_found		= false;
		
		$debug .= ' | Value: ' . $value;
		
		foreach ($rates as $rate) {
			$rate = trim($rate);
			$a = false;
			$b = false;
			$c = false;
			$d = 0;
			if (preg_match($this->rateFormat1, $rate)) {
				$data 	= explode(':',$rate);
				$a		= $data[0];
				$b		= $data[1];
			} elseif (preg_match($this->rateFormat2, $rate)) {
				$data 	= explode(':', $rate);
				$data2 	= explode('+', $data[1]);
				$a		= $data[0];
				$b		= $data2[0];
				$d		= $data2[1];
			} elseif (preg_match($this->rateFormat3, $rate)) {
				$data 	= explode(':', $rate);
				$data2 	= explode('/', $data[1]);
				$a		= $data[0];
				$b		= $data2[0];
				$c		= $data2[1];
			} elseif (preg_match($this->rateFormat4, $rate)) {
				$data 	= explode(':', $rate);
				$data2 	= explode('/', $data[1]);
				$data3 	= explode('+', $data2[1]);
				$a		= $data[0];
				$b		= $data2[0];
				$c		= $data3[0];
				$d		= $data3[1];
			}
			if (strpos($b, '%')) {
				$b = $total * ($b / 100);
			}
			if (strpos($d, '%')) {
				$d = $total * ($d / 100);
			}
			if ($a < $value && $a !== '~') {
				if ($b && $c) {
					$cost += ceil(($a - $prev) / $c) * $b;
				} else {
					$cost += $b;
				}
				$cost += $d;
				$debug .= ' | RatesFound: SUCCESS (' . $rate . ')';
				$debug .= ' | RateCost: ' . $cost;
				$prev = $a;
			} else {
				if ($b && $c) {
					$cost += ceil(($value - $prev) / $c) * $b;
				} else {
					$cost += $b;
				}
				$cost += $d;
				$debug .= ' | RatesFound: SUCCESS (' . $rate . ')';
				$debug .= ' | RateCost: ' . $cost;
				$max_found = true;
				break;
			}
		}
		if (!$max_found) {
			$cost	= '';
			$debug 	= ' | RatesFound: VALUE EXCEEDS MAX RATE';
		}
		return array(
			'cost'	=> $cost,
			'debug'	=> $debug
		);
	}
	

	private function getShipping($code, $rates, $address) {
		$cost 	= '';
		$debug 	= '';
		
		$this->load->model('shipping/' . $code);
		$shipping_method = $this->{'model_shipping_' . $code}->getQuote($address);
		
		if ($shipping_method && empty($shipping_method['error'])) {
			foreach ($shipping_method['quote'] as $quote) {
				if (count($shipping_method['quote']) > 1) {
					if ($rates && (strpos(strtolower($quote['code']), strtolower($rates)) !== false || strpos(strtolower($quote['title']), strtolower($rates)) !== false)) {
						$cost += $quote['cost'];
						$debug	.= ' | CalculateShipping' . strtoupper($code) . '-' . ucfirst($rates) . ': ' . $quote['cost'];
						break;
					}
				} else {
					$cost += $quote['cost'];
					$debug	.= ' | CalculateShipping' . strtoupper($code) . ': ' . $quote['cost'];
				}
			}
		} elseif ($this->debugStatus) {
			if ($shipping_method) {
				$debug	.= ' | ' . strtoupper($code) . 'Error: ' . (!empty($shipping_method['error']) ? ucfirst($shipping_method['error']) : 'Unknown');
			} else {
				$debug	.= ' |  ' . strtoupper($code) . ': EMPTY';
			}
		}
		return array(
			'cost'	=> $cost,
			'debug'	=> $debug
		);
	}
	
    private function checkStores($stores) {
		$status = true;
		
		$debug = ' | StoreId: ' . (int)$this->config->get('config_store_id');
		if (!in_array((int)$this->config->get('config_store_id'), $stores)) {
			$status = false;
		}
		return array(
			'status'	=> $status,
			'debug'		=> $debug
		);
	}

	private function checkCustomer($customer_group_id, $customer_groups) {
		$status = true;
		
		$debug = ' | CustomerGroupId: ' . $customer_group_id;
		if (!in_array(-1, $customer_groups) && !in_array((int)$customer_group_id, $customer_groups)) {
			$status = false;
		}
		return array(
			'status'	=> $status,
			'debug'		=> $debug
		);
	}


	private function checkGeoZones($geo_zones) {
		$status = false;
		$debug	= '';
		
		foreach ($this->cartGeoZones as $geo_zone) {
			if (in_array($geo_zone['geo_zone_id'], $geo_zones)) {
				$status = true;
				$debug .= ' | GeoZone: ' . $geo_zone['name'];
				break;
			}
		}
		
		return array(
			'status'	=> $status,
			'debug'		=> $debug
		);
	}

private function checkRequirement($requirement_cost, $group, $type, $operation, $value, $parameter, &$products, $cart, $customer, $other) {
		if ($group && $type && $operation && $value && $products) {
			$type = str_replace($group . '_', '', $type);
			if ($group == 'product') {
				$values = (is_array($value)) ? $value : explode(',', $value);
				$match_status = false;
				foreach ($products as $key => $product) {
					$status = ($operation == 'neq' || $operation == 'nstrpos') ? true : false;
					if ($type == 'category') {
						foreach ($product[$type] as $category) {
							//$this->writeDebug('Product: ' . $product['name'] . ' | Group: ' . $group . ' | Type: ' . $type . ' | Operation: ' . $operation . ' | Value: ' . $category['category_id']);
							if (in_array($category['category_id'], $values)) {
								//$this->writeDebug('Result: CATEGORY FOUND');
								$status = ($operation == 'eq') ? true : false;
								break;
							}
						}
					} else {
						foreach ($values as $value) {
							$value			= trim(strtolower($value));
							$product[$type]	= trim(strtolower($product[$type]));
							//$this->writeDebug('Product: ' . $product['name'] . ' | Group: ' . $group . ' | Type: ' . $type . ' | Operation: ' . $operation . ' | Value: ' . $value . ' | Result: ' . $product[$type] . '');
							if ($operation == 'eq' && $product[$type] == $value) { $status = true; break; }
							if ($operation == 'neq' && $product[$type] == $value) { $status = false; break; }
							if ($operation == 'strpos' && strpos($product[$type], $value) !== false) { $status = true; break; }
							if ($operation == 'nstrpos' && strpos($product[$type], $value) !== false) { $status = false; break; }
							if ($operation == 'gte' && $product[$type] >= $value) { $status = true; }
							if ($operation == 'lte' && $product[$type] <= $value) { $status = true; break; }
						}
					}
					if ($parameter['match'] == 'all' && !$status) { return false; }
					if ($parameter['match'] == 'any' && $status) { $match_status = true; }
					if ($parameter['match'] == 'none' && $status) { return false; }
					if ($requirement_cost == 'all' && !$status) { unset($products[$key]); }
					if ($requirement_cost == 'any' && !$status) { unset($products[$key]); }
					if ($requirement_cost == 'none' && $status) { unset($products[$key]); }
				}
				if ($match_status) { return true; }
				return ($parameter['match'] == 'none' || $parameter['match'] == 'all') ? true : false;
			} elseif ($group == 'cart') {
				(float)$value;
				if ($operation == 'eq' && $cart[$type] == $value) { return true; }
				if ($operation == 'neq' && $cart[$type] != $value) { return true; }
				if ($operation == 'gte' && $cart[$type] >= $value) { return true; }
				if ($operation == 'lte' && $cart[$type] <= $value) { return true; }
			} elseif ($group == 'customer') {
				$status = ($operation == 'neq' || $operation == 'nstrpos') ? true : false;
				$values = explode(',', $value);
				foreach ($values as $value) {
					$value				= trim(strtolower($value));
					$customer[$type]	= trim(strtolower($customer[$type]));
					//$this->writeDebug('Group: ' . $group . ' | Type: ' . $type . ' | Operation: ' . $operation . ' | Value: ' . $value . ' | Result: ' . $customer[$type]);
					if ($type == 'postcode') {
						$postcode_status = $this->checkPostalCodes($customer['postcode'], $value, $parameter['type']);
						//$this->writeDebug($postcode_status['debug']);
						if ($postcode_status['status']) {
							if ($operation == 'eq') { $status = true; }
							if ($operation == 'neq') { $status = false; }
							break;
						}
					} else {
						if ($operation == 'eq' && $customer[$type] == $value) { $status = true; break; }
						if ($operation == 'neq' && $customer[$type] == $value) { $status = false; break; }
						if ($operation == 'strpos' && strpos($customer[$type], $value) !== false) { $status = true; break; }
						if ($operation == 'nstrpos' && strpos($customer[$type], $value) !== false) { $status = false; break; }
					}
				}
				return $status;
			} else {
				$value			= trim($value);
				$other[$type]	= trim($other[$type]);
				//$this->writeDebug('Group: ' . $group . ' | Type: ' . $type . ' | Operation: ' . $operation . ' | Value: ' . $value . ' | Result: ' . $other[$type]);
				if ($operation == 'eq' && $other[$type] == $value) { return true; }
				if ($operation == 'neq' && $other[$type] !== $value) { return true; }
				if ($operation == 'gte' && $other[$type] >= $value) { return true; }
				if ($operation == 'lte' && $other[$type] <= $value) { return true; }
			}
		}
		//$this->writeDebug('You Have Reached The End!');
		return false;
	}
	


	private function writeDebug($debug) {
		$write 	= date('Y-m-d h:i:s');
		$write .= ' - ';
		//$write .= $debug;
		
		$write .= json_encode($debug);
		$write .= "\n";
		
		$file	= DIR_LOGS .  'test.txt';
		
		file_put_contents ($file, $write, FILE_APPEND);
	}	

}
