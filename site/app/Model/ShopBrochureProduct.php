<?php
class ShopBrochureProduct extends AppModel {

	public $actsAs = array('Containable');

	public $belongsTo = array(
		'Product' => array(
			'foreignKey' => 'product_id'
			),
		'ShopBrochure' => array(
			'foreignKey' => 'shop_brochure_id'
			)
		);

	public function afterFind($data = array(), $options = array()) {
		foreach ($data as $k => $v) {
			if (array_key_exists('image', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['image'] = str_replace('site', 'cms', Router::url('/images/brochure_' . $data[$k][$this->alias]['shop_brochure_id'] . '/products/' . $data[$k][$this->alias]['image'], true));
			}
		}
		return $data;
	}
}