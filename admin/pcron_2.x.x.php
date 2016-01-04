<?php
#!/usr/local/bin/php -q
// Version
define('VERSION', '2.0.0');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

//VirtualQMOD
require_once('../vqmod/vqmod.php');

$testClass     = new ReflectionClass('VQMod');
if($testClass->isAbstract()){
	VQMod::bootup();
	require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));	
}else{
	$vqmod = new VQMod();
	require_once($vqmod->modCheck(DIR_SYSTEM . 'startup.php'));	
}


// Registry
$registry = new Registry();

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0'");

foreach ($query->rows as $setting) {
	if (!$setting['serialized']) {
		$config->set($setting['key'], $setting['value']);
	} else {
		$config->set($setting['key'], unserialize($setting['value']));
	}
}

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Url
$url = new Url(HTTP_SERVER, $config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);
$registry->set('url', $url);

// Log
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

if (php_sapi_name() != 'cli') {
    $log->write("ERROR - Paladin Cron: by browser access denied.");
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . ' 400 ' . 'Bad Request');
    exit;
}


$log->write("CRON START");
// Request
$request = new Request();
$registry->set('request', $request);

// Cache
$cache = new Cache('file');
$registry->set('cache', $cache);

// Session
$session = new Session();
$registry->set('session', $session);

// Language
$languages = array();

$query = $db->query("SELECT * FROM `" . DB_PREFIX . "language`");

foreach ($query->rows as $result) {
	$languages[$result['code']] = $result;
}

$config->set('config_language_id', $languages[$config->get('config_admin_language')]['language_id']);

// Language
$language = new Language($languages[$config->get('config_admin_language')]['directory']);
$language->load('default');
$registry->set('language', $language);

// Document
$registry->set('document', new Document());

// Currency
$registry->set('currency', new Currency($registry));


// Front Controller
$controller = new Front($registry);

// Router
$action = new Action('module/superseobox/doTask');
$controller->dispatch($action, new Action('error/not_found'));