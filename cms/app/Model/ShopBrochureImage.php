<?php
class ShopBrochureImage extends AppModel {

	public $hasMany = array(
		'ShopBrochureProduct' => array(
			'dependent'=> true
			),
		);

}