<?php
class ShopBrochure extends AppModel {

	public $hasMany = array(
		'ShopBrochureImage' => array(
			'order' => array('order' => 'ASC')
			),
		'CampaignShopBrochure' => array( // Edit 25/03 => "Test"
			)
		);

	public function afterFind($data = array(), $options = array()) {
		foreach ($data as $k => $v) {
			if (array_key_exists('release_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['release_date'] = date('m/Y', $data[$k][$this->alias]['release_date']);
			}
			if (array_key_exists('expiration_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['expiration_date'] = date('d \d\e F \d\e Y', $data[$k][$this->alias]['expiration_date']);
			}
		}
		return $data;
	}

}