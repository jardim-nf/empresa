<?php
session_start();
header('Content-Type: application/json');
$itemsFile=__DIR__.'/data/items.json';
$recordsFile=__DIR__.'/data/records.json';
$items=json_decode(file_get_contents($itemsFile),true);
$records=json_decode(file_get_contents($recordsFile),true);
$id=intval($_POST['item']??0);
$first=trim($_POST['first']??'');
$last=trim($_POST['last']??'');
foreach($items as &$item){
  if($item['id']===$id){
    if($item['chosen'] >= $item['limit']){
      echo json_encode(['success'=>false,'message'=>'Limite atingido']);
      exit;
    }
    $item['chosen']++;
    $available=$item['limit']-$item['chosen'];
    file_put_contents($itemsFile,json_encode($items,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    $records[]=['first'=>$first,'last'=>$last,'item'=>$item['name'],'date'=>date('Y-m-d H:i')];
    file_put_contents($recordsFile,json_encode($records,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    echo json_encode(['success'=>true,'available'=>$available]);
    exit;
  }
}
echo json_encode(['success'=>false,'message'=>'Item inválido']);
