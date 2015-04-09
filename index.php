<?php
define('THINK_PATH','./ThinkPHP/');
define('APP_NAME','App');
define('APP_PATH','./App/');
define('APP_DEBUG',true);
//define('SAE_RUNTIME',true);
define('ENGINE_NAME','sae');
require THINK_PATH.'ThinkPHP.php';
//phpinfo();
// $m = memcache_connect('localhost', 11211);
// $m->add('a', 'test');
// $ret = $m->get('a');
// echo $ret;

/*$client = new MongoClient("mongodb://127.0.0.1:27017");
$collection = $client->mydb->testData;

$result = $collection->findOne();
var_dump($result);*/
