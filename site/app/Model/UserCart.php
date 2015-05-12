<?php
class UserCart extends AppModel {

	public $hasMany = array('UserCartDetail');

	public $belongsTo = array('User');
	
}