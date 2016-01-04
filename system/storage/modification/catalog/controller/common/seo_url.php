<?php // ==========================================  seo_url.php v.200515 opencart-russia.ru ===============================
class ControllerCommonSeoUrl extends Controller {

						/* = 1 */
						private $seoController, $ssb_helper, $ssb_data, $ssb_setting;
						private $def_lang_code, $totalLanguages, $l_code_session, $l_id_session, $seo_pagination = false;
						function __construct(){ 
							global $registry;
							parent::__construct($registry);
							
							require_once(DIR_CONFIG .'ssb_library/ssb_seo_controller.php');
							$this->seoController = seoController::getInstance();	
							require_once DIR_CONFIG .'ssb_library/ssb_helper.php';
							$this->ssb_helper = ssb_helper::getInstance();
							require_once DIR_CONFIG .'ssb_library/ssb_data.php';
							$this->ssb_data = ssb_data::getInstance();
							
							$this->ssb_setting = $this->ssb_data->getSetting();
							list ($this->totalLanguages, $this->def_lang_code) = $this->seoController->getDefaultLanguageData();
							list ($this->l_code_session, $this->l_id_session) = $this->seoController->setLanguageData();
						}
						/* = */
						
	public function index() {

							/* = */
							if(!$this->ssb_setting['entity']['urls']['CPBI_urls']['controller']){
								if($this->ssb_data->getEntityStatus('urls')){
									if(isset($_SESSION['ssb_language_id']) AND $_SESSION['ssb_language_id'] != ''){
										$this->config->set('config_language_id', $_SESSION['ssb_language_id']);
									}
									global $vqmod;
									if(isset($vqmod)){
										require_once $vqmod->modCheck(DIR_CONFIG .'ssb_library/catalog/controller/common/ssb_seo_url.php');
									}else{
										require_once VQMod::modCheck(DIR_CONFIG .'ssb_library/catalog/controller/common/ssb_seo_url.php');
									}
									$ssb_seo_url = ssb_seo_url::getInstance(); return $ssb_seo_url->index();
							}	}
							/* = */
						
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		
		// Decode URL

						/* = 2 */
						$this->curPageURL = $this->seoController->curPageURL();	
						$setting = $this->ssb_setting;
						$tools = $setting['tools'];
						if(substr($this->curPageURL,-1) == '/' AND $tools['trailing_slash']['status'] == true) {
							$new_url = rtrim($this->curPageURL,"/");  
							$this->ssb_helper->redirect($new_url, 301); 
						}
						if(isset($this->request->get['route']) AND !isset($this->request->get['_route_'])){
							$this->seoController->alternetHref();
							$this->seoController->errorNotFound();
							return new Action($this->request->get['route']);
						}else if(isset($this->request->get['_route_']) AND trim($this->request->get['_route_'], '/') == $this->l_code_session){
							$this->seoController->alternetHref();
							return new Action('common/home');
						}
						$no_exist_one_of_url_part = false;
						/* = */
						
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

						/* = 3 */
						$parts_length = count($parts);
						$CPBI_urls_ext	= $setting['entity']['urls']['CPBI_urls']['ext'];
						$CPBI_urls_ext	= $CPBI_urls_ext == '' ? '##empty##' : $CPBI_urls_ext  ;
						$pagin_part = false;
						if($tools['seo_pagination']['status']){foreach($parts as $part){if(strpos($part, 'page-') !== false){$pagin_part	= true;}}}
						$arrayLangCode = array();
						if($this->totalLanguages > 1){$arrayLangCode = $this->ssb_helper->getArrayLangCode();}
						$i = 1;
						/* = */
						
			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}
			foreach ($parts as $part) {
				
						/* = 4 */
						$part = trim($part); if (empty($part)) continue;
						if (in_array($part, $arrayLangCode)){$i++; continue;}
						if(preg_match("/page-[0-9]/i", $part) === 1){
							if($tools['seo_pagination']['status']){$this->seo_pagination = (int)str_replace('page-', '', $part);}
							$this->request->get['page'] = $this->seo_pagination; continue;
						}
						if(strpos($part, 'change-') !== false){
							$chage_lang = explode('-', $part);
							if(isset($chage_lang[1]) AND in_array($chage_lang[1], $arrayLangCode)){
								$chage_lang_code = $chage_lang[1];
								if(isset($_SESSION['last_request_' . $chage_lang_code])){
									$this->request->post['redirect'] = $_SESSION['last_request_' . $chage_lang_code];
									$this->request->post['language_code'] = $chage_lang_code;
									return new Action('module/language');
								}else{continue;}
							}
						}
						$pre_last_part = $parts_length - 1;
						if($pagin_part && strpos($part, $CPBI_urls_ext) === false && $pre_last_part == $i){
							$keyword_condition = "(keyword = '" . $this->db->escape($part) . "' OR keyword = '" . $this->db->escape($part . $CPBI_urls_ext) . "')";
						}elseif(strpos($part, $CPBI_urls_ext) !== false && $parts_length == $i && $setting['tools']['suffix_manager']['status']){
							$keyword_condition = "(keyword = '" . $this->db->escape($part) . "' OR keyword = '" . $this->db->escape(str_replace($CPBI_urls_ext, '', $part)) . "')";
						}else{
							$keyword_condition = "keyword = '" . $this->db->escape($part) . "'";
						}
						$i++;
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE ". $keyword_condition);
						/* = */
						
				if ($query->num_rows) {

						/* = 5 repeat-1 */
						if($query->num_rows > 1){
							foreach($query->rows as $row){
								if(isset($row['language_id']) && $row['language_id'] == $this->l_id_session){
									$query->row['keyword'] 	= $row['keyword'];
									$query->row['query'] 		= $row['query'];
									break;
								}
							}	
						}
						/* = */
						
					$url = explode('=', $query->row['query']);

						/* = 5.5 */
						if (isset($url[0]) AND !isset($url[1])) { 
							$this->request->get['route'] = $url[0];
						}
						/* = */
						
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}
/////////////////
				if ($url[0] == 'articles_id') {
					$this->request->get['articles_id'] = $url[1];
				}	
					
	/////////////////				
					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id'  && $url[0] != 'articles_id') {
						$this->request->get['route'] = $query->row['query'];
					}
					
				} else {

						// 6
						$no_exist_one_of_url_part = true;
						
						
					$this->request->get['route'] = 'error/not_found';
					break;
				}
			}
			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}	elseif (isset($this->request->get['articles_id'])) {
					$this->request->get['route'] = 'information/articles/articles';
					}
			}

						/* =7 */
						$no_exist_one_of_url_part = isset($no_exist_one_of_url_part) ? $no_exist_one_of_url_part : false;
						$this->seoController->checkPathController($no_exist_one_of_url_part);
						if(isset($urlWasCange) AND $urlWasCange){$this->seoController->redirectPermanently();}
						$this->seoController->alternetHref();
						$this->seoController->errorNotFound();
						/* = */
						
			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
			
		  // Redirect 301	
		} elseif (isset($this->request->get['route']) && empty($this->request->post) && !isset($this->request->get['token']) && $this->config->get('config_seo_url')) {
			$arg = '';
			$cat_path = false;
			if ($this->request->get['route'] == 'product/product' && isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product_id=' . $this->request->get['product_id'];
			} elseif ($this->request->get['route'] == 'product/category' && isset($this->request->get['path'])) {
				$categorys_id = explode('_', $this->request->get['path']);
				$cat_path = '';
				foreach ($categorys_id as $category_id) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category_id . "'");	
					if ($query->num_rows && $query->row['keyword'] /**/ ) {
						$cat_path .= '/' . $query->row['keyword'];
					} else {
						$cat_path = false;
						break;
					}
				}
				$arg = trim($cat_path, '/');
			} elseif ($this->request->get['route'] == 'product/manufacturer/info' && isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'manufacturer_id=' . $this->request->get['manufacturer_id'];
			} elseif ($this->request->get['route'] == 'information/information' && isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information_id=' . $this->request->get['information_id'];
			} elseif (sizeof($this->request->get) > 1) {
				$args = '?' . str_replace("route=" . $this->request->get['route'].'&amp;', "", $this->request->server['QUERY_STRING']);
				$arg = str_replace('&amp;', '&', $args);
			} elseif ($this->request->get['route'] == 'common/home') {
				$arg = HTTP_SERVER;
			} 

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($this->request->get['route']) . "'");
			
			if ($query->num_rows) /**/ {
				$this->response->redirect($query->row['keyword'] . $arg, 301);
			} elseif ($cat_path) {
				$this->response->redirect($arg, 301);
			} 
		}
	}
	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

						/* = 8 */
						list ($this->l_code_session, $this->l_id_session) = $this->seoController->setLanguageData();
						/* = */
						
		$url = '';
		$data = array();
		parse_str($url_info['query'], $data);

						/* = 9 */
						$CPBI_urls_ext	= $this->ssb_setting['entity']['urls']['CPBI_urls']['ext'];
						list ($data, $this->path_mode) = $this->seoController->startPathManager($data);
						$page_part = false;
						/* = */
						
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'information/articles/articles' && $key == 'articles_id') || ($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {

						/* = 10 */
						if($data['route'] == 'product/product' && $key == 'manufacturer_id' && $this->path_mode != 'default'){
							unset ( $data[$key] );
							continue;
						}
						/* = */
						
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
					if ($query->num_rows && $query->row['keyword']) {

						/* = 5 repeat-2 */
						if($query->num_rows > 1){
							foreach($query->rows as $row){
								if(isset($row['language_id']) && $row['language_id'] == $this->l_id_session){
									$query->row['keyword'] 	= $row['keyword'];
									$query->row['query'] 		= $row['query'];
									break;
								}
							}	
						}
						if(isset($data)){
							if(strpos($query->row['query'], 'manufacturer_id') !== false && !isset($data['product_id'])){
								if($this->ssb_setting['tools']['suffix_manager']['status'] && strpos($link, 'page=') === false)$query->row['keyword'] .= $CPBI_urls_ext;
								if(!isset($data['product_id']))$page_part = true;
							}	
						}
						if(isset($found_category))$found_category = true;
						/* = */
						
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);

						/* = 13 repeat-2*/
						if(isset($found_category)){
							if($found_category && !isset($data['product_id']) && $this->ssb_setting['tools']['suffix_manager']['status'] && strpos($link, 'page=') === false)$url .= $CPBI_urls_ext;
							if(!isset($data['product_id']))$page_part = true;
							unset($found_category);
						}
						/* = */
						
					}

						/* = 11 */
						} elseif ($key == 'route' AND $value != 'product/product' AND $value != 'product/category') { 
							$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($value) . "'";
							$query = $this->db->query($sql);

							if ($query->num_rows) {
								foreach($query->rows as $row){
									if($row['language_id'] == (int)$this->l_id_session){
										$url .= '/' . $row['keyword'];
										break;
									}
								}
							}
						/* = */
						
				} elseif ($key == 'path') {
					$categories = explode('_', $value);

						/* = 12 */
						$found_category = false;
						/* = */
						
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
						if ($query->num_rows && $query->row['keyword']) {

						/* = 5 repeat-2 */
						if($query->num_rows > 1){
							foreach($query->rows as $row){
								if(isset($row['language_id']) && $row['language_id'] == $this->l_id_session){
									$query->row['keyword'] 	= $row['keyword'];
									$query->row['query'] 		= $row['query'];
									break;
								}
							}	
						}
						if(isset($data)){
							if(strpos($query->row['query'], 'manufacturer_id') !== false && !isset($data['product_id'])){
								if($this->ssb_setting['tools']['suffix_manager']['status'] && strpos($link, 'page=') === false)$query->row['keyword'] .= $CPBI_urls_ext;
								if(!isset($data['product_id']))$page_part = true;
							}	
						}
						if(isset($found_category))$found_category = true;
						/* = */
						
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';
							break;
						}
					}
					unset($data[$key]);

						/* = 13 repeat-2*/
						if(isset($found_category)){
							if($found_category && !isset($data['product_id']) && $this->ssb_setting['tools']['suffix_manager']['status'] && strpos($link, 'page=') === false)$url .= $CPBI_urls_ext;
							if(!isset($data['product_id']))$page_part = true;
							unset($found_category);
						}
						/* = */
						
				} else {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($data['route']) . "'");
					if ($query->num_rows) /**/ {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);

						/* = 13 repeat-2*/
						if(isset($found_category)){
							if($found_category && !isset($data['product_id']) && $this->ssb_setting['tools']['suffix_manager']['status'] && strpos($link, 'page=') === false)$url .= $CPBI_urls_ext;
							if(!isset($data['product_id']))$page_part = true;
							unset($found_category);
						}
						/* = */
						
					}
				}
			}
		}
		if ($url) {
			unset($data['route']);
			$query = '';
			if ($data) {
				foreach ($data as $key => $value) {

						/* = 14 */
						if($this->ssb_setting['tools']['seo_pagination']['status'] && $key == 'page'  && $value != '{page}')continue;
						/* = */
						
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
				}
				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}

						/* = 15 */
						if($this->totalLanguages > 1 AND $this->ssb_setting['tools']['lang_dir_link']['data']['prefix']){
							$host = $this->seoController->getHost($url_info);
							$path = $this->seoController->getPath($this->l_code_session, $host, $url_info);
						}else{
							$host = $url_info['scheme'] . '://' . $url_info['host'];
							$path = str_replace('/index.php', '', $url_info['path']);
						}
						if($page_part){
							list($page_part, $url_info) = $this->seoController->getPagePart($url_info);
						}else{
							$page_part = '';
						}
						$link = $host . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . $path . $url . $page_part .$query;
						return rtrim($link);
						/* = */
						
			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {

						/* = 16 */
						$link = rtrim(str_replace('index.php', '', $link));
						/* = */
						
			return $link;
		}
	}
}