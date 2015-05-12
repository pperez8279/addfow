<?php
class UserResellerGroup extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'foreignKey' => 'reseller_user_id'
			)
		);

	public $hasMany = array(
		'UserCart' => array(
			'foreignKey' => 'user_reseller_id'
			),
		);

}