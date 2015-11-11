<?php
class ModelSettingArticles extends Model {	
	private function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "marketinsg_articles` (
		  `marketinsg_articles_id` int(11) NOT NULL AUTO_INCREMENT,
		  `text` text COLLATE utf8_bin NOT NULL,
		  `date_added` datetime NOT NULL,
		  PRIMARY KEY (`marketinsg_articles_id`)
		)");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "marketinsg_articles_log` (
		  `marketinsg_articles_log_id` int(11) NOT NULL AUTO_INCREMENT,
		  `date_checked` datetime NOT NULL,
		  `status` tinyint NOT NULL,
		  PRIMARY KEY (`marketinsg_articles_log_id`)
		)");
	}
	
	private function call() {
		$encoding = mb_detect_encoding($result);

		if($encoding == 'UTF-8') {
			$result = preg_replace('/[^(\x20-\x7F)]*/','', $result);    
		} 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketinsg_articles WHERE text ='" . $this->db->escape($result) . "'");

		if (!$query->num_rows) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "marketinsg_articles");
			$this->db->query("INSERT INTO " . DB_PREFIX . "marketinsg_articles SET text ='" . $this->db->escape($result) . "', date_added = NOW()");
		}
		
		$disabled = '[{"title":"<strong>You have been disabled from MarketInSG.com articles system<\/strong>"}]';
		
		if (addslashes($result) == addslashes($disabled)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "marketinsg_articles_log SET date_checked = NOW(), status = 0");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "marketinsg_articles_log SET date_checked = NOW(), status = 1");
		}
	}
	
	public function getArticles() {	
		$this->install();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketinsg_articles_log ORDER BY marketinsg_articles_log_id DESC LIMIT 0,1");
		
		if ($query->num_rows) {
			$last_checked = date('d M Y', strtotime($query->row['date_checked']));
			$today = date('d M Y');
			$status = $query->row['status'];
			
			if ($last_checked == $today) {
				// Don't call
			} else {
				if(!$status) {
					// Don't call
				} else {
					$this->call();
				}
			}
		} else {
			$this->call();
		}
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketinsg_articles");
		
		return $query->row;
	}
}