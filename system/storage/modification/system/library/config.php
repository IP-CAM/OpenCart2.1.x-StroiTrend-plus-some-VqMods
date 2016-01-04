<?php
class Config {
	private $data = array();

	public function get($key) {

				/* = */	
				$seo_store_trigger = array('config_name', 'config_title', 'config_meta_description', 'config_meta_keyword');
				if (in_array($key, $seo_store_trigger)) {
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';
				$this->ssb_data = ssb_data::getInstance();
				$tools = $this->ssb_data->getSetting('tools');
				if($tools  AND isset($tools['seo_store'])){
				$seo_store = $tools['seo_store'];
				if($seo_store['status']){
				$result = $this->ssb_data->getSeoStore($key);
				if($result){
				return $result;
				}
				}
				}
				}
				/* = */
				
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	public function has($key) {
		return isset($this->data[$key]);
	}

	public function load($filename) {
		$file = DIR_CONFIG . $filename . '.php';

		if (file_exists($file)) {
			$_ = array();

			require(modification($file));

			$this->data = array_merge($this->data, $_);
		} else {
			trigger_error('Error: Could not load config ' . $filename . '!');
			exit();
		}
	}
}