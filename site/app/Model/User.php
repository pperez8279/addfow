<?php
class User extends AppModel {

	public $hasMany = array(
		'UserResellerGroup' => array(
			'foreignKey' => 'reseller_user_id'
			),
		// 'UserCart' => array(
		// 	),
		);
	
}