<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel Admin</title>
<link rel="stylesheet" href="style.css">
<style>
  body { padding-bottom: 40px; }
  .topo { background: var(--cor-texto-titulo); padding: var(--espaco-md) var(--espaco-lg); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; }
  .topo h2 { color: #fff; font-size: 16px; }
  .topo button { background: none; border: 1px solid rgba(255,255,255,0.3); color: #fff; border-radius: var(--raio-padrao); padding: 6px 12px; font-size: 12px; cursor: pointer; }
  .conteudo { padding: var(--espaco-lg); max-width: 700px; margin: 0 auto; }
  .secao-titulo { font-size: 13px; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; color: var(--cor-texto-suave); margin: var(--espaco-xl) 0 var(--espaco-md); }
  .secao-titulo:first-child { margin-top: 0; }
  .card-item { background: #FFFFFF; border: 1px solid var(--cor-borda); border-radius: var(--raio-md); padding: var(--espaco-lg); margin-bottom: var(--espaco-md); box-shadow: var(--sombra-card); }
  .card-item .linha-topo { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--espaco-sm); }
  .card-item h3 { font-size: 15px; }
  .card-item .sub { font-size: 12px; color: var(--cor-texto-suave); }
  .acoes-item { display: flex; gap: var(--espaco-sm); margin-top: var(--espaco-md); }
  .btn-aprovar { flex:1; height: 36px; border-radius: var(--raio-padrao); background: var(--cor-sucesso); color: #fff; border: none; font-weight: 600; cursor: pointer; }
  .btn-reprovar { flex:1; height: 36px; border-radius: var(--raio-padrao); background: var(--cor-erro-fundo); color: var(--cor-erro-texto); border: none; font-weight: 600; cursor: pointer; }
  select.status-select { height: 32px; border-radius: var(--raio-padrao); border: 1px solid var(--cor-borda); font-size: 12px; padding: 0 var(--espaco-sm); font-weight: 600; }
  .vazio { color: var(--cor-texto-suave); text-align:center; padding: 24px 0; font-size: 13px; }

  .modal-fundo { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.4); align-items: center; justify-content: center; padding: var(--espaco-lg); z-index: 50; }
  .modal-caixa { background: #FFFFFF; border-radius: var(--raio-lg); padding: var(--espaco-xl); width: 100%; max-width: 400px; }
  .modal-caixa h2 { font-size: 18px; margin-bottom: var(--espaco-lg); }
  .modal-acoes { display: flex; gap: var(--espaco-md); margin-top: var(--espaco-lg); }
  .modal-acoes .btn { flex: 1; }
  .erro-msg, .sucesso-msg { display: none; border-radius: var(--raio-padrao); padding: var(--espaco-md); font-size: 13px; margin-bottom: var(--espaco-lg); }
  .erro-msg { background: var(--cor-erro-fundo); color: var(--cor-erro-texto); }
  .sucesso-msg { background: var(--cor-sucesso-fundo); color: var(--cor-sucesso-texto); }
  .btn-add-admin { height: 36px; padding: 0 var(--espaco-md); border-radius: var(--raio-padrao); background: var(--cor-primaria); color: #fff; border: none; font-size: 13px; font-weight: 600; cursor: pointer; }
</style>
</head>
<body>

<div class="topo">
  <h2 id="nomeAdmin">Painel do Administrador</h2>
  <button onclick="sair()">Sair</button>
</div>

<div class="conteudo">

  <div class="secao-titulo" style="display:flex; justify-content:space-between; align-items:center;">
    <span>Empresas pendentes de aprovação</span>
    <button class="btn-add-admin" onclick="abrirModalAdmin()">+ Adicionar Administrador</button>
  </div>
  <div id="listaPendentes"></div>

  <div class="secao-titulo">Chamados de suporte</div>
  <div id="listaTicketsAdmin"></div>

</div>

<div class="modal-fundo" id="modalAdmin">
  <div class="modal-caixa">
    <h2>Adicionar administrador</h2>
    <div id="erroModalAdmin" class="erro-msg"></div>
    <div id="sucessoModalAdmin" class="sucesso-msg"></div>
    <div class="campo">
      <label for="nomeAdminNovo">Nome</label>
      <input type="text" id="nomeAdminNovo" placeholder="Nome completo">
    </div>
    <div class="campo">
      <label for="emailAdminNovo">E-mail</label>
      <input type="email" id="emailAdminNovo" placeholder="email@exemplo.com">
    </div>
    <div class="modal-acoes">
      <button class="btn btn-secundario" onclick="fecharModalAdmin()">Cancelar</button>
      <button class="btn btn-primario" onclick="convidarAdmin()">Enviar convite</button>
    </div>
  </div>
</div>

<script>
const statusLabel = { aberto: 'Aberto', em_andamento: 'Em andamento', resolvido: 'Resolvido', fechado: 'Fechado' };

async function carregarPendentes() {
  const resposta = await fetch('listar_pendentes.php', { credentials: 'same-origin' });
  if (resposta.status === 403) { window.location.href = 'tela_login_admin.php'; return; }
  const json = await resposta.json();
  const lista = document.getElementById('listaPendentes');

  if (!json.sucesso || json.pendentes.length === 0) {
    lista.innerHTML = '<div class="vazio">Nenhuma empresa pendente no momento.</div>';
    return;
  }

  lista.innerHTML = json.pendentes.map(e => `
    <div class="card-item">
      <div class="linha-topo">
        <div>
          <h3>${e.nome_empresa}</h3>
          <div class="sub">${e.nome_responsavel} • ${e.email}</div>
          <div class="sub">${e.cidade || ''} ${e.estado || ''}</div>
        </div>
      </div>
      <div class="acoes-item">
        <button class="btn-aprovar" onclick="aprovar(${e.id}, 'aprovado')">✓ Aprovar</button>
        <button class="btn-reprovar" onclick="aprovar(${e.id}, 'reprovado')">✕ Reprovar</button>
      </div>
    </div>
  `).join('');
}

async function aprovar(empresaId, status) {
  await fetch('aprovar_empresa.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'same-origin',
    body: JSON.stringify({ empresa_id: empresaId, status: status })
  });
  carregarPendentes();
}

async function carregarTickets() {
  const resposta = await fetch('listar_tickets.php', { credentials: 'same-origin' });
  const json = await resposta.json();
  const lista = document.getElementById('listaTicketsAdmin');

  if (!json.sucesso || json.tickets.length === 0) {
    lista.innerHTML = '<div class="vazio">Nenhum chamado aberto.</div>';
    return;
  }

  lista.innerHTML = json.tickets.map(t => `
    <div class="card-item">
      <div class="linha-topo">
        <div>
          <h3>${t.assunto}</h3>
          <div class="sub">${t.nome_empresa || ''} • #${t.id}</div>
        </div>
        <select class="status-select" onchange="mudarStatusTicket(${t.id}, this.value)">
          ${Object.keys(statusLabel).map(s => `<option value="${s}" ${s === t.status ? 'selected' : ''}>${statusLabel[s]}</option>`).join('')}
        </select>
      </div>
      ${t.descricao ? `<div class="sub">${t.descricao}</div>` : ''}
    </div>
  `).join('');
}

async function mudarStatusTicket(ticketId, status) {
  await fetch('atualizar_ticket.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'same-origin',
    body: JSON.stringify({ ticket_id: ticketId, status: status })
  });
  carregarTickets();
}

function abrirModalAdmin() { document.getElementById('modalAdmin').style.display = 'flex'; }
function fecharModalAdmin() {
  document.getElementById('modalAdmin').style.display = 'none';
  document.getElementById('erroModalAdmin').style.display = 'none';
  document.getElementById('sucessoModalAdmin').style.display = 'none';
}

async function convidarAdmin() {
  const erroDiv = document.getElementById('erroModalAdmin');
  const sucessoDiv = document.getElementById('sucessoModalAdmin');
  erroDiv.style.display = 'none';
  sucessoDiv.style.display = 'none';

  const dados = {
    nome: document.getElementById('nomeAdminNovo').value,
    email: document.getElementById('emailAdminNovo').value
  };

  try {
    const resposta = await fetch('convidar_admin.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      sucessoDiv.textContent = json.mensagem;
      sucessoDiv.style.display = 'block';
      document.getElementById('nomeAdminNovo').value = '';
      document.getElementById('emailAdminNovo').value = '';
    } else {
      erroDiv.textContent = json.erro || 'Erro ao convidar administrador';
      erroDiv.style.display = 'block';
    }
  } catch (err) {
    erroDiv.textContent = 'Não foi possível conectar ao servidor';
    erroDiv.style.display = 'block';
  }
}

async function sair() {
  await fetch('logout_admin.php', { credentials: 'same-origin' });
  window.location.href = 'tela_login_admin.php';
}

carregarPendentes();
carregarTickets();
</script>

</body>
</html>
