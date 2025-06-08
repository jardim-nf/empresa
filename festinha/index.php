<?php
session_start();
$config = json_decode(file_get_contents(__DIR__.'/data/config.json'), true);
$items = json_decode(file_get_contents(__DIR__.'/data/items.json'), true);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($config['title']); ?></title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<style>
body { background: <?php echo $config['backgroundColor']; ?>; }
.admin-btn { position: fixed; top: 10px; right: 10px; border: none; background: none; font-size: 24px; cursor: pointer; }
#overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; }
#overlay .modal { background:#fff; padding:20px; border-radius:8px; animation: rise 0.3s ease-out; }
@keyframes rise { from { transform: translateY(20px); opacity:0; } to { transform: translateY(0); opacity:1; } }
.item-btn:disabled { background:#ccc !important; border-color:#ccc !important; }
</style>
</head>
<body>
<button class="admin-btn" id="adminButton">⚒️</button>
<div class="container mt-4">
<h1 class="mb-4 text-center"><?php echo htmlspecialchars($config['title']); ?></h1>
<div class="row">
<?php foreach ($items as $item): $available = $item['limit'] - $item['chosen']; ?>
<div class="col-md-4 mb-3">
<div class="card p-3">
<h5><?php echo htmlspecialchars($item['name']); ?></h5>
<button class="btn item-btn" style="background: <?php echo $item['color']; ?>; color:#fff" data-id="<?php echo $item['id']; ?>" <?php echo $available>0?'':'disabled'; ?>>Selecionar (<?php echo $available; ?>)</button>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<div id="overlay" class="d-flex">
<div class="modal">
<form id="selectForm">
<div class="mb-3"><input type="text" class="form-control" name="first" placeholder="Nome" required></div>
<div class="mb-3"><input type="text" class="form-control" name="last" placeholder="Sobrenome" required></div>
<input type="hidden" name="item" id="itemInput">
<button class="btn btn-primary" type="submit">Confirmar</button>
<button type="button" class="btn btn-secondary" id="cancel">Cancelar</button>
</form>
</div>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
const adminButton=document.getElementById('adminButton');
adminButton.addEventListener('click',()=>{
  const pass=prompt('Senha de admin:');
  if(pass==='admin123'){
    window.location='admin.php';
  }else if(pass){ alert('Senha incorreta'); }
});
const overlay=document.getElementById('overlay');
const selectForm=document.getElementById('selectForm');
const itemInput=document.getElementById('itemInput');
const cancel=document.getElementById('cancel');

document.querySelectorAll('.item-btn').forEach(btn=>{
  btn.addEventListener('click',()=>{
    itemInput.value=btn.dataset.id;
    overlay.style.display='flex';
  });
});
cancel.addEventListener('click',()=>{overlay.style.display='none';});
selectForm.addEventListener('submit',e=>{
  e.preventDefault();
  const data=new FormData(selectForm);
  fetch('select_item.php',{method:'POST',body:data}).then(r=>r.json()).then(resp=>{
    if(resp.success){
      const btn=document.querySelector(`.item-btn[data-id='${data.get('item')}']`);
      btn.textContent='Selecionar ('+resp.available+')';
      if(!resp.available){ btn.disabled=true; }
      overlay.style.display='none';
      selectForm.reset();
    }else{
      alert(resp.message);
    }
  });
});
</script>
</body>
</html>
