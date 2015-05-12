<?php
class CampaignsController extends AppController {

	public $uses = array('Campaign', 'ShopBrochure', 'CampaignShopBrochure');

	public $components = array('Paginator'); 

	public function beforeRender() {
		$this->set('Module', 'Campañas');
	}

	public function read_shop_brochures() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$data = $this->request->data;
		$data['ShopBrochure']['release_date'] = strtotime(implode('/', array_reverse(explode('/', $data['ShopBrochure']['release_date']))));
		$data['ShopBrochure']['expiration_date'] = strtotime(implode('/', array_reverse(explode('/', $data['ShopBrochure']['expiration_date']))));
        if($this->request->is('ajax') AND $this->request->is('post') AND $ShopBrochures = $this->ShopBrochure->find('all', array('conditions' => array('release_date >=' => $data['ShopBrochure']['release_date'], 'expiration_date <=' => $data['ShopBrochure']['expiration_date'])))) {
        	$data['shop_brochures'] = $ShopBrochures;
        }
        die(json_encode($data));
	}

	public function read_campaign_shop_brochures($id = null) {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$data = array();
        if($this->request->is('ajax') AND $this->request->is('get') AND $id AND $CampaignShopBrochure = $this->CampaignShopBrochure->find('list', array('fields' => array('shop_brochure_id'), 'conditions' => array('campaign_id' => $id)))) {
        	$data['shop_brochures'] = array_values($CampaignShopBrochure);
        }
        die(json_encode($data));
	}
	
	public function index() {
		if ($this->request->is('post')) {
			$conditions = array();
			if ($this->data['Search']['Campaign']['first_name']) {
				$conditions['Campaign.first_name LIKE'] = '%'.$this->data['Search']['Campaign']['first_name'].'%';
			}
			if ($this->data['Search']['Campaign']['user_type_id'] > 0) {
				$conditions['Campaign.user_type_id ='] = $this->data['Search']['Campaign']['user_type_id'];
			}
			$this->Paginator->settings = array(
				'conditions' => $conditions
				);
			$this->set('rows', $this->paginate('Campaign'));
		} else if ($this->request->is('get')) {
			$this->set('rows', $this->paginate());
		}
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->Campaign->create();
			if ($Campaign = $this->Campaign->save($this->request->data)) {
				foreach ($this->request->data['CampaignShopBrochure']['shop_brochure_id'] as $k => $v) {
					$this->CampaignShopBrochure->create();
					$this->CampaignShopBrochure->save(array(
						'shop_brochure_id' => $v,
						'campaign_id' => $Campaign['Campaign']['id'],
						)
					);
				}
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		}
	}

	public function update($id = null) {
		$this->Campaign->id = $id;
		if (!$this->Campaign->exists()) {
			$this->Session->setFlash('Registro Invalido', 'flash');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Campaign->save($this->request->data)) {
				$this->CampaignShopBrochure->deleteAll(array('campaign_id' => $id));
				foreach ($this->request->data['CampaignShopBrochure']['shop_brochure_id'] as $k => $v) {
					$this->CampaignShopBrochure->create();
					$this->CampaignShopBrochure->save(array(
						'shop_brochure_id' => $v,
						'campaign_id' => $id,
						)
					);
				}
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->request->data = $this->Campaign->read(null, $id);
			$this->render('create');
		}
	}

	public function delete($id = null) {
		$this->Campaign->id = $id;
		if (!$this->Campaign->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		}
		if ($this->Campaign->delete()) {
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}
	
}