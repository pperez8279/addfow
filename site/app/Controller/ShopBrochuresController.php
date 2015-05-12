<?php
class ShopBrochuresController extends AppController {

	public $uses = array('ShopBrochure', 'ShopBrochureImage', 'ShopBrochureProduct', 'Product', 'Campaign', 'CampaignShopBrochure', 'UserCart', 'UserCartDetail', 'UserResellerGroup');

	public $autoRender = false;

    public function beforeFilter() {
        if (!$this->Session->read('User')) {
            die(json_encode(array('login' => false)));
        }
    }

    public function read($id = null) {
        if ($this->request->is('get') AND $id AND is_numeric($id)) {
            $ShopBrochure = $this->ShopBrochure->find('first', array('conditions'=> array('ShopBrochure.id' => $id)));
            foreach ($ShopBrochure['ShopBrochureImage'] as $k => $v) {
                $ShopBrochure['ShopBrochureImage'][$k]['url'] = str_replace('site', 'cms', Router::url('/images/brochure_' . $id . '/original/' . $v['name'], true));
            }
            $Campaign = $this->CampaignShopBrochure->find('first', array('conditions' => array('shop_brochure_id' => $id)));
            $ShopBrochure['Campaign'] = $Campaign['Campaign'];
            die(json_encode($ShopBrochure));
        }
    }

	public function read_products($id = null) {
        if($this->request->is('get') AND $id AND is_numeric($id)) {
            $ShopBrochureProduct = $this->ShopBrochureProduct->find('all', array('conditions' => array('shop_brochure_image_id' => $id)));
            foreach ($ShopBrochureProduct as $k => $v) {
                $ShopBrochureProduct[$k]['ShopBrochureProduct']['coords'] = json_decode($v['ShopBrochureProduct']['coords']);
            }
            die(json_encode($ShopBrochureProduct));
        }
    }

    public function delete_product() {
        $data['result'] = false;
        if($this->request->is('post') AND $this->request->data('id') AND is_numeric($this->request->data('id'))) {
            if ($this->UserCartDetail->delete($this->request->data('id'))) {
                $data = $this->read_cart();
            }
        }
        die(json_encode($data));
    }

    public function cart() {
        $data['result'] = false;
        if($this->request->is('post')) {
            $User = $this->Session->read('User');
            $this->UserCart->Behaviors->load('Containable');
            $this->UserCart->contain(array(
                'UserCartDetail' => array(
                    'ShopBrochureProduct'
                    )
                )
            );
            if (!$UserCart = $this->UserCart->find('first', array('conditions' => array('user_id' => $User['User']['id'], 'user_cart_status_flags' => 0)))) {
                $this->UserCart->create();
                $UserCart = $this->UserCart->save(array('user_id' => $User['User']['id']));
            }
            if (!$UserCartDetail = $this->UserCartDetail->find('first', array('conditions' => array('user_cart_id' => $UserCart['UserCart']['id'], 'UserCartDetail.product_id' => $this->request->data['UserCartDeteail']['product_id'])))) {
                $this->UserCartDetail->create();
                if ($UserCartDetail = $this->UserCartDetail->save(array('user_cart_id' => $UserCart['UserCart']['id'], 'product_id' => $this->request->data['UserCartDeteail']['product_id']))) {
                    $data['result'] = true;
                }
            } else {
                $this->UserCartDetail->id = $UserCartDetail['UserCartDetail']['id'];
                $UserCartDetail['UserCartDetail']['quantity'] = $UserCartDetail['UserCartDetail']['quantity'] + 1;
                if ($this->UserCartDetail->exists() AND $this->UserCartDetail->save($UserCartDetail)) {
                    $data['result'] = true;
                }
            }
            $total_quantity = 0;
            $total_price = 0;
            $this->UserCart->Behaviors->load('Containable');
            $this->UserCart->contain(array(
                'UserCartDetail' => array(
                    'ShopBrochureProduct'
                    )
                )
            );
            $UserCart = $this->UserCart->find('first', array('conditions' => array('user_id' => $User['User']['id'], 'user_cart_status_flags' => 0)));
            foreach ($UserCart['UserCartDetail'] as $k => $v) {
                $total_quantity = $total_quantity + $v['quantity'];
                $total_price = $total_price + ($v['quantity'] * $v['ShopBrochureProduct']['price']);
            }
            $this->UserCart->id = $UserCart['UserCart']['id'];
            $data['UserCart'] = $this->UserCart->save(array('total_quantity' => $total_quantity, 'total_price' => $total_price))['UserCart'];
        } else if ($this->request->is('get')) {
            $data = $this->read_cart();
        }
        die(json_encode($data));
    }

    private function read_cart() {
        $data['result'] = false;
        $data['UserCartDeteail'] = array(); 
        $data['Reseller'] = array();
        $User = $this->Session->read('User');
        $this->UserCart->Behaviors->load('Containable');
        $this->UserCart->contain( array(
            'UserCartDetail' => array(
                'ShopBrochureProduct' => array(
                    'Product', 'ShopBrochure' => array(
                        'CampaignShopBrochure' => 'Campaign', 'ShopBrochureImage' => array(
                            'conditions' => array(
                                'ShopBrochureImage.order' => 0
                                )
                            )
                        )
                    )
                ),
            )
        );
        if ($UserCart = $this->UserCart->find('first', array('conditions' => array('user_id' => $User['User']['id'], 'user_cart_status_flags' => 0)))) {
            $filter = array();
            $total_quantity = 0;
            foreach ($UserCart['UserCartDetail'] as $k => $v) {
                    $total_quantity = $total_quantity + $v['quantity'];
                    $filter[$UserCart['UserCartDetail'][$k]['ShopBrochureProduct']['shop_brochure_id']]['UserCartDetail'][] = $v;
                    $filter[$UserCart['UserCartDetail'][$k]['ShopBrochureProduct']['shop_brochure_id']]['UserCart'] = $UserCart['UserCart'];
            }
            $data['total_quantity'] = $total_quantity;
            $data['result'] = true;
            $data['UserCartDeteail'] = array_values($filter);
            $this->UserResellerGroup->recursive = -1;
            $this->UserResellerGroup->Behaviors->load('Containable');
            $this->UserResellerGroup->contain(array(
                'User' => array(
                    )
                )
            );
            $Reseller = $this->UserResellerGroup->find('all', array('conditions' => array('user_id' => $User['User']['id'])));
            foreach ($Reseller as $k => $v) {
                $Reseller[$k]['User']['picture'] = Router::url('/images/users/' . $v['User']['picture'], true);
            }
            $data['Reseller'] = $Reseller;
        }
        return $data;
    }

    public function send_cart() {
        $data['result'] = false;
        if($this->request->is('post')) {
            $User = $this->Session->read('User');
            $User = $User['User'];
            $this->UserCart->recursive = -1;
            $UserCart = $this->UserCart->find('first', array(
                'conditions' => array(
                    'user_id' => $User['id'],
                    'reseller_user_id' => null, 
                    'user_cart_status_flags' => 0,
                    'purchase_date' => null,
                    'order_date' => null,
                    )
                )
            );
            if ($UserCart) {
                $data = array(
                    'reseller_user_id' => $this->request->data['UserCart']['reseller_user_id'],
                    'user_cart_status_flags' => 1,
                    'order_date' => time(),
                );
                $this->UserCart->id = $UserCart['UserCart']['id'];
                if ($this->UserCart->exists() AND $this->UserCart->save($data)) {
                    $data = $this->read_cart();
                    $data['result'] = true;
                }
            }
        }
        die(json_encode($data));
    }
	
}