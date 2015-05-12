<?php
class BackendUsersController extends AppController {

	public function beforeRender() {
		$this->set('Module', 'Usuarios CMS');
	}
	
	public function index() {
		$this->BackendUser->recursive = 0;
		$this->set('rows', $this->paginate());
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->BackendUser->create();
			if ($this->BackendUser->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		}
	}

	public function update($id = null) 
	{
		$this->BackendUser->id = $id;
		if (!$this->BackendUser->exists()) {
			$this->Session->setFlash('Registro Invalido', 'flash');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BackendUser->save($this->request->data)) {
				$this->Session->setFlash('Registro guardado', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
		} else {
			$this->request->data = $this->BackendUser->read(null, $id);
			unset($this->request->data['BackendUser']['password']);
		}
	}

	public function password($id = null) 
	{
		$this->BackendUser->id = $id;
		if (!$this->BackendUser->exists()) {
			throw new NotFoundException('Registro Invalido');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$row = $this->BackendUser->read(null, $id);
			if (Security::hash($this->request->data['BackendUser']['old_password'], 'sha1', true) == $row['BackendUser']['password']) {
				if ($this->BackendUser->save($this->request->data)) {
					$this->Session->setFlash('Registro guardado', 'flash');
					return $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash('El registro no puede guardarse. Por favor, vuelva a intentarlo.', 'flash');
			} else {
				$this->Session->setFlash('Contraseña Actual Invalida. Por favor, vuelva a intentarlo.', 'flash');
			}
		} else {
			$this->request->data = $this->BackendUser->read(null, $id);
			unset($this->request->data['BackendUser']['password']);
		}
	}

	public function delete($id = null) 
	{
		$this->BackendUser->id = $id;
		if (!$this->BackendUser->exists()) {
			throw new NotFoundException('Registro Invalido', 'flash');
		}
		if ($this->BackendUser->delete()) {
			$this->Session->setFlash('Registro Eliminado', 'flash');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Regitro no Eliminado', 'flash');
		return $this->redirect(array('action' => 'index'));
	}

	public function login() {
		$this->layout = 'login';
		if(AuthComponent::user()) {
			$this->redirect('/dashboards');
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash('Nombre de usuario o contraseña no válidos, vuelva a intentarlo', 'flash');
		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
}