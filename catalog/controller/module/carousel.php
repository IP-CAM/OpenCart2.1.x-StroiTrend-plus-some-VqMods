<?php
class ControllerModuleCarousel extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
     $this->language->load('module/articles');
		$this->load->model('extension/articles');
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

	

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

        
          
        $data['banners'] = array();
        $filter_data = array(
			'page' => 1,
			'limit' => 10,
			'start' => 0,
		);
        $all_articles = $this->model_extension_articles->getAllArticles($filter_data);
        foreach ($all_articles as $articles) {
			$data['banners'][] = array (
				'title' 		=> html_entity_decode($articles['title'], ENT_QUOTES),
               
                'preview'			=> $this->model_tool_image->resize($articles['image'], 300, 98),
                'description' 	=> (mb_strlen(strip_tags(html_entity_decode($articles['short_description'], ENT_QUOTES))) > 120 ?        mb_substr(strip_tags(html_entity_decode($articles['short_description'], ENT_QUOTES)), 0, 120) . '...' : strip_tags(html_entity_decode($articles['short_description'], ENT_QUOTES))),
				'link' 			=> $this->url->link('information/articles/articles', 'articles_id=' . $articles['articles_id']),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($articles['date_added']))
			);
		}
        
        
        
        
        
        /*
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}
        */

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/carousel.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/carousel.tpl', $data);
		} else {
			return $this->load->view('default/template/module/carousel.tpl', $data);
		}
	}
}