<?php
class UsersController extends AppController {

	public $uses = array('User', 'UserType', 'UserResellerGroup');

	public $components = array('Paginator'); 

	public function beforeRender() {
		$this->set('Module', 'Usuarios');
	}
	
	public function index() {
		$UserTypes = $this->UserType->find('list', array('fields' => array('id', 'name')));
		array_unshift($UserTypes, 'Seleccióne..');
		$this->set('UserTypes', $UserTypes);	
		if ($this->request->is('post')) {
			$conditions 							= array();
			if ($this->data['Search']['User']['first_name']) {
				$conditions['User.first_name LIKE'] = '%'.$this->data['Search']['User']['first_name'].'%';
			}
			if ($this->data['Search']['User']['user_type_id'] > 0) {
				$conditions['User.user_type_id ='] = $this->data['Search']['User']['user_type_id'];
			}
			$this->Paginator->settings = array(
				'conditions'	=> $conditions
				);
			$this->set('rows', $this->paginate('User'));
		} else if ($this->request->is('get')) { 
			$this->set('rows', $this->paginate());
		}
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		}
		$this->set('UserTypes', $this->UserType->find('list', array('fields' => array('id', 'name'))));	
	}

	public function update($id = null) 
	{
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash('Registro Invalido', 'flash');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->request->data = $this->User->read(null, $id);
			$this->set('UserTypes', $this->UserType->find('list', array('fields' => array('id', 'name'))));	
			$this->set('rows', $this->paginate('UserResellerGroup', array('UserResellerGroup.reseller_user_id' => $this->User->id)));
		}
	}

	public function delete($id = null) 
	{
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}
	
}