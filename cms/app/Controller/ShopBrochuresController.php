<?php
class ShopBrochuresController extends AppController {

	public $uses = array('ShopBrochure', 'ShopBrochureImage', 'ShopBrochureProduct', 'Product');
	
	public $components = array('Paginator');

	public function beforeRender() {
		$this->set('Module', 'Catálogos');
	}
	
	public function index() {
		$this->read();
	}

	public function create() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->ShopBrochure->id = $this->request->data['ShopBrochure']['id'];
			if (!$this->ShopBrochure->exists()) {
				$this->Session->setFlash('Registro Invalido', 'flash');
				$this->redirect(array('action' => 'index'));
			}
			$this->ShopBrochure->create();
			if ($this->ShopBrochure->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->ShopBrochure->create();
			$this->request->data = $this->ShopBrochure->save(array('name' => null));
		}
	}

	public function read() {
		$this->Paginator->settings = array('conditions'	=> array('ShopBrochure.name !=' => null));
		$this->set('rows', $this->paginate());
	}

	public function update($id = null) {
		$this->ShopBrochure->id = $id;
		if (!$this->ShopBrochure->exists()) {
			$this->Session->setFlash('Registro Invalido', 'flash');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ShopBrochure->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->request->data = $this->ShopBrochure->read(null, $id);
			$this->render('create');
		}
	}

	public function delete($id = null) {
		$this->ShopBrochure->id = $id;
		if (!$this->ShopBrochure->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		} else {
			$this->delete_folder(WWW_ROOT . 'images/brochure_'.$id);
			$this->ShopBrochure->delete();
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}

	private function delete_folder($path) {
	    if (is_dir($path) === true) {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
	        foreach ($files as $file) {
	            if (in_array($file->getBasename(), array('.', '..')) !== true) {
	                if ($file->isDir() === true) {
	                    rmdir($file->getPathName());
	                } else if (($file->isFile() === true) || ($file->isLink() === true)) {
	                    unlink($file->getPathname());
	                }
	            }
	        }
	        return rmdir($path);
	    } else if ((is_file($path) === true) || (is_link($path) === true)) {
	        return unlink($path);
	    }
	    return false;
	}

	public function files($id = null) {
		$this->autoRender = false;
		$this->layout = 'ajax';
		if ($this->request->is('post') AND $id) {
			$image = $this->request->data['ShopBrochureImage'];
			if ($image['error'] == 0) {
				$ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
				$name = md5(uniqid(mt_rand())) . '.' . $ext;

					if (!file_exists(WWW_ROOT . 'images/brochure_'.$id.'/original')) {
						mkdir(WWW_ROOT . 'images/brochure_'.$id.'/original', 0774, true);
					}
					if (!file_exists(WWW_ROOT . 'images/brochure_'.$id.'/small')) {
						mkdir(WWW_ROOT . 'images/brochure_'.$id.'/small', 0774, true);
					}
					if (!file_exists(WWW_ROOT . 'images/brochure_'.$id.'/products')) {
						mkdir(WWW_ROOT . 'images/brochure_'.$id.'/products', 0774, true);
					}

				if (move_uploaded_file($image['tmp_name'], WWW_ROOT . 'images/brochure_'.$id.'/original/' . $name)) {
					$this->ShopBrochureImage->create();
					$image_save = $this->ShopBrochureImage->save(array('shop_brochure_id' => $id, 'name' => $name));
					$info 					= new stdClass();
					$info->name 			= $name;
					$info->id 				= $image_save['ShopBrochureImage']['id'];
					$this->resize_small(WWW_ROOT . 'images/brochure_'.$id, $info);
					$info->type             = $image['type']; 
	                $info->ext              = $ext;
	                $info->url              = h(Router::url('/images/brochure_'.$id.'/original/'.$name, true));
	                $info->thumbnailUrl 	= h(Router::url('/images/brochure_'.$id.'/small/'.$name, true));
	                $info->deleteUrl        = h(Router::url('/shop_brochures/delete_file/'. $image_save['ShopBrochureImage']['id'], true));
	                $info->deleteType       = 'POST';
	                $info                   = array($info);
	                $result                 = new stdClass($info);
	                $result->files          = $info;
	                die(json_encode($result));
				}
			}
		} else if ($this->request->is('get') AND $id) {
			$data = array();
			$files = $this->ShopBrochureImage->find('all', array(
				'conditions' => array('shop_brochure_id' => $id),
				'order' => array('order' => 'asc'),
	        	)
	        );
            foreach($files as $k => $v) {
                $data[$k] = (object) 
                array(
                    'thumbnailUrl'  => h(Router::url('/images/brochure_'.$id.'/small/'    . $v['ShopBrochureImage']['name'], true)),
                    'url'           => h(Router::url('/images/brochure_'.$id.'/original/' . $v['ShopBrochureImage']['name'], true)),
                    'deleteUrl'     => h(Router::url('/shop_brochures/delete_file/' . $v['ShopBrochureImage']['id'], true)),
                    'name'          => $v['ShopBrochureImage']['name'],
                    'order'         => $v['ShopBrochureImage']['order'],
                    'id'            => $v['ShopBrochureImage']['id'],
                    'deleteType'    => 'POST'
                );
            }
            $data['files']          = $data;
            die(json_encode($data));
		}			
	}

	private function resize_small($route, $image) {
		$this->autoRender = false;
    	App::uses('WideImage', 'Lib/wideimage');
        $new_image = WideImage::load($route . '/original/' . $image->name);
        $new_image->resize(200, 200)->saveToFile($route . '/small/' . $image->name);
    }

    public function update_order() {
    	$this->autoRender = false;
    	foreach ($this->request['data']['order'] as $k => $v) {
    		$this->ShopBrochureImage->save(array('order' => $k, 'id' => $v));
    	}
	}

	public function delete_file($id = null) {
		$this->autoRender = false;
		$info          	  = new stdClass();
		$info->sucess     = false;
        if($this->request->is('ajax') AND $id) {
        	$this->ShopBrochureImage->id = $id;
        	if ($this->ShopBrochureImage->exists()) {
        		$file = $this->ShopBrochureImage->findById($id);
        		$name = $file['ShopBrochureImage']['name'];
        		$images_products = $this->ShopBrochureProduct->find('all', array('conditions' => array('shop_brochure_image_id' => $id)));
        		foreach ($images_products as $k => $v) {
        			@unlink(WWW_ROOT . 'images/brochure_'.$file['ShopBrochureImage']['shop_brochure_id'].'/products/' . $images_products[$k]['ShopBrochureProduct']['image']);
        		}
				@unlink(WWW_ROOT . 'images/brochure_'.$file['ShopBrochureImage']['shop_brochure_id'].'/original/' . $name);
				@unlink(WWW_ROOT . 'images/brochure_'.$file['ShopBrochureImage']['shop_brochure_id'].'/small/'    . $name);
            	if ($this->ShopBrochureImage->delete()) {
					$info->sucess  = true;
            	}
        	}
        }
        $info          = array($info);
		$result        = new stdClass();
		$result->files = $info;
		die(json_encode($result));
    }

    public function create_product() {
		if ($this->request->is('ajax') AND $this->request->is('post')) {
			$image = $this->request->data['ShopBrochureProduct']['coords'];
			$image['name'] = $this->ShopBrochureImage->findById($this->request->data['ShopBrochureProduct']['shop_brochure_image_id'])['ShopBrochureImage']['name'];
			
			$ext = strtolower(pathinfo(WWW_ROOT . 'images/brochure_' . $this->request->data['ShopBrochureProduct']['shop_brochure_id'].'/original/'.$image['name'], PATHINFO_EXTENSION));
			$name = md5(uniqid(mt_rand())) . '.' . $ext;
			$image['new_name'] = $name;

			$this->crop(WWW_ROOT . 'images/brochure_' . $this->request->data['ShopBrochureProduct']['shop_brochure_id'], $image);
			$this->request->data['ShopBrochureProduct']['coords'] = json_encode($this->request->data['ShopBrochureProduct']['coords']);
			$this->request->data['ShopBrochureProduct']['image'] = $image['new_name'];
			$this->ShopBrochureProduct->create();
			if ($this->ShopBrochureProduct->save($this->request->data)) {
				$this->autoRender = false;
				die(json_encode(array('result' => 1)));
			} else {
				die(json_encode(array('result' => 0)));
			}
		} else {
			$products = $this->Product->find('list', array('fields' => array('id', 'name')));
			$this->set('products', $products);
			$this->layout= 'ajax';
			$this->render('products');
		}
	}

	private function crop($route, $image) {
		$this->autoRender = false;
        App::uses('WideImage', 'Lib/wideimage');
        $new_image = WideImage::load($route . '/original/' .$image['name']);
        $new_image
        ->crop(round($image['x']), round($image['y']), round($image['w']), round($image['h']))
        ->resize(100, 100)
        ->saveToFile($route . '/products/' .$image['new_name']);
        $this->padding($route, $image);
    }

    private function padding($route, $image) {
    	$info 			= getimagesize($route . '/products/' .$image['new_name']); 
    	$image['w'] 	= $info[0];
    	$image['h'] 	= $info[1];
        $height         = ($image['w'] / 100) * 100;
        $width          = ($image['h'] / 100) * 100;
        App::uses('WideImage', 'Lib/wideimage');
        $new_image = WideImage::load($route . '/products/' .$image['new_name']);
        $color          = $new_image->allocateColor(255, 255, 255);
        if($height > $image['h']) {
            $diferencia = $height - $image['h'];
            $new_image->resizeCanvas('100%', '100%+'.$diferencia, 0, $diferencia/2, $color)
            ->saveToFile($route . '/products/' .$image['new_name']);
        } else {
            $diferencia = $width  - $image['w'];
            $new_image->resizeCanvas('100%+'.$diferencia, '100%', $diferencia/2, 0, $color)
            ->saveToFile($route . '/products/' .$image['new_name']);
        }
    }

	public function read_product($id = null) {
		$data = array();
		$this->autoRender = false;
        if($this->request->is('ajax') AND $id) {
        	$this->Product->id = $id;
        	if ($this->Product->exists()) {
        		$data = $this->Product->findById($id);
        	}
        }
        die(json_encode($data));
	}

	public function read_products($id = null) {
		$data = array();
		$this->autoRender = false;
        if($this->request->is('ajax') AND $id) {
        	$products = $this->ShopBrochureProduct->find('all', array('conditions' => array('shop_brochure_image_id' => $id)));
        	foreach ($products as $k => $v) {
        		$products[$k]['ShopBrochureProduct']['coords'] = json_decode($v['ShopBrochureProduct']['coords']);
        	}
        	$data['products'] = $products;
        }
        die(json_encode($data));
	}

	public function update_product($id = null) {
		$this->autoRender = false;
		if ($this->request->is('ajax') AND $this->request->is('post')) {
			$this->ShopBrochureProduct->id = $id;
			if ($this->ShopBrochureProduct->exists()) {
				if ($this->ShopBrochureProduct->save($this->request->data)) {
					die(json_encode(array('result' => 1)));
				} else {
					die(json_encode(array('result' => 0)));
				}
			}
		} else {
			$this->request->data = $this->ShopBrochureProduct->read(null, $id);
			$products = $this->Product->find('list', array('fields' => array('id', 'name')));
			$this->set('products', $products);
			$this->layout= 'ajax';
			$this->render('products');
		}
	}

	public function delete_product($id = null) {
		$data['result'] = null;
		$data['message'] = null;
		$this->autoRender = false;
        if($this->request->is('ajax') AND $id) {
        	$this->ShopBrochureProduct->id = $id;
			if (!$this->ShopBrochureProduct->exists()) {
				$data['message'] = 'Regitro Invalido';
			} else {
				$ShopBrochureProduct = $this->ShopBrochureProduct->findById($id)['ShopBrochureProduct'];
				@unlink(WWW_ROOT . 'images/brochure_' . $ShopBrochureProduct['shop_brochure_id'] . '/products/' . $ShopBrochureProduct['image']);
				if ($this->ShopBrochureProduct->delete()) {
					$data['result'] = 1;
				}
			}
        }
		die(json_encode($data));
	}
	
}