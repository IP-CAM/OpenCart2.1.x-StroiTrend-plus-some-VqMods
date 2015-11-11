<?php
class ControllerInformationArticles extends Controller {
	public function index() {
		$this->language->load('information/articles');
		
		$this->load->model('extension/articles');
	 
		$this->document->setTitle($this->language->get('heading_title')); 
	 
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' 		=> $this->language->get('text_home'),
			'href' 		=> $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' 		=> $this->language->get('heading_title'),
			'href' 		=> $this->url->link('information/articles')
		);
		  
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}	

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}
		
		$filter_data = array(
			'page' 	=> $page,
			'limit' => 10,
			'start' => 10 * ($page - 1),
		);
		
		$total = $this->model_extension_articles->getTotalArticles();
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('information/articles', 'page={page}');
		
		$data['pagination'] = $pagination->render();
	 
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($total - 10)) ? $total : ((($page - 1) * 10) + 10), $total, ceil($total / 10));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_view'] = $this->language->get('text_view');
	 
		$all_articles = $this->model_extension_articles->getAllArticles($filter_data);
	 
		$data['all_articles'] = array();
		
		$this->load->model('tool/image');
	 
		foreach ($all_articles as $articles) {
			$data['all_articles'][] = array (
				'title' 		=> html_entity_decode($articles['title'], ENT_QUOTES),
				'image'			=> $this->model_tool_image->resize($articles['image'], 100, 100),
				'description' 	=> (strlen(strip_tags(html_entity_decode($articles['short_description'], ENT_QUOTES))) > 50 ? substr(strip_tags(html_entity_decode($articles['short_description'], ENT_QUOTES)), 0, 50) . '...' : strip_tags(html_entity_decode($articles['short_description'], ENT_QUOTES))),
				'view' 			=> $this->url->link('information/articles/articles', 'articles_id=' . $articles['articles_id']),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($articles['date_added']))
			);
		}
	 
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/articles_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/articles_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/articles_list.tpl', $data));
		}
	}
 
	public function articles() {
		$this->load->model('extension/articles');
	  
		$this->language->load('information/articles');
 
		if (isset($this->request->get['articles_id']) && !empty($this->request->get['articles_id'])) {
			$articles_id = $this->request->get['articles_id'];
		} else {
			$articles_id = 0;
		}
 
		$articles = $this->model_extension_articles->getArticles($articles_id);
 
		$data['breadcrumbs'] = array();
	  
		$data['breadcrumbs'][] = array(
			'text' 			=> $this->language->get('text_home'),
			'href' 			=> $this->url->link('common/home')
		);
	  
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/articles')
		);
 
		if ($articles) {
			$data['breadcrumbs'][] = array(
				'text' 		=> $articles['title'],
				'href' 		=> $this->url->link('information/articles/articles', 'articles_id=' . $articles_id)
			);
 
			$this->document->setTitle($articles['title']);
			
			$this->load->model('tool/image');
			
			$data['image'] = $this->model_tool_image->resize($articles['image'], 200, 200);
 
			$data['heading_title'] = html_entity_decode($articles['title'], ENT_QUOTES);
			$data['description'] = html_entity_decode($articles['description'], ENT_QUOTES);
	 
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/articles.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/articles.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/articles.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' 		=> $this->language->get('text_error'),
				'href' 		=> $this->url->link('information/articles', 'articles_id=' . $articles_id)
			);
	 
			$this->document->setTitle($this->language->get('text_error'));
	 
			$data['heading_title'] = $this->language->get('text_error');
			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');
	 
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
}