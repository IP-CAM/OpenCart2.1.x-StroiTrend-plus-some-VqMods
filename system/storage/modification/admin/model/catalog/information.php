<?php
class ModelCatalogInformation extends Model {

				/* = */
				public function getDescripInfo($information_id) {			
				$seodata = array();						$sql = "SELECT language_id, seo_title, meta_keyword, meta_description, tag, meta_seo_data FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'";						$query = $this->db->query($sql);			
				if(count($query->rows)){
					$_SESSION['current_meta_seo_data'] = array();
				}else{
					unset($_SESSION['current_meta_seo_data']);
				}
				foreach ($query->rows as $result) {				$seodata[$result['language_id']] = array(					'seo_title' 		=> $result['seo_title'],					'meta_keyword' 		=> $result['meta_keyword'],					'meta_description'	=> $result['meta_description'],					'tag'				=> $result['tag']				);			
				$_SESSION['current_meta_seo_data'][$result['language_id']] = $result;
				} return $seodata;}					
				
				public function setDescripInfo($information_id, $data = array(), $oc_data = array()) {
				if(!count($data)){				$this->load->model('localisation/language');				$languages = $this->model_localisation_language->getLanguages();				$data = array();				foreach ($languages as $l_code => $l_val) {					$data[$l_val['language_id']] = array(						'seo_title' 		=> '',						'meta_keyword' 		=> '',						'meta_description'	=> '',						'tag'				=> ''						);				}			}			foreach($data as $language_id => $val){	
				
				$val['meta_description'] = $oc_data[$language_id]['meta_description'];
				$val['meta_keyword'] = $oc_data[$language_id]['meta_keyword'];
				$val['description'] = $oc_data[$language_id]['description'];
				
				$query = $this->db->query("SELECT information_id FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "' AND language_id = '". (int)$language_id ."';");								
				if(count($query->rows)){
				$meta_seo_data = $this->getSeoMetaData($val, $language_id);
				$meta_seo_data = "meta_seo_data = '" . $meta_seo_data . "'";
				
				$sql = "UPDATE " . DB_PREFIX . "information_description SET seo_title = '" . $this->db->escape($val['seo_title']) . "', meta_keyword = '" . $this->db->escape($val['meta_keyword']) . "', meta_description = '" . $this->db->escape($val['meta_description']) . "', tag = '" . $this->db->escape($val['tag']) . "', ". $meta_seo_data ."  WHERE information_id = '" . (int)$information_id . "' AND language_id = '". (int)$language_id ."'";				}else{					$sql = "INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', seo_title = '" . $this->db->escape($val['seo_title']) . "', meta_keyword = '" . $this->db->escape($val['meta_keyword']) . "', meta_description = '" . $this->db->escape($val['meta_description']) . "', tag = '" . $this->db->escape($val['tag']) . "'";				}				$this->db->query($sql);			}		
				unset($_SESSION['current_meta_seo_data']);
				}

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
				
	public function addInformation($data) {
		$this->event->trigger('pre.admin.information.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "'");

		$information_id = $this->db->getLastId();

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_layout SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "' , keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('information');

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){$this->model_catalog_information->setDescripInfo($information_id, $data['seodata'], $data['information_description']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('info', $information_id);} 
				/* = */
				

		$this->event->trigger('post.admin.information.add', $information_id);

		return $information_id;
	}

	public function editInformation($information_id, $data) {
		$this->event->trigger('pre.admin.information.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "' WHERE information_id = '" . (int)$information_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_layout SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias  WHERE query = 'information_id=" . (int)$information_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "' , keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('information');

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){$this->model_catalog_information->setDescripInfo($information_id, $data['seodata'], $data['information_description']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('info', $information_id);} 
				/* = */
				

		$this->event->trigger('post.admin.information.edit', $information_id);
	}

	public function deleteInformation($information_id) {
		$this->event->trigger('pre.admin.information.delete', $information_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "'");

		$this->cache->delete('information');

				/* = */	
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){$this->model_catalog_information->setDescripInfo($information_id, $data['seodata'], $data['information_description']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('info', $information_id);} 
				/* = */
				

		$this->event->trigger('post.admin.information.delete', $information_id);
	}

	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias  WHERE query = 'information_id=" . (int)$information_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "') AS keyword FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");

		return $query->row;
	}

	public function getInformations($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
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
		} else {
			$information_data = $this->cache->get('information.' . (int)$this->config->get('config_language_id'));

			if (!$information_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$information_data = $query->rows;

				$this->cache->set('information.' . (int)$this->config->get('config_language_id'), $information_data);
			}

			return $information_data;
		}
	}

	public function getInformationDescriptions($information_id) {
		$information_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $information_description_data;
	}

	public function getInformationStores($information_id) {
		$information_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_store_data[] = $result['store_id'];
		}

		return $information_store_data;
	}

	public function getInformationLayouts($information_id) {
		$information_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $information_layout_data;
	}

	public function getTotalInformations() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information");

		return $query->row['total'];
	}

	public function getTotalInformationsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}