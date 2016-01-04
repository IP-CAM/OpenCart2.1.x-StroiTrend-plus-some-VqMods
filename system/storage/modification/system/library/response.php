<?php
class Response {
	private $headers = array();
	private $level = 0;
	private $output;

	public function addHeader($header) {
		$this->headers[] = $header;
	}

	public function redirect($url, $status = 302) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}

	public function setCompression($level) {
		$this->level = $level;
	}

	public function setOutput($output) {

					/* = */
					$page_type = isset($_SESSION["ssb_page_type"]) ? $_SESSION["ssb_page_type"] : false;
					$page_types = array('category', 'product', 'brand', 'home');
					if(strpos($output, "html") !== false AND $page_type AND in_array($page_type, $page_types)){
					require_once DIR_CONFIG .'ssb_library/catalog/tools/snipet.php';
					$snipet = snipet::getInstance();
					$output = $snipet->insertSnipet($output, $_SESSION["ssb_page_data"], $page_type);
					}
					/*unset($_SESSION["ssb_page_type"]);*/
					/* = */
				
		$this->output = $output;
	}

	public function getOutput() {
		return $this->output;
	}

	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

	public function output() {
		if ($this->output) {
			if ($this->level) {
				$output = $this->compress($this->output, $this->level);
			} else {
				$output = $this->output;
			}

			if (!headers_sent()) {
				foreach ($this->headers as $header) {
					header($header, true);
				}
			}

			echo $output;
		}
	}
}