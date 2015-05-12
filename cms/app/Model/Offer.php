<?php
class Offer extends AppModel {

	public $belongsTo = array(
		'OfferType' => array(
			),
		);

	public $hasMany = array(
		'OfferProductGroup' => array(
			'dependent'=> true,
			),
		);
}