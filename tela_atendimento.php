<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atendimento</title>
<link rel="stylesheet" href="style.css">
<style>
  body {
    background: linear-gradient(180deg, #f5f7ff 0%, #f3f6fb 100%);
    padding-bottom: 40px;
  }

  .topo {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--cor-borda);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 20;
  }

  .topo .marca {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .topo .marca .icone {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--cor-primaria), #2d4bd8);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 18px rgba(79, 70, 229, 0.2);
  }

  .topo .marca .icone svg { width: 20px; height: 20px; }

  .avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dfe8ff, #c7d2fe);
    border: 2px solid #fff;
    box-shadow: 0 6px 12px rgba(79, 70, 229, 0.12);
  }

  .conteudo {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px 18px 0;
  }

  .kpis {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 18px;
  }

  .kpi-card {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px 16px;
    text-align: center;
    box-shadow: var(--sombra-card);
  }

  .kpi-card .valor {
    font-size: 28px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .kpi-card .rotulo {
    font-size: 11px;
    color: var(--cor-texto-suave);
    margin-top: 2px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }

  .filtros {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    margin-bottom: 18px;
    padding-bottom: 4px;
  }

  .filtro-chip {
    flex-shrink: 0;
    height: 36px;
    padding: 0 16px;
    border-radius: 999px;
    border: 1px solid var(--cor-borda);
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: var(--cor-texto-corpo);
    cursor: pointer;
  }

  .filtro-chip.ativo {
    background: var(--cor-primaria-fundo-suave);
    border-color: var(--cor-primaria);
    color: var(--cor-primaria);
  }

  .card-ticket {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px;
    margin-bottom: 16px;
    box-shadow: var(--sombra-card);
  }

  .card-ticket .linha-topo {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 10px;
  }

  .card-ticket h3 {
    font-size: 16px;
    margin: 0 0 4px;
  }

  .card-ticket .empresa {
    font-size: 12px;
    color: var(--cor-texto-suave);
  }

  .card-ticket .tempo {
    font-size: 11px;
    color: var(--cor-texto-suave);
    white-space: nowrap;
  }

  .card-ticket .descricao {
    font-size: 13px;
    color: var(--cor-texto-corpo);
    margin: 10px 0;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 12px;
    padding: 12px;
  }

  .card-ticket .rodape {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  select.status-select {
    height: 34px;
    border-radius: 10px;
    border: 1px solid var(--cor-borda);
    font-size: 12px;
    padding: 0 10px;
    font-weight: 600;
    background: #fff;
  }

  .fab-novo {
    position: fixed;
    bottom: 24px;
    right: 24px;
    height: 52px;
    padding: 0 18px;
    border-radius: 999px;
    background: var(--cor-primaria);
    color: #fff;
    border: none;
    font-weight: 700;
    font-size: 14px;
    box-shadow: var(--sombra-flutuante);
    cursor: pointer;
  }

  .titulo-clicavel {
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .titulo-clicavel:hover {
    color: var(--cor-primaria);
  }

  @media (max-width: 560px) {
    .kpis {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>

<div class="topo">
  <div class="marca">
    <div class="icone"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
    <h2 id="tituloAtendimento" class="titulo-clicavel">Atendimento</h2>
  </div>
  <div class="avatar"></div>
</div>

<div class="conteudo">

  <div class="kpis">
    <div class="kpi-card"><div class="valor" id="kpiAbertos">-</div><div class="rotulo">Abertos</div></div>
    <div class="kpi-card"><div class="valor" id="kpiAndamento">-</div><div class="rotulo">Em andamento</div></div>
    <div class="kpi-card"><div class="valor" id="kpiResolvidos">-</div><div class="rotulo">Resolvidos</div></div>
  </div>

  <div class="filtros">
    <button class="filtro-chip ativo" data-filtro="todos">Todos</button>
    <button class="filtro-chip" data-filtro="aberto">Aberto</button>
    <button class="filtro-chip" data-filtro="em_andamento">Em andamento</button>
    <button class="filtro-chip" data-filtro="resolvido">Resolvido</button>
  </div>

  <div id="listaTickets"></div>

</div>

<button class="fab-novo" onclick="location.href='tela_novo_ticket.php'">+ Novo Atendimento</button>

<script>
const empresaId = new URLSearchParams(window.location.search).get('empresa_id'); // vazio = visão do admin (todos)
const tituloAtendimento = document.getElementById('tituloAtendimento');

if (tituloAtendimento) {
  tituloAtendimento.addEventListener('click', () => {
    const empresaAtual = empresaId || 1;
    window.location.href = `tela_dashboard.php?empresa_id=${empresaAtual}`;
  });
}

let todosTickets = [];

const statusLabel = { aberto: 'Aberto', em_andamento: 'Em andamento', resolvido: 'Resolvido', fechado: 'Fechado' };
const statusClasse = { aberto: 'badge-erro', em_andamento: 'badge-atencao', resolvido: 'badge-sucesso', fechado: 'badge-sucesso' };

async function carregarTickets() {
  const url = empresaId ? `listar_tickets.php?empresa_id=${empresaId}` : 'listar_tickets.php';
  try {
    const resposta = await fetch(url);
    const json = await resposta.json();
    if (json.sucesso) {
      todosTickets = json.tickets;
      atualizarKpis();
      renderizar(todosTickets);
    }
  } catch (err) {
    document.getElementById('listaTickets').innerHTML = '<p style="color:var(--cor-erro-texto)">Erro ao carregar chamados.</p>';
  }
}

function atualizarKpis() {
  document.getElementById('kpiAbertos').textContent = todosTickets.filter(t => t.status === 'aberto').length;
  document.getElementById('kpiAndamento').textContent = todosTickets.filter(t => t.status === 'em_andamento').length;
  document.getElementById('kpiResolvidos').textContent = todosTickets.filter(t => t.status === 'resolvido').length;
}

function renderizar(tickets) {
  const lista = document.getElementById('listaTickets');
  if (tickets.length === 0) {
    lista.innerHTML = '<p style="color:var(--cor-texto-suave); text-align:center; padding: 40px 0;">Nenhum chamado por aqui.</p>';
    return;
  }

  lista.innerHTML = tickets.map(t => `
    <div class="card-ticket">
      <div class="linha-topo">
        <div>
          <h3>${t.assunto}</h3>
          <div class="empresa">${t.nome_empresa || ''}</div>
        </div>
        <div class="tempo">#${t.id}</div>
      </div>
      ${t.descricao ? `<div class="descricao">${t.descricao}</div>` : ''}
      <div class="rodape">
        <span class="badge ${statusClasse[t.status]}"><span class="badge-dot"></span> ${statusLabel[t.status]}</span>
        <select class="status-select" onchange="mudarStatus(${t.id}, this.value)">
          ${Object.keys(statusLabel).map(s => `<option value="${s}" ${s === t.status ? 'selected' : ''}>${statusLabel[s]}</option>`).join('')}
        </select>
      </div>
    </div>
  `).join('');
}

document.querySelectorAll('.filtro-chip').forEach(chip => {
  chip.addEventListener('click', () => {
    document.querySelectorAll('.filtro-chip').forEach(c => c.classList.remove('ativo'));
    chip.classList.add('ativo');
    const f = chip.dataset.filtro;
    renderizar(f === 'todos' ? todosTickets : todosTickets.filter(t => t.status === f));
  });
});

async function mudarStatus(ticketId, novoStatus) {
  try {
    await fetch('atualizar_ticket.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ ticket_id: ticketId, status: novoStatus })
    });
    carregarTickets();
  } catch (err) {
    alert('Erro ao atualizar chamado');
  }
}

carregarTickets();
</script>

</body>
</html>
