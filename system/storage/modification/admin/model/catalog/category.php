<?php
class ModelCatalogCategory extends Model {

				/* = */
				public function getDescripCategory($category_id) {
				$seodata = array();$sql = "SELECT language_id, tag, seo_title, seo_h1, seo_h2, seo_h3, meta_description, meta_keyword, description, alt_image, title_image, meta_seo_data FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'";$query = $this->db->query($sql);
				if(count($query->rows)){
					$_SESSION['current_meta_seo_data'] = array();
				}else{
					unset($_SESSION['current_meta_seo_data']);
				}
				foreach ($query->rows as $result) {
					$seodata[$result['language_id']] = array('seo_title' => $result['seo_title'],'seo_h1' => $result['seo_h1'],'seo_h2' => $result['seo_h2'],'seo_h3' => $result['seo_h3'],'tag'=> $result['tag'], 'alt_image'=> $result['alt_image'], 'title_image'=> $result['title_image']);
					$_SESSION['current_meta_seo_data'][$result['language_id']] = $result;
				}return $seodata;
				}
				
				public function setDescripCategory($category_id, $data = array(), $oc_data = array()) {
				
				if(!count($data)){
					$this->load->model('localisation/language');$languages = $this->model_localisation_language->getLanguages();$data = array();
					foreach ($languages as $l_code => $l_val) {
						$data[$l_val['language_id']] = array('seo_title'=> '','seo_h1'=> '','seo_h2'=> '','seo_h3'=> '','tag'=> '');
					}
				}
				foreach($data as $language_id => $val){
				$val['meta_description'] = $oc_data[$language_id]['meta_description'];
				$val['meta_keyword'] = $oc_data[$language_id]['meta_keyword'];
				$val['description'] = $oc_data[$language_id]['description'];
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "' AND language_id = '". (int)$language_id ."';");
				if(count($query->rows)){
				$meta_seo_data = $this->getSeoMetaData($val, $language_id);
				$meta_seo_data = "meta_seo_data = '" . $meta_seo_data . "'";
				
				$sql = "UPDATE " . DB_PREFIX . "category_description SET tag = '" . $this->db->escape($val['tag']) . "', seo_title = '". $this->db->escape($val['seo_title']) ."', seo_h1 = '". $this->db->escape($val['seo_h1']) ."', seo_h2 = '". $this->db->escape($val['seo_h2']) ."', seo_h3 = '". $this->db->escape($val['seo_h3']) ."', alt_image = '". $this->db->escape($val['alt_image']) ."', title_image = '". $this->db->escape($val['title_image']) ."', ". $meta_seo_data ."  WHERE category_id = '" . (int)$category_id . "' AND language_id = '". (int)$language_id ."'";}else{$sql = "INSERT INTO " . DB_PREFIX . "category_description SET category_id = '". (int)$category_id ."', tag = '" . $this->db->escape($val['tag']) . "', seo_h1 = '" . $this->db->escape($val['seo_h1']) . "', seo_h2 = '" . $this->db->escape($val['seo_h2']) . "', seo_h3 = '" . $this->db->escape($val['seo_h3']) . "', seo_title = '". $this->db->escape($val['seo_title']) ."', alt_image = '". $this->db->escape($val['alt_image']) ."', title_image = '". $this->db->escape($val['title_image']) ."';";}$this->db->query($sql);}
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
				

	
			public function getCategories_MF($data) {
				if( version_compare( VERSION, '1.5.5', '>=' ) ) {
					$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

					if( ! empty( $data['filter_name'] ) ) {
						$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
					} 
				
					$sql .= " GROUP BY cp.category_id ORDER BY name";
				} else {
					$sql = "SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				
					if( ! empty( $data['filter_name'] ) ) {
						$sql .= " AND LOWER(cd.name) LIKE '" . $this->db->escape( function_exists( 'mb_strtolower' ) ? mb_strtolower( $data['filter_name'], 'utf-8' ) : $data['filter_name'] ) . "%'";
					}
				
					$sql .= " GROUP BY c.category_id ORDER BY name";
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
				
			
	public function addCategory($data) {
		$this->event->trigger('pre.admin.category.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		
		if ($data['keyword']) {
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

				/* = */
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){
				$this->model_catalog_category->setDescripCategory($category_id, $data['seodata'], $data['category_description']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('category', $category_id);}
				/* = */
				

		$this->event->trigger('post.admin.category.add', $category_id);

		return $category_id;
	}

	public function editCategory($category_id, $data) {
		$this->event->trigger('pre.admin.category.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		
				/* = */
				$this->db->query("ALTER TABLE " . DB_PREFIX . "url_alias CHANGE `language_id` `language_id` int(11) NOT NULL DEFAULT '". (int)$this->config->get('config_language_id') ."';");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
				$urls = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

				/* = */
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){
				$this->model_catalog_category->setDescripCategory($category_id, $data['seodata'], $data['category_description']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('category', $category_id);}
				/* = */
				

		$this->event->trigger('post.admin.category.edit', $category_id);
	}

	public function deleteCategory($category_id) {
		$this->event->trigger('pre.admin.category.delete', $category_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");

		$this->cache->delete('category');

				/* = */
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';$this->ssb_data = ssb_data::getInstance();$ssb_setting = $this->ssb_data->getSetting();if(isset($data['seodata']) AND is_array($data['seodata']) AND $ssb_setting){
				$this->model_catalog_category->setDescripCategory($category_id, $data['seodata'], $data['category_description']);include_once DIR_CONFIG .'ssb_library/ssb_autogen.php';$ssb_autogen = ssb_autogen::getInstance();$ssb_autogen->genAutoSeo('category', $category_id);}
				/* = */
				

		$this->event->trigger('post.admin.category.delete', $category_id);
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}
	}

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "') AS keyword FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $category_description_data;
	}

	public function getCategoryFilters($category_id) {
		$category_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	public function getCategoryStores($category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
