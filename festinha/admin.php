<?php
session_start();
if(!isset($_SESSION['admin'])){
  if(isset($_POST['password']) && $_POST['password']==='admin123'){
    $_SESSION['admin']=true;
  }else{
    echo '<form method="POST" class="p-5"><h2>Login Admin</h2><input type="password" name="password" class="form-control mb-2" placeholder="Senha"><button class="btn btn-primary" type="submit">Entrar</button></form>';
    exit;
  }
}
$items=json_decode(file_get_contents(__DIR__.'/data/items.json'),true);
$records=json_decode(file_get_contents(__DIR__.'/data/records.json'),true);
$config=json_decode(file_get_contents(__DIR__.'/data/config.json'),true);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel Admin</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body class="p-4">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation"><button class="nav-link active" id="item-tab" data-bs-toggle="tab" data-bs-target="#item" type="button" role="tab">Adicionar Item</button></li>
  <li class="nav-item" role="presentation"><button class="nav-link" id="reg-tab" data-bs-toggle="tab" data-bs-target="#reg" type="button" role="tab">Registros</button></li>
  <li class="nav-item" role="presentation"><button class="nav-link" id="conf-tab" data-bs-toggle="tab" data-bs-target="#conf" type="button" role="tab">Config Interface</button></li>
</ul>
<div class="tab-content mt-3">
  <div class="tab-pane fade show active" id="item" role="tabpanel">
    <form action="admin_add_item.php" method="POST" class="mb-3">
      <div class="mb-2"><input type="text" name="name" class="form-control" placeholder="Item" required></div>
      <div class="mb-2"><input type="number" name="limit" class="form-control" placeholder="Limite" required></div>
      <div class="mb-2"><input type="color" name="color" value="#0d6efd" class="form-control form-control-color"></div>
      <button class="btn btn-success" type="submit">Adicionar</button>
    </form>
    <ul class="list-group">
    <?php foreach($items as $it): ?>
      <li class="list-group-item"><?php echo htmlspecialchars($it['name'])." - limite: {$it['limit']} - escolhido: {$it['chosen']}"; ?></li>
    <?php endforeach; ?>
    </ul>
  </div>
  <div class="tab-pane fade" id="reg" role="tabpanel">
    <table class="table"><thead><tr><th>Nome</th><th>Sobrenome</th><th>Item</th><th>Data</th></tr></thead><tbody>
    <?php foreach($records as $r): ?>
      <tr><td><?php echo htmlspecialchars($r['first']); ?></td><td><?php echo htmlspecialchars($r['last']); ?></td><td><?php echo htmlspecialchars($r['item']); ?></td><td><?php echo htmlspecialchars($r['date']); ?></td></tr>
    <?php endforeach; ?>
    </tbody></table>
  </div>
  <div class="tab-pane fade" id="conf" role="tabpanel">
    <form action="admin_config.php" method="POST">
      <div class="mb-2"><input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($config['title']); ?>" placeholder="Título"></div>
      <div class="mb-2"><input type="color" name="background" value="<?php echo htmlspecialchars($config['backgroundColor']); ?>" class="form-control form-control-color"></div>
      <button class="btn btn-primary" type="submit">Salvar</button>
    </form>
  </div>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
