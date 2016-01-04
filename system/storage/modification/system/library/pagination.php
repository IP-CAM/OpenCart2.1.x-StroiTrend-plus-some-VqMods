<?php
class Pagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 8;
	public $url = '';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';


				/* = */
				public function curPageURL() {
				$pageURL = 'http';
				if (isset($this->request->server['HTTPS']) AND (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {$pageURL .= "s";}
				$pageURL .= "://";
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				return $pageURL;
				} 
				/* = */
				
	public function render() {
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}

		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);

		$this->url = str_replace('%7Bpage%7D', '{page}', $this->url);

		$output = '<ul class="pagination">';

				/* = */
				$url_info = isset($url_info) ? $url_info : parse_url(str_replace('&amp;', '&', $this->curPageURL()));
				if((isset($url_info['query']) AND strpos($url_info['query'], 'route=') === false) OR !isset($url_info['query'])){
				require_once DIR_CONFIG .'ssb_library/ssb_data.php';
				$ssb_data = ssb_data::getInstance();
				$tools = $ssb_data->getSetting('tools');

				if($tools){

				if($tools['seo_pagination']['status'] AND $ssb_data->getEntityStatus('urls')){

				$query = '';
				if(isset($url_info['query'])){
				$query = '?' . preg_replace("/&*page=[0-9]/i","", $url_info['query']);
				}

				$setting= $ssb_data->getSetting();
				$CPBI_urls_ext= $setting['entity']['urls']['CPBI_urls']['ext'];
				$STAN_urls_ext= $setting['entity']['urls']['STAN_urls']['ext'];

				$url_info['path'] = preg_replace("/\/page-[0-9]+". $STAN_urls_ext ."/i","", $url_info['path']);
				$path_original = $url_info['path'];
				if($setting['tools']['suffix_manager']['status'])
				$path_original .= $CPBI_urls_ext; 
				$url_info['path'] = preg_replace("/". $CPBI_urls_ext ."$/i","", $url_info['path']);

				$page_part = '/page-{page}' . $STAN_urls_ext;

				$seo_link = $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . rtrim($url_info['path'], '/') . $page_part . $query;

				$this->first_seo_link = $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . $path_original . $query;

				$_SESSION['seo_page_number'] = $page;

				$this->url = $seo_link;
				}

				if($tools['seo_pagination']['data']['pag_link_in_header']){
				if(!isset($query)){
				$query = '';
				if(isset($url_info['query'])){
				$query = '?' . preg_replace("/&*page=[0-9]/i","", $url_info['query']);
				}
				}

				if ($page > 1) {
				if($page == 2){
				if($tools['seo_pagination']['status'] AND $ssb_data->getEntityStatus('urls')){
				$_SESSION['seo_page_prev'] = $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . $url_info['path'] . $query;
				}else{
				$this->first_url = str_replace('&page={page}', '', $this->url);
				$this->first_url = str_replace('?page={page}', '', $this->first_url);
				$_SESSION['seo_page_prev'] = $this->first_url;
				}
				}else{
				$_SESSION['seo_page_prev'] = str_replace('{page}', $page - 1, $this->url);
				}
				}
				if ($page < $num_pages) {
				$_SESSION['seo_page_next'] = str_replace('{page}', $page + 1, $this->url);
				}
				}
				}
				}
				/* = */
				

		if ($page > 1) {
			
				/* = */	
				if(isset($this->first_seo_link)){
				if($page == 2){
				$theFirstLink = '<li><a href="' . $this->first_seo_link . '">' . $this->text_prev . '</a></li> ';
				}else{
				$theFirstLink = '<li><a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li> ';
				}
				$output .= ' <li><a href="' . $this->first_seo_link . '">' . $this->text_first . '</a></li>' . $theFirstLink;
				}else{
				if(!isset($this->first_url)){
				$this->first_url = str_replace('&page={page}', '', $this->url);
				$this->first_url = str_replace('?page={page}', '', $this->first_url);
				}
				if($page == 2){
				$theFirstLink = '<li><a href="' . $this->first_url . '">' . $this->text_prev . '</a></li>';
				}else{
				$theFirstLink = '<li><a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li>';
				}
				$output .= ' <li><a href="' . $this->first_url . '">' . $this->text_first . '</a></li>' . $theFirstLink;
				}
				/* = */
				
			
				/*empty*/
				
		}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= '<li class="active"><span>' . $i . '</span></li>';
				} else {
					
				/* = */	
				if($i == 1){
				if(isset($this->first_seo_link)){
				$output .= ' <li><a href="' . $this->first_seo_link . '">' . $i . '</a></li> ';
				}else{
				if(!isset($this->first_url)){
				$this->first_url = str_replace('&page={page}', '', $this->url);
				$this->first_url = str_replace('?page={page}', '', $this->first_url);
				}
				$output .= ' <li><a href="' . $this->first_url . '">' . $i . '</a></li> ';
				}
				}else{
				$output .= ' <li><a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a></li> ';
				}
				/* = */
				
				}
			}
		}

		if ($page < $num_pages) {
			$output .= '<li><a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a></li>';
			$output .= '<li><a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a></li>';
		}

		$output .= '</ul>';

		if ($num_pages > 1) {
			return $output;
		} else {
			return '';
		}
	}
}