<?php
class CategoriesController extends AppController {

	public function beforeRender() {
		$this->set('Module', 'Categorías');
	} 
	
	public function index() {
		$this->set('rows', $this->read_records());
	}

	private function read_records($id_parent = 0, $first_round = 1) {
        $rows = $this->Category->find('all', array(
			'conditions' => array('parent_category_id' => $id_parent),
			'order' => array('order' => 'asc'),
        	)
        );
        $menu = '';
        $num_rows = count($rows);
        if ($num_rows > 0 OR $first_round == 1) {
            $menu .= '<ul id="' . $id_parent . '">';
        }
        foreach ($rows as $k => $v) {
            $menu .= '<li id="' . $v['Category']['id'] . '" >' . $v['Category']['name'] . '<div class="pull-right"><a href="javascript:;" class="btn btn-small dialog" data-url="categories/create" data-id="' . $v['Category']['id'] . '" rel="tooltip" data-original-title="Nueva Categoria Hija"><i class="fa fa-plus"></i></a> <a href="javascript:;" class="btn btn-small dialog" data-url="categories/update/' . $v['Category']['id'] . '" data-id="' . $v['Category']['id'] . '" rel="tooltip" data-original-title="Editar Categoría"><i class="fa fa-edit"></i></a> <a href="' . Router::url('/categories/delete/'.$v['Category']['id'], true) . '" class="btn btn-small delete" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-times"></i></a></div>';
            $menu .= $this->read_records($v['Category']['id'], FALSE) . '</li>';
        }
        if ($num_rows > 0) {
            $menu .= '</ul>';
        }
        return $menu;
    }

    public function update($id = null) {
		$this->Category->id = $id;
		if ($this->Category->exists()) {
			if ($this->request->is('post')) { 
				unset($this->request->data['Category']['parent_category_id']);
				if ($this->Category->save($this->request->data)) {
					$this->autoRender = false;
	            	die($this->read_records());
				}
			} else {
				$this->request->data = $this->Category->read(null, $id);
				$this->layout= 'ajax';
				$this->render('create');
			}
		}
	}

    public function create() {
		if ($this->request->data) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->autoRender = false;
				die($this->read_records());
			}
		} else {
			$this->layout= 'ajax';
		}
	}

	private function read_selectable($id_parent = 0, $first_round = 1) {
        $rows = $this->Category->find('all', array(
			'conditions' => array('parent_category_id' => $id_parent),
			'order' => array('order' => 'asc'),
        	)
        );
        $menu = '<div id="sortable" class="selectable">';
        $num_rows = count($rows);
        if ($num_rows > 0 OR $first_round == 1) {
            $menu .= '<ul id="' . $id_parent . '">';
        }
        foreach ($rows as $k => $v) {
            $menu .= '<li id="' . $v['Category']['id'] . '" ><a href="javascript:;">' . $v['Category']['name'].'</a>';
            $menu .= $this->read_selectable($v['Category']['id'], FALSE) . '</li>';
        }
        if ($num_rows > 0) {
            $menu .= '</ul></div>';
        }
        return $menu;
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

	public function read() {
		$this->autoRender = false;
		$this->layout= 'ajax';
		die($this->read_selectable());
	}

	public function read_parents($id = null) {
		$this->autoRender = false;
		$this->layout= 'ajax';
		$categories = $this->read_parent($id);
		$categories = explode('/', $categories);
		$categories = array_reverse($categories);
		foreach ($categories as $k => $v) {
			if (!$v) {
				unset($categories[$k]);
			}
		}
		$categories = implode('/', $categories);
		die($categories);
	}

    public function update_order() {
    	$order = explode(',', $this->request->data['order']);
    	unset($this->request->data['order']);
    	$this->Category->id = $this->request->data['id'];
		if (!$this->Category->exists()) {
			$data['result'] = 0;
		} else if ($this->request->is('ajax')) {
			$this->autoRender = false;
    		$this->Category->save($this->request->data);
    		foreach ($order as $k => $v) {
    			$this->Category->id = $v;
    			if ($this->Category->exists()) {
    				$this->Category->save(array('id' => $v, 'order' => $k));
    			}
    		}
		}
    }

    public function delete($id = null) 
	{
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		}
		if ($this->Category->delete()) {
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}

}