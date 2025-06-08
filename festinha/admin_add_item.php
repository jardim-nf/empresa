<?php
session_start();
if(!isset($_SESSION['admin'])){header('Location: admin.php');exit;}
$name=trim($_POST['name']??'');
$limit=intval($_POST['limit']??0);
$color=$_POST['color']??'#0d6efd';
$itemsFile=__DIR__.'/data/items.json';
$items=json_decode(file_get_contents($itemsFile),true);
$id=max(array_column($items,'id'))+1;
$items[]=['id'=>$id,'name'=>$name,'limit'=>$limit,'chosen'=>0,'color'=>$color];
file_put_contents($itemsFile,json_encode($items,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
header('Location: admin.php');
