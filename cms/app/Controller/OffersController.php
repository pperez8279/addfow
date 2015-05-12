<?php
class OffersController extends AppController {

	public $uses = array('Offer', 'OfferType', 'ShopBrochure', 'ShopBrochureImage', 'ShopBrochureProduct', 'OfferProductGroup');

	public $components = array('Paginator'); 

	public function beforeRender() {
		$this->set('Module', 'Ofertas');
	}

	public function read_products($id = null) {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$data = array();
        if($this->request->is('ajax') AND $this->request->is('get') AND $id AND $ShopBrochureProduct = $this->ShopBrochureProduct->find('all', array('conditions' => array('shop_brochure_id' => $id)))) {
        	$data['products'] = $ShopBrochureProduct;
        }
        die(json_encode($data));
	}

	public function read_offer_product($id = null) {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$data = array();
        if($this->request->is('ajax') AND $this->request->is('get') AND $id AND $OfferProductGroup = $this->OfferProductGroup->find('list', array('fields' => array('shop_brochure_product_id'), 'conditions' => array('offer_id' => $id)))) {
        	$data['products'] = array_values($OfferProductGroup);
        }
        die(json_encode($data));
	}
	
	public function index() {
		$this->set('OfferTypes', $this->OfferType->find('list', array('fields' => array('id', 'name'))));
		if ($this->request->is('post')) {
			$conditions = array();
			if ($this->data['Search']['Offer']['first_name']) {
				$conditions['Offer.first_name LIKE'] = '%'.$this->data['Search']['Offer']['first_name'].'%';
			}
			if ($this->data['Search']['Offer']['user_type_id'] > 0) {
				$conditions['Offer.user_type_id ='] = $this->data['Search']['Offer']['user_type_id'];
			}
			$this->Paginator->settings = array(
				'conditions' => $conditions
				);
			$this->set('rows', $this->paginate('Offer'));
		} else if ($this->request->is('get')) {
			$this->set('rows', $this->paginate());
		}
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->Offer->create();
			if ($Offer = $this->Offer->save($this->request->data)) {
				foreach ($this->request->data['OfferProductGroup']['shop_brochure_product_id'] as $k => $v) {
					$this->OfferProductGroup->create();
					$this->OfferProductGroup->save(array(
						'shop_brochure_product_id' => $v,
						'shop_brochure_id' => $this->request->data['OfferProductGroup'][0]['shop_brochure_id'],
						'price' => $this->request->data['OfferProductGroup'][0]['price'],
						'code' => $this->request->data['OfferProductGroup'][0]['code'],
						'offer_id' => $Offer['Offer']['id'],
						)
					);
				}
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		}
		$this->set('ShopBrochures', $this->ShopBrochure->find('list', array('fields' => array('id', 'name'), 'conditions'	=> array('name !=' => null))));
		$this->set('OffersTypes', $this->OfferType->find('list', array('fields' => array('id', 'name'))));
	}

	public function update($id = null) {
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			$this->Session->setFlash('Registro Invalido', 'flash');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Offer->save($this->request->data)) {
				$this->OfferProductGroup->deleteAll(array('offer_id' => $id));
				foreach ($this->request->data['OfferProductGroup']['shop_brochure_product_id'] as $k => $v) {
					$this->OfferProductGroup->create();
					$this->OfferProductGroup->save(array(
						'shop_brochure_product_id' => $v,
						'shop_brochure_id' => $this->request->data['OfferProductGroup'][0]['shop_brochure_id'],
						'price' => $this->request->data['OfferProductGroup'][0]['price'],
						'code' => $this->request->data['OfferProductGroup'][0]['code'],
						'offer_id' => $id,
						)
					);
				}
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->request->data = $this->Offer->read(null, $id);
			$this->set('ShopBrochures', $this->ShopBrochure->find('list', array('fields' => array('id', 'name'), 'conditions'	=> array('name !=' => null))));
			$this->set('OffersTypes', $this->OfferType->find('list', array('fields' => array('id', 'name'))));
			$this->render('create');
		}
	}

	public function delete($id = null) {
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		}
		if ($this->Offer->delete()) {
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}
	
}