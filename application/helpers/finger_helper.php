<?php

require 'vendor/autoload.php';

use TADPHP\TAD;
use TADPHP\TADFactory;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

function cmd($cmd="get_att_log",$data=null,$range=[])
{
  $tad = (new TADFactory((['ip'=> "61.94.88.139", 'com_key'=>0])))->get_instance();
  if (count($range) > 0) {
    if ($data == null) {
      $logs = $tad->{$cmd}();
    }else {
      $logs = $tad->{$cmd}($data);
    }
    $logs = $logs->filter_by_date($range);
  }else {
    if ($data == null) {
      $logs = $tad->{$cmd}();
    }else {
      $logs = $tad->{$cmd}($data);
    }
  }
  $data = $logs->to_json();
  $conv = json_decode($data,true);
  return $conv;
}
