<?php
class User extends AppModel {
	
	public $belongsTo = array(
		'UserType' => array(),
		);

	public $hasMany = array(
		'UserResellerGroup' => array(
			'foreignKey' => 'reseller_user_id'
			)
		);

}