<?php
class ControllerCommonLanguage extends Controller {

					/* = */
					private function addLangSuffix($l_code){

					if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$domen = 'https://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\');
					}else{
					$domen = 'http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\');
					}

					$result = $domen . '/change-' . $l_code;
					return $result;
					}
					/* = */
				
	public function index() {
		$this->load->language('common/language');

		$data['text_language'] = $this->language->get('text_language');

		$data['action'] = $this->url->link('common/language/language', '', $this->request->server['HTTPS']);

		$data['code'] = $this->session->data['language'];

		$this->load->model('localisation/language');

		$data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['languages'][] = array(
					'name'  => $result['name'],
					'code'  => $result['code'],
					'image' => $result['image']
				);
			}
		}

		if (!isset($this->request->get['route'])) {
			$data['redirect'] = $this->url->link('common/home');
		} else {
			$url_data = $this->request->get;

			unset($url_data['_route_']);

			$route = $url_data['route'];

			unset($url_data['route']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['redirect'] = $this->url->link($route, $url, $this->request->server['HTTPS']);
		}


					/* = */
					require_once DIR_CONFIG .'ssb_library/ssb_data.php';
					$this->ssb_data = ssb_data::getInstance();
					$tools = $this->ssb_data->getSetting('tools');
					if($tools['lang_dir_link']['status'] AND $this->ssb_data->getEntityStatus('urls') AND $tools['lang_dir_link']['data']['prefix']){
					$_SESSION['ssb_lang_prefix'] = true;
					$l_code_session = $this->session->data['language'];

					if($tools['lang_dir_link']['data']['mode'] == 'natural'){

					$_SESSION['lang_dir_link_mode'] = 'natural';
					foreach($data['languages'] as &$language){
					$this->session->data['language'] = $language['code'];
					if (!isset($this->request->get['route'])) {
					$language['href'] = $this->url->link('common/home');
					}else{
					$language['href'] = $this->url->link($route, $url, $this->request->server['HTTPS']);
					}
					}
					}elseif($tools['lang_dir_link']['data']['mode'] == 'special'){

					$_SESSION['lang_dir_link_mode'] = 'special';
					$_SESSION['last_request'] = $data['redirect'];
					foreach($data['languages'] as &$language){
					$this->session->data['language'] = $language['code'];
					if (!isset($this->request->get['route'])) {
					$_SESSION['last_request_' . $language['code']] = $this->url->link('common/home');
					} else {
					$_SESSION['last_request_' . $language['code']] = $this->url->link($route, $url, $this->request->server['HTTPS']);
					}
					$language['href'] = $this->addLangSuffix($language['code']);
					}
					}else{
					unset($_SESSION['lang_dir_link_mode']);
					}

					$this->session->data['language'] = $l_code_session;
					$this->template = 'default/template/module/ssb_language.tpl';
					}else{
					unset ($_SESSION['ssb_lang_prefix']); 
					unset($_SESSION['lang_dir_link_mode']);
					}
					/* = */
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/language.tpl')) {

					/* = */	
					if($tools['lang_dir_link']['status'] AND $this->ssb_data->getEntityStatus('urls') AND $tools['lang_dir_link']['data']['prefix']){
					return $this->load->view('default/template/module/ssb_language.tpl', $data);
					}
					/* = */
				
			return $this->load->view($this->config->get('config_template') . '/template/common/language.tpl', $data);
		} else {

					/* = */	
					if($tools['lang_dir_link']['status'] AND $this->ssb_data->getEntityStatus('urls') AND $tools['lang_dir_link']['data']['prefix']){
					return $this->load->view('default/template/module/ssb_language.tpl', $data);
					}
					/* = */
				
			return $this->load->view('default/template/common/language.tpl', $data);
		}
	}

	public function language() {
		if (isset($this->request->post['code'])) {
			$this->session->data['language'] = $this->request->post['code'];
		}


					/* = */
					if(strpos($this->request->post['redirect'], 'index.php?') === false){
					if(!isset($_SESSION['last_request']) AND isset($_SESSION['ssb_lang_prefix'])){
					require_once DIR_CONFIG .'ssb_library/ssb_helper.php';
					$ssb_helper = ssb_helper::getInstance();
					$url = isset($this->request->post['redirect']) ? $this->request->post['redirect'] : $this->url->link('common/home');
					$url = $ssb_helper->setLangForUrl($url, $this->session->data['language']);

					$this->response->redirect($url);
					}else{
					unset($_SESSION['last_request']);
					}
					}
					/* = */
				
		if (isset($this->request->post['redirect'])) {
			$this->response->redirect($this->request->post['redirect']);
		} else {
			$this->response->redirect($this->url->link('common/home'));
		}
	}
}