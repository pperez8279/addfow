<?php
class Campaign extends AppModel {

	public $hasMany = 'CampaignShopBrochure';

	public function beforeSave($data = array(), $options = array()) {
		if (array_key_exists('start_date', $this->data[$this->alias])) {
			$this->data[$this->alias]['start_date'] = strtotime(implode('/', array_reverse(explode('/', $this->data[$this->alias]['start_date']))));
		}
		if(array_key_exists('end_date', $this->data[$this->alias])) {
	    	$this->data[$this->alias]['end_date'] = strtotime(implode('/', array_reverse(explode('/', $this->data[$this->alias]['end_date']))));
		}
	    return true;
	}

	public function afterFind($data = array(), $options = array()) {
		foreach ($data as $k => $v) {
			if (array_key_exists('start_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['start_date'] = date('m/Y', $data[$k][$this->alias]['start_date']);
			}
			if (array_key_exists('end_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['end_date'] = date('m/Y', $data[$k][$this->alias]['end_date']);
			}
		}
		return $data;
	}

}