<?php
class Document {
	private $title;
	private $description;
	private $keywords;
	private $links = array();
	private $styles = array();
	private $scripts = array();

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}


					/* = */
					public function addCustomLink($href, $rel, $addAttr = array(), $type = false) {
						$linkAttr = array();
						foreach($addAttr as $attr){
							foreach($attr as $key => $val){
								$linkAttr[$key] = $val;
							}
						}
						
						$linkAttr['href'] = $href;
						$linkAttr['rel'] = $rel;
						if(isset($type)){
							$linkAttr['type'] = $type;
						}
						
						$this->links[md5($href)] = $linkAttr;			
					}
					/* = */
				
	public function getLinks() {
		return $this->links;
	}

	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function addScript($href, $postion = 'header') {
		$this->scripts[$postion][$href] = $href;
	}

	public function getScripts($postion = 'header') {
		if (isset($this->scripts[$postion])) {
			return $this->scripts[$postion];
		} else {
			return array();
		}
	}
}
