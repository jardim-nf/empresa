function checkPass(){
  let pass=localStorage.getItem('adminPass');
  if(!pass){
    pass=prompt('Senha de admin:');
    if(pass!=='admin123'){
      alert('Senha incorreta');
      window.location='index.html';
      return null;
    }
    localStorage.setItem('adminPass',pass);
  }
  return pass;
}
async function loadItems(){
  const items=await fetch('data/items.json').then(r=>r.json());
  const list=document.getElementById('itemList');
  list.innerHTML='';
  items.forEach(i=>{
    const li=document.createElement('li');
    li.className='list-group-item';
    li.textContent=`${i.name} - limite: ${i.limit} - escolhido: ${i.chosen}`;
    list.appendChild(li);
  });
}
async function loadRecords(){
  const rec=await fetch('data/records.json').then(r=>r.json());
  const tbody=document.getElementById('recordBody');
  tbody.innerHTML='';
  rec.forEach(r=>{
    const tr=document.createElement('tr');
    tr.innerHTML=`<td>${r.first}</td><td>${r.last}</td><td>${r.item}</td><td>${r.date}</td>`;
    tbody.appendChild(tr);
  });
}
async function loadConfig(){
  const conf=await fetch('data/config.json').then(r=>r.json());
  const form=document.getElementById('configForm');
  form.title.value=conf.title;
  form.background.value=conf.backgroundColor;
}
document.getElementById('addItemForm').addEventListener('submit',async e=>{
  e.preventDefault();
  const items=await fetch('data/items.json').then(r=>r.json());
  const data=new FormData(e.target);
  const id=Math.max(0,...items.map(i=>i.id))+1;
  items.push({id,name:data.get('name'),limit:Number(data.get('limit')),chosen:0,color:data.get('color')});
  await fetch('data/items.json',{method:'PUT',body:JSON.stringify(items)});
  e.target.reset();
  loadItems();
});
document.getElementById('configForm').addEventListener('submit',async e=>{
  e.preventDefault();
  const data=new FormData(e.target);
  const conf={title:data.get('title'),backgroundColor:data.get('background')};
  await fetch('data/config.json',{method:'PUT',body:JSON.stringify(conf)});
  alert('Configurações salvas');
});
checkPass();
loadItems();
loadRecords();
loadConfig();
