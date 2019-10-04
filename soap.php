<?php

require 'vendor/autoload.php';

use TADPHP\TAD;
use TADPHP\TADFactory;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


$logger = new Logger('soap-service');
// Now add some handlers
$logger->pushHandler(new StreamHandler(__DIR__.'/logs/'.date( "Y-m-d").'.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

$tad = (new TADFactory((['ip'=> getenv('IP_MESIN_ABSEN'), 'com_key'=>0])))->get_instance();

echo 'starting read data in machine finger print ..'. getenv('IP_MESIN_ABSEN');
$logs = $tad->get_att_log(["pin"=>"105152121"]);
$data = $logs->to_json();
$conv = json_decode($data,true);
var_dump($conv);
