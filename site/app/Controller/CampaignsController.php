<?php
class CampaignsController extends AppController {

	public $uses = array('Campaign', 'CampaignShopBrochure', 'ShopBrochure', 'ShopBrochureImage');

	public $autoRender = false;

    public function beforeFilter() {
        if (!$this->Session->read('User')) {
            die(json_encode(array('login' => false)));
        }
    }

	public function index() {
		if($this->request->is('get')) {
            $Campaigns = $this->Campaign->find('all', array('conditions' => array('start_date <=' => time(), 'end_date >=' => time())));
            foreach ($Campaigns as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == 'CampaignShopBrochure') {
                        foreach ($v2 as $k3 => $v3) {
                            $ShopBrochure = $this->ShopBrochure->find('first', array('conditions' => array('id' => $v3['shop_brochure_id'])));
                            $Campaigns[$k][$k2][$k3]['ShopBrochure'] = $ShopBrochure['ShopBrochure'];
                            $ShopBrochureImage = $this->ShopBrochureImage->find('first', array('conditions' => array('shop_brochure_id' => $v3['shop_brochure_id'], 'order' => 0)));
                            $Campaigns[$k][$k2][$k3]['ShopBrochureImage'] = $ShopBrochureImage['ShopBrochureImage'];
                        }
                    }
                }
            }
        }
        die(json_encode($Campaigns));
	}
	
}