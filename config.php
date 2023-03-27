<?php
require 'environment.php';

global $config;
global $config2;
global $db;
// global $stur;

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/contratos/");
	$config['dbname'] = 'gestaocontratos';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'M0nkey_615243';
} else {
	// define("BASE_URL", "http://gestaocontratos.monkeybranch.com.br/");
	define("BASE_URL", "http://67.205.175.48/contratos/");
	$config['dbname'] = 'gestaocontratos';
	// $config['host'] = 'gestaocontratos.monkeybranch.br:5506';
	$config['host'] = '67.205.175.48:5506';
	$config['dbuser'] = 'gestaocontratos';
	$config['dbpass'] = 'Gesta0_615243';
}


// $config2 = array();
// if(ENVIRONMENT == 'development') {
// 	$config2['dbname'] = 'PP';
// 	$config2['host'] = '104.197.230.204';
// 	$config2['port'] = '1433';
// 	$config2['dbuser'] = 'STUR';
// 	$config2['dbpass'] = 'stur';
// }

$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
$db->exec("SET NAMES 'utf8'");
$db->exec('SET character_set_connection=utf8');
$db->exec('SET character_set_client=utf8');
$db->exec('SET character_set_results=utf8');

// $stur = new PDO("dblib:dbname=".$config2['dbname'].";host=".$config2['host'], $config2['dbuser'], $config2['dbpass']);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $stur->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);