<?php
class UserResellerGroup extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'foreignKey' => 'user_id'
			),
		);

}