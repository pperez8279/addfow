<?php
class DashboardsController extends AppController {

	public function beforeRender() {
		$this->set('Module', 'Dashboard');
	}

	public function index() {
		
	}
	
}