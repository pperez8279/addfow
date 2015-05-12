<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class BackendUser extends AppModel {

	public $validate = array(
		'email' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A email is required'
				)
			),
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
				)
			)
		);

	public function beforeSave($options = array()) {
	    if(!empty($this->data['BackendUser']['password'])) {
	        $this->data['BackendUser']['password'] = AuthComponent::password($this->data['BackendUser']['password']);
	    } else {
	        unset($this->data['BackendUser']['password']);
	    }
	    return true;
	}

}