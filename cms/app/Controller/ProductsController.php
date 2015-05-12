<?php
class ProductsController extends AppController {

	public $uses = array('Product', 'Category');

	public $components = array('Paginator'); 

	public function beforeRender() {
		$this->set('Module', 'Productos');
	}
	
	public function index() {
		if ($this->request->is('post')) {
			$conditions 							= array();
			if ($this->data['Search']['Product']['first_name']) {
				$conditions['Product.first_name LIKE'] = '%'.$this->data['Search']['Product']['first_name'].'%';
			}
			if ($this->data['Search']['Product']['product_type_id'] > 0) {
				$conditions['Product.product_type_id ='] = $this->data['Search']['Product']['product_type_id'];
			}
			$this->Paginator->settings = array(
				'conditions'	=> $conditions
				);
			$this->set('rows', $this->paginate('Product'));
		} else if ($this->request->is('get')) { 
			$this->set('rows', $this->paginate());
		}
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		}
		$this->set('ProductCategoryName', '');
	}

	public function update($id = null) {
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			$this->Session->setFlash('Registro Invalido', 'flash');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->request->data = $this->Product->read(null, $id);
			$this->set('ProductCategoryName', $this->read_categories($this->request->data['Product']['category_id']));
			$this->render('create');
		}
	}

	private function read_categories($id = null) {
		$this->autoRender = false;
		$categories = $this->read_parent($id);
		$categories = explode('/', $categories);
		$categories = array_reverse($categories);
		foreach ($categories as $k => $v) {
			if (!$v) {
				unset($categories[$k]);
			}
		}
		$categories = implode('/', $categories);
        return $categories;
	}

	private function read_parent($id) {
        $row = $this->Category->findById($id);
        $menu = '/';
        if ($row) {
	        $menu .= $row['Category']['name'];
	        $menu .= $this->read_parent($row['Category']['parent_category_id']);
        }
        return $menu;
    }

	public function delete($id = null) {
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		}
		if ($this->Product->delete()) {
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}

	public function download_template() {
		$this->autoRender = false; 
		$file = Router::url('/files/plantilla.xls', true);
		header("Content-disposition: attachment; filename=plantilla.xls");
		header("Content-type: application/octet-stream");
		readfile($file);
	}

	public function import() {
		if ($this->request->is('post')) {

			if (isset($this->request['data']['Product']['file']) AND $this->request['data']['Product']['file']['error'] === 0) {

				if (!in_array($this->request['data']['Product']['file']['type'], array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/octet-stream'))) {
					$this->Session->setFlash('Extensión no permitida', 'flash');
					return;
				}

				App::uses('PHPExcel', 'Lib/PHPExcel');
				if (!class_exists('PHPExcel')) {
					throw new CakeException('Lib Class PHPExcel not found.');
					return;
				}
				PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
				$excel 									= PHPExcel_IOFactory::load($this->request['data']['Product']['file']['tmp_name']);
				$rows  									= $excel->getSheet()->toArray(null,true,true,false);
				foreach ($rows as $k => $v) {	
					$rows[$k] 							= array_filter($rows[$k]);
				}
				$rows 									= array_filter($rows);

				unset($rows[0]);

				// echo '<pre>';
				// print_r($rows);
				// echo '</pre>';
				// exit;

				foreach ($rows as $k => $v) {

					if (array_key_exists(4, $v)) {
						if ($Category = $this->Category->findByName($v[4])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[4];
							$this->Category->parent_category_id = 0;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(5, $v)) {
						if ($Category = $this->Category->findByName($v[5])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[5];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(6, $v)) {
						if ($Category = $this->Category->findByName($v[6])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[6];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(7, $v)) {
						if ($Category = $this->Category->findByName($v[7])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[7];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(8, $v)) {
						if ($Category = $this->Category->findByName($v[8])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[8];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(9, $v)) {
						if ($Category = $this->Category->findByName($v[9])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[9];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(10, $v)) {
						if ($Category = $this->Category->findByName($v[10])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[10];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(11, $v)) {
						if ($Category = $this->Category->findByName($v[11])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[11];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(12, $v)) {
						if ($Category = $this->Category->findByName($v[12])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[12];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (array_key_exists(13, $v)) {
						if ($Category = $this->Category->findByName($v[13])) {
							$parent_category_id = $Category['Category']['parent_category_id'];
							$category_id 						= $parent_category_id;
						} else {
							$this->Category->create();
							$this->Category->name		 		= $v[13];
							$this->Category->parent_category_id = $parent_category_id;
							$this->Category->save($this->Category);
							$parent_category_id                 = $this->Category->getInsertID();
							$category_id 						= $parent_category_id;
						}
					}

					if (!$this->Product->findByName($v[0])) {
							$this->Product->create();
							$this->Product->name		= $v[0];
							$this->Product->description = $v[1];
							$this->Product->price 		= $v[2];
							$this->Product->code 		= $v[3];
							$this->Product->category_id = $category_id;
							$this->Product->save($this->Product);
					}
				}	
				$this->Session->setFlash('Excel importado con éxito', 'flash');
				return;
			}
			$this->Session->setFlash('No seleccionó ningun archivo', 'flash');
		}
	}
	
}