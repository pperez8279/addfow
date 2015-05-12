<?php
class Campaign extends AppModel {

	public $hasMany = array(
		'CampaignShopBrochure' => array(
			'dependent'=> true
			),
		);

	public function beforeSave($data = array()) {
		if (array_key_exists('start_date', $this->data[$this->alias])) {
			$start_date = explode('/', $this->data[$this->alias]['start_date']);
			$start_date = $start_date[1].'/'.$start_date[0].'/'.$start_date[2];
        	$this->data[$this->alias]['start_date'] = strtotime($start_date);
		}
		if(array_key_exists('end_date', $this->data[$this->alias])) {
			$end_date = explode('/', $this->data[$this->alias]['end_date']);
			$end_date = $end_date[1].'/'.$end_date[0].'/'.$end_date[2];
	        $this->data[$this->alias]['end_date'] = strtotime($end_date);
		}
	    return true;
	}

	public function afterFind($data = array()) {
		foreach ($data as $k => $v) {
			if (array_key_exists('start_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['start_date'] = date('d/m/Y', $data[$k][$this->alias]['start_date']);
			}
			if (array_key_exists('end_date', $data[$k][$this->alias])) {
				$data[$k][$this->alias]['end_date'] = date('d/m/Y', $data[$k][$this->alias]['end_date']);
			}
		}
		return $data;
	}

}