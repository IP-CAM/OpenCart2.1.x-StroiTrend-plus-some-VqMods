<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));
       
		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
      


					/* = */
					require_once DIR_CONFIG .'ssb_library/ssb_data.php';
					$this->ssb_data = ssb_data::getInstance();
					$tools = $this->ssb_data->getSetting('tools');
					if($tools){
					$canonical = $tools['canonical'];
					if($canonical['status']){
					$this->document->addLink($this->config->get('config_url'), 'canonical');
					}
					}

					$this->document->setKeywords($this->config->get('config_meta_keyword'));

					$_SESSION["ssb_page_data"] = $data;
					$_SESSION["ssb_page_type"] = 'home';
					/* = */
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}