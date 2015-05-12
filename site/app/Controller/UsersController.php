<?php
class UsersController extends AppController {

	public $uses = array('User', 'UserCart', 'UserResellerGroup');

	public $autoRender = false;

	// public function beforeFilter() {
	// 	if ($this->request['params']['action'] != 'login') {
	// 		if (!$this->Session->read('User')) {
	// 			die(json_encode(array('login' => false)));
	// 		}
	// 	} 
	// }

	public function login() {
		$data['login'] = false;
		if ($this->request->is('post')) {
			$this->User->recursive = -1;
			if (!$User = $this->User->findByFacebookUserId($this->request->data['User']['id'])) {
				$User = $this->create($this->request->data['User']);
			} else {
				$User = $this->User->findByFacebookUserId($this->request->data['User']['id']);
			}
			$this->UserCart->recursive = -1;
			$UserCart = $this->UserCart->find('first', array(
				'conditions' => array(
					'user_id' => $User['User']['id'],
					'user_cart_status_flags' => 0,
	        		'purchase_date' => null,
	        		'order_date' => null,
					)
				)
			);
			if (!empty($this->request->data['UserResellerGroup'])) {
				$this->UserResellerGroup->recursive = -1;
				$UserResellerGroup['UserResellerGroup'] = $this->request->data['UserResellerGroup'];
				$UserResellerGroup['UserResellerGroup']['user_id'] = $User['User']['id'];
				if (!$this->UserResellerGroup->find('first', array('conditions' => $UserResellerGroup['UserResellerGroup']))) {
					$UserResellerGroup = $this->UserResellerGroup->save($UserResellerGroup);
				}
				$this->User->id = $User['User']['id'];
				if ($this->User->exists()) {
					$this->User->save(array('user_type_id' => 2));
					$User['User']['user_type_id'] = 2;
				}
			}
			$User['User']['picture'] = Router::url('/images/users/'.$User['User']['picture'], true);
			$data['User'] = $User['User'];
			if (!empty($UserCart)) {
				$data['UserCart'] = $UserCart['UserCart'];
			}
			if ($this->Session->write('User', $User)) {
				$data['login'] = true;
			}
		}
		die(json_encode($data));
	}

	public function logout() {
		if ($this->request->is('post')) {
			$this->Session->destroy();
			die(json_encode(array('session' => false)));
		}
	}

	private function create($request) {
		$request['facebook_user_id'] = $request['id'];
		if ($size = getimagesize($request['picture']) AND is_array($size) AND array_key_exists(2, $size)) {
			$extension = strtolower(image_type_to_extension($size[2]));
			$name = md5(uniqid(mt_rand())) . $extension;
			if (copy($request['picture'], WWW_ROOT . 'images/users/' . $name)) {
				$request['picture'] = $name;
			} else {
				$request['picture'] = 'dafault.jpg';
			}
		} else {
				$request['picture'] = 'dafault.jpg';
		}
		unset($request['id'], $request['gender'], $request['link'], $request['locale'], $request['name'], $request['timezone'], $request['updated_time'], $request['verified']);
		$User['User'] = $request;
		$this->User->create();
		if ($User = $this->User->save($User)) {
			return $User;
		} else {
			return false;
		}
	}

	public function user_type() {
		$data['result'] = false;
		if ($this->request->is('post')) {
			$this->User->id = $this->Session->read('User')['User']['id'];
			if ($this->User->exists() AND $this->User->save($this->request->data)) {
				$data['result'] = true;
			}
		}
		die(json_encode($data));
	}

	public function orders_by_customers($date = null) {
        $User = $this->Session->read('User');
        $this->UserCart->Behaviors->load('Containable');
        $this->UserCart->contain(array(
			'User',
			'UserCartDetail' => array(
				'ShopBrochureProduct' => array(
					'Product', 
					'ShopBrochure' => array(
						'CampaignShopBrochure' => 'Campaign', 
						'ShopBrochureImage' => array(
							'conditions' => array(
								'ShopBrochureImage.order' => 0
								)
							)
						)
					)
				)
        	)
        );
        $UserCart = $this->UserCart->find('all', array(
        	'conditions' => array(
        		'reseller_user_id' => $User['User']['id'], 
        		'user_cart_status_flags' => 1,
        		'purchase_date' => $date,
        		'order_date !=' => null,
        		)
        	)
        );
        $total_quantity = 0;
        foreach ($UserCart as $k => $v) {
            $UserCart[$k]['User']['picture'] = Router::url('/images/users/' . $v['User']['picture'], true);
            $total_quantity = $total_quantity + $v['UserCart']['total_quantity'];
            foreach ($v['UserCartDetail'] as $k2 => $v2) {
            	$UserCart[$k]['UserCartDetail'][$v2['ShopBrochureProduct']['shop_brochure_id']]['User'] = $UserCart[$k]['User'];
            	$UserCart[$k]['UserCartDetail'][$v2['ShopBrochureProduct']['shop_brochure_id']]['UserCart'] = $UserCart[$k]['UserCart'];
            	$UserCart[$k]['UserCartDetail'][$v2['ShopBrochureProduct']['shop_brochure_id']][] = $v2;
            	unset($UserCart[$k]['UserCartDetail'][$k2]);
            }
            unset($UserCart[$k]['User'], $UserCart[$k]['UserCart']);
        }
        $UserCartDetail = array();
        foreach ($UserCart as $k => $v) {
            foreach ($v['UserCartDetail'] as $k2 => $v2) {
            	$UserCartDetail[$k2][] = $v2;
            }
        }
        $data['UserCart'] = array_values($UserCartDetail);
        $data['total_quantity'] = $total_quantity;
        if ($date) {
	        $data['parchuse_date'] = date('d/m/Y', $date);
	        $data['customers'] = count($data['UserCart']);
        }
        die(json_encode($data));
    }

    public function orders_by_products($date = null) {
        $User = $this->Session->read('User');
        $this->UserCart->Behaviors->load('Containable');
        $this->UserCart->contain(array(
			'User',
			'UserCartDetail' => array(
				'ShopBrochureProduct' => array(
					'Product', 
					'ShopBrochure' => array(
						'CampaignShopBrochure' => 'Campaign', 
						'ShopBrochureImage' => array(
							'conditions' => array(
								'ShopBrochureImage.order' => 0
								)
							)
						)
					)
				)
        	)
        );
        $UserCart = $this->UserCart->find('all', array(
        	'conditions' => array(
        		'reseller_user_id' => $User['User']['id'], 
        		'user_cart_status_flags' => 1,
        		'purchase_date' => $date,
        		'order_date !=' => null,
        		)
        	)
        );
        $rows = array();
        foreach ($UserCart as $k => $v) {
            foreach ($v['UserCartDetail'] as $k2 => $v2) {
            	$rows[$v2['ShopBrochureProduct']['shop_brochure_id']][$v2['ShopBrochureProduct']['id']]['Products'][] = $UserCart[$k]['UserCartDetail'][$k2]['ShopBrochureProduct'];
            	$rows[$v2['ShopBrochureProduct']['shop_brochure_id']][$v2['ShopBrochureProduct']['id']]['total_quantity'] = count($rows[$v2['ShopBrochureProduct']['shop_brochure_id']][$v2['ShopBrochureProduct']['id']]['Products']);
            }
        }
        $rows = array_values($rows);
        $total_quantity = 0;
        foreach ($rows as $k => $v) {
        	$rows[$k] = array_values($rows[$k]);
        	foreach ($v as $k2 => $v2) {
        		$total_quantity = $total_quantity + $v2['total_quantity'];
        	}
        }
        $data['total_quantity'] = $total_quantity;
        $data['ShopBrochure'] = $rows;
        if ($date) {
	        $data['parchuse_date'] = date('d/m/Y', $date);
        }
        die(json_encode($data));
    }

    public function close_order() {
    	if ($this->request->is('post')) {
    		$User = $this->Session->read('User');
    		$User = $User['User'];
    		$this->UserCart->updateAll(
    			array(
    				'UserCart.purchase_date' => time(),
    			),
    			array(
    				'UserCart.reseller_user_id' => $User['id'],
    				'UserCart.user_cart_status_flags' => 1,
    				'UserCart.purchase_date' => null,
    				'UserCart.order_date !=' => null,
    			)
    		);
    	}
        $this->orders_by_customers();
    }

    public function order_history() {
        $User = $this->Session->read('User');
    	$User = $User['User'];
        $UserCart = $this->UserCart->find('all', array(
        	'conditions' => array(
        		'reseller_user_id' => $User['id'], 
        		'user_cart_status_flags' => 1,
        		'purchase_date !=' => null,
        		'order_date !=' => null,
        		)
        	)
        );
        $data = array();
        foreach ($UserCart as $k => $v) {
        	$data[$v['UserCart']['purchase_date']][] = $v;
        }
        $data = array_values($data);
        foreach ($data as $k => $v) {
        	$total_quantity = 0;
        	foreach ($v as $k2 => $v2) {
        		$total_quantity = $v2['UserCart']['total_quantity'] + $total_quantity;
        		$data[$k]['purchase_date'] = date('d/m/Y H:m:s', $data[$k][$k2]['UserCart']['purchase_date']);
        		$data[$k][$k2]['UserCart']['purchase_date_unix'] = $data[$k][$k2]['UserCart']['purchase_date'];
        		$data[$k][$k2]['UserCart']['purchase_date'] = date('d/m/Y H:m:s', $data[$k][$k2]['UserCart']['purchase_date']);
        	}
        	$data[$k]['total_quantity'] = $total_quantity;
        }
        $data = array_values($data);
        die(json_encode($data));
    }
	
}