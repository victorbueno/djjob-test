<?php
include_once("facebook/facebook.php");

$facebook = new Facebook(array(
			'appId'  => "1467516106805128",
			'secret' => "cc7930046fcab2b3139e7b48ad739225",
			));

include_once("Calendar.php");
date_default_timezone_set("America/Cuiaba");
include_once("DJJob.php");


$options = ['driver'=> 'mysql','host'=> '127.0.0.1','dbname'=> 'djjob','user'=> 'root','password'=> ''];
DJJob::configure($options);

$calendar = new Calendar($facebook);
$calendar->sendLater();

$worker = new DJWorker($options);
$worker->start();

?>