async function loadData(){
  const config=await fetch('data/config.json').then(r=>r.json());
  document.getElementById('pageTitle').textContent=config.title;
  document.body.style.background=config.backgroundColor;
  const items=await fetch('data/items.json').then(r=>r.json());
  const container=document.getElementById('itemContainer');
  container.innerHTML='';
  items.forEach(it=>{
    const avail=it.limit-it.chosen;
    const col=document.createElement('div');
    col.className='col-md-4 mb-3';
    col.innerHTML=`<div class="card p-3"><h5>${it.name}</h5><button class="btn item-btn" style="background:${it.color};color:#fff" data-id="${it.id}" ${avail>0?'':'disabled'}>Selecionar (${avail})</button></div>`;
    container.appendChild(col);
  });
  attachItemHandlers();
}
function attachItemHandlers(){
  document.querySelectorAll('.item-btn').forEach(btn=>{
    btn.addEventListener('click',()=>{
      document.getElementById('itemInput').value=btn.dataset.id;
      document.getElementById('overlay').style.display='flex';
    });
  });
}
document.getElementById('adminButton').addEventListener('click',()=>{
  const pass=prompt('Senha de admin:');
  if(pass==='admin123'){
    localStorage.setItem('adminPass',pass);
    window.location='admin.html';
  }else if(pass){
    alert('Senha incorreta');
  }
});

document.getElementById('cancel').addEventListener('click',()=>{
  document.getElementById('overlay').style.display='none';
});

document.getElementById('selectForm').addEventListener('submit',async e=>{
  e.preventDefault();
  const data=new FormData(e.target);
  const items=await fetch('data/items.json').then(r=>r.json());
  const records=await fetch('data/records.json').then(r=>r.json());
  const id=Number(data.get('item'));
  const item=items.find(i=>i.id===id);
  if(!item) return alert('Item inválido');
  if(item.chosen>=item.limit) return alert('Limite atingido');
  item.chosen++;
  records.push({first:data.get('first'),last:data.get('last'),item:item.name,date:new Date().toISOString()});
  await Promise.all([
    fetch('data/items.json',{method:'PUT',body:JSON.stringify(items)}),
    fetch('data/records.json',{method:'PUT',body:JSON.stringify(records)})
  ]);
  loadData();
  document.getElementById('overlay').style.display='none';
  e.target.reset();
});
loadData();
