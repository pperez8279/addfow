<?php
class UserCartDetail extends AppModel {	

	public $actsAs = array('Containable');

	public $belongsTo = array(
		'ShopBrochureProduct' => array(
			'foreignKey' => 'product_id'
			)
		);
	
}