<?php
class ShopBrochure extends AppModel {

	public $hasMany = array(
		'ShopBrochureImage' => array(
			'dependent'=> true
			),
		'ShopBrochureProduct' => array(
			),
		);

	public function beforeSave($data = array()) {
		if (array_key_exists('release_date', $this->data[$this->alias])) {
			$release_date = explode('/', $this->data[$this->alias]['release_date']);
			$release_date = $release_date[1].'/'.$release_date[0].'/'.$release_date[2];
        	$this->data[$this->alias]['release_date'] = strtotime($release_date);
		}
		if(array_key_exists('expiration_date', $this->data[$this->alias])) {
			$expiration_date = explode('/', $this->data[$this->alias]['expiration_date']);
			$expiration_date = $expiration_date[1].'/'.$expiration_date[0].'/'.$expiration_date[2];
	        $this->data[$this->alias]['expiration_date'] = strtotime($expiration_date);
		}
	    return true;
	}

	public function afterFind($data = array()) {
		foreach ($data as $k => $v) {
			if (array_key_exists('release_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['release_date'] = date('d/m/Y', $data[$k][$this->alias]['release_date']);
			}
			if (array_key_exists('expiration_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['expiration_date'] = date('d/m/Y', $data[$k][$this->alias]['expiration_date']);
			}
		}
		return $data;
	}

}