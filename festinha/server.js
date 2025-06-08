const http=require('http');
const fs=require('fs');
const path=require('path');
const url=require('url');
const DATA_DIR=path.join(__dirname,'data');
function send(res,status,data,type='application/json'){
  res.writeHead(status,{'Content-Type':type});
  res.end(data);
}
function readJSON(file){
  return JSON.parse(fs.readFileSync(path.join(DATA_DIR,file),'utf8'));
}
function writeJSON(file,obj){
  fs.writeFileSync(path.join(DATA_DIR,file),JSON.stringify(obj,null,2));
}
http.createServer((req,res)=>{
  const parsed=url.parse(req.url,true);
  const method=req.method;
  if(parsed.pathname.startsWith('/data/') && method==='GET'){
    const file=path.join(__dirname,parsed.pathname);
    if(fs.existsSync(file))return send(res,200,fs.readFileSync(file),'application/json');
  }
  if(parsed.pathname.startsWith('/data/') && method==='PUT'){
    let body='';
    req.on('data',d=>body+=d);
    req.on('end',()=>{writeJSON(parsed.pathname.replace('/data/',''),JSON.parse(body));send(res,200,'ok');});
    return;
  }
  if(parsed.pathname==='/' && method==='GET'){
    return send(res,200,fs.readFileSync(path.join(__dirname,'index.html')),'text/html');
  }
  if(parsed.pathname==='/admin.html' && method==='GET'){
    return send(res,200,fs.readFileSync(path.join(__dirname,'admin.html')),'text/html');
  }
  if(parsed.pathname.startsWith('/js/') && method==='GET'){
    return send(res,200,fs.readFileSync(path.join(__dirname,parsed.pathname)),'application/javascript');
  }
  if(parsed.pathname.startsWith('/css/') && method==='GET'){
    return send(res,200,fs.readFileSync(path.join(__dirname,'..',parsed.pathname)),'text/css');
  }
  send(res,404,'not found','text/plain');
}).listen(3000,()=>console.log('Server running on http://localhost:3000'));
