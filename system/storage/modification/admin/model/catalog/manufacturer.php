<?php
class ModelCatalogManufacturer extends Model {

				/* = */
				public function getDescripManufacturer($manufacturer_id) {
				$seodata = array();$sql = "SELECT language_id, seo_title, seo_h1,seo_h2,seo_h3, meta_keyword, meta_description, description, tag, meta_seo_data FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'";$query = $this->db->query($sql);if(!count($query->rows)){return false;}
				if(count($query->rows)){
					$_SESSION['current_meta_seo_data'] = array();
				}else{
					unset($_SESSION['current_meta_seo_data']);
				}
				foreach ($query->rows as $result) {
				$seodata[$result['language_id']] = array('description'=> $result['description'],'seo_title' => $result['seo_title'],'seo_h1' => $result['seo_h1'],'seo_h2' => $result['seo_h2'],'seo_h3' => $result['seo_h3'],'meta_keyword' => $result['meta_keyword'],'meta_description'=> $result['meta_description'],'tag'=> $result['tag']);
				$_SESSION['current_meta_seo_data'][$result['language_id']] = $result;
				}return $seodata;}
				
				public function setDescripManufacturer($manufacturer_id, $data = array(), $onlyEmpty = false){
				$this->load->model('localisation/language');$languages = $this->model_localisation_language->getLanguages();if($onlyEmpty){$man_descrip = $this->getDescripManufacturer($manufacturer_id);if($man_descrip){foreach ($languages as $l_code => $l_val) {$description = isset($man_descrip[$l_val['language_id']]['description']) ? $man_descrip[$l_val['language_id']]['description'] : '';$seo_title = isset($man_descrip[$l_val['language_id']]['seo_title']) ? $man_descrip[$l_val['language_id']]['seo_title'] : '';
				
				$seo_h1 = isset($man_descrip[$l_val['language_id']]['seo_h1']) ? $man_descrip[$l_val['language_id']]['seo_h1'] : '';
				$seo_h2 = isset($man_descrip[$l_val['language_id']]['seo_h2']) ? $man_descrip[$l_val['language_id']]['seo_h2'] : '';
				$seo_h3 = isset($man_descrip[$l_val['language_id']]['seo_h3']) ? $man_descrip[$l_val['language_id']]['seo_h3'] : '';
				
				$meta_keyword = isset($man_descrip[$l_val['language_id']]['meta_keyword']) ? $man_descrip[$l_val['language_id']]['meta_keyword'] : '';$meta_description = isset($man_descrip[$l_val['language_id']]['meta_description']) ? $man_descrip[$l_val['language_id']]['meta_description'] : '';$tag = isset($man_descrip[$l_val['language_id']]['tag']) ? $man_descrip[$l_val['language_id']]['tag'] : '';}}}if(!count($data)){$data = array();foreach ($languages as $l_code => $l_val) {$data[$l_val['language_id']] = array('description'=> isset($description) ? $description : '','seo_title' => isset($seo_title) ? $seo_title : '',
				'seo_h1' => isset($seo_h1) ? $seo_h1 : '',
				'seo_h2' => isset($seo_h2) ? $seo_h2 : '',
				'seo_h3' => isset($seo_h3) ? $seo_h3 : '',
				'meta_keyword' => isset($meta_keyword) ? $meta_keyword : '','meta_description'=> isset($meta_description) ? $meta_description : '','tag'=> isset($tag) ? $tag : '');}}
				$this->delDescripManufacturer($manufacturer_id);
				foreach($data as $language_id => $val){
				
				$meta_seo_data = $this->getSeoMetaData($val, $language_id);
				$meta_seo_data = "meta_seo_data = '" . $meta_seo_data . "'";
				
				$sql = "INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "', seo_title = '" . $this->db->escape($val['seo_title']) . "', seo_h1 = '" . $this->db->escape($val['seo_h1']) . "', seo_h2 = '" . $this->db->escape($val['seo_h2']) . "', seo_h3 = '" . $this->db->escape($val['seo_h3']) . "', ". $meta_seo_data .", meta_keyword = '" . $this->db->escape($val['meta_keyword']) . "', meta_description = '" . $this->db->escape($val['meta_description']) . "', description = '" . $this->db->escape($val['description']) . "', tag = '" . $this->db->escape($val['tag']) . "'";$this->db->query($sql);}
				unset($_SESSION['current_meta_seo_data']);
				}
				
				public function delDescripManufacturer($manufacturer_id) {$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");}
				
				private function getSeoMetaData($new_data, $language_id){
					if(!isset($_SESSION['current_meta_seo_data'][$language_id])) return '';
					$meta_seo_data = json_decode($_SESSION['current_meta_seo_data'][$language_id]['meta_seo_data'], true);
					$old_data = $_SESSION['current_meta_seo_data'][$language_id];
					
					if($meta_seo_data && is_array($meta_seo_data)){
						foreach($old_data as $key => $val){
							if(isset($new_data[$key]) AND $this->db->escape($new_data[$key]) != $val AND isset($meta_seo_data[$key])){
								if($val !='' AND $meta_seo_data[$key] == 'ag' AND $new_data[$key] != ''){
									$meta_seo_data[$key] = 'et'; // edited
								}elseif($val !='' AND $meta_seo_data[$key] == 'et' AND $new_data[$key] != ''){
									/*empty*/
								}else{
									unset($meta_seo_data[$key]);
								}
							}elseif(isset($new_data[$key]) AND $this->db->escape($new_data[$key]) == '' AND isset($meta_seo_data[$key])){
								unset($meta_seo_data[$key]);
							}
						}
					}else{
						$meta_seo_data = '';
					}
					return !$meta_seo_data ? "" : $this->db->escape(json_encode($meta_seo_data));
				}
				/* = */
				
	public function addManufacturer($data) {
		$this->event->trigger('pre.admin.manufacturer.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$manufacturer_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('manufacturer');

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){$this->model_catalog_manufacturer->setDescripManufacturer($manufacturer_id, $data['seodata']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('brand', $manufacturer_id);} 
				/* = */
				

		$this->event->trigger('post.admin.manufacturer.add', $manufacturer_id);

		return $manufacturer_id;
	}

	public function editManufacturer($manufacturer_id, $data) {
		$this->event->trigger('pre.admin.manufacturer.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		 
				/* = */
				$this->db->query("ALTER TABLE " . DB_PREFIX . "url_alias CHANGE `language_id` `language_id` int(11) NOT NULL DEFAULT '". (int)$this->config->get('config_language_id') ."';");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id. "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
				$urls = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id. "'");
				$languages_duplicat = array();
				foreach($urls->rows as $url){
					if (in_array($url['language_id'], $languages_duplicat)) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE url_alias_id = " . $url['url_alias_id']);
					}else{
						$languages_duplicat[] = $url['language_id'];
					}
				}
				/* = */
				

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('manufacturer');

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){$this->model_catalog_manufacturer->setDescripManufacturer($manufacturer_id, $data['seodata']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('brand', $manufacturer_id);} 
				/* = */
				

		$this->event->trigger('post.admin.manufacturer.edit', $manufacturer_id);
	}

	public function deleteManufacturer($manufacturer_id) {

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if($ssb_setting){$this->delDescripManufacturer($manufacturer_id);}
				/* = */
				
		$this->event->trigger('pre.admin.manufacturer.delete', $manufacturer_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");

		$this->cache->delete('manufacturer');

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){$this->model_catalog_manufacturer->setDescripManufacturer($manufacturer_id, $data['seodata']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('brand', $manufacturer_id);} 
				/* = */
				

		$this->event->trigger('post.admin.manufacturer.delete', $manufacturer_id);
	}

	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "') AS keyword FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row;
	}

	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getManufacturerStores($manufacturer_id) {
		$manufacturer_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_store_data[] = $result['store_id'];
		}

		return $manufacturer_store_data;
	}

	public function getTotalManufacturers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer");

		return $query->row['total'];
	}
}
