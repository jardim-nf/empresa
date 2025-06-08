<?php
session_start();
if(!isset($_SESSION['admin'])){header('Location: admin.php');exit;}
$configFile=__DIR__.'/data/config.json';
$config=json_decode(file_get_contents($configFile),true);
$config['title']=trim($_POST['title']??$config['title']);
$config['backgroundColor']=$_POST['background']??$config['backgroundColor'];
file_put_contents($configFile,json_encode($config,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
header('Location: admin.php');
