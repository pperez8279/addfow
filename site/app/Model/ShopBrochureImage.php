<?php
class ShopBrochureImage extends AppModel {

	public function afterFind($data = array(), $options = array()) {
		foreach ($data as $k => $v) {
			if (array_key_exists('coord', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['coord'] = json_decode($data[$k][$this->alias]['release_date']);
			}
			if (array_key_exists('name', $data[$k][$this->alias]) AND $data[$k][$this->alias]['order'] == 0) {
				$data[$k][$this->alias]['name'] = str_replace('site', 'cms', Router::url('/images/brochure_' . $data[$k][$this->alias]['shop_brochure_id'] . '/small/' . $data[$k][$this->alias]['name'], true));
			}
		}
		return $data;
	}

}