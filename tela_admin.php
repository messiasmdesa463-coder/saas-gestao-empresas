<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo APP_NAME; ?> - Admin</title>
  <link rel="stylesheet" href="cores/syle.css">
  <style>
    body { background: linear-gradient(180deg, #eef2ff, #f8fafc); padding: 24px; }
    .wrap { max-width: 1200px; margin: 0 auto; }
    .topo { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .card { background: #fff; border: 1px solid var(--cor-borda); border-radius: 18px; padding: 20px; box-shadow: var(--sombra-card); }
    .grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
    .kpi { padding: 18px; background: linear-gradient(135deg,#ffffff,#eef2ff); border: 1px solid var(--cor-borda); border-radius: 16px; }
    .kpi .rotulo { color: var(--cor-texto-suave); font-size: 12px; text-transform: uppercase; letter-spacing: .06em; }
    .kpi .valor { font-size: 34px; font-weight: 700; margin-top: 8px; color: var(--cor-texto-titulo); }
    .tabs { display: flex; gap: 10px; margin-bottom: 18px; }
    .tab { background: #fff; border:1px solid var(--cor-borda); border-radius: 12px; padding: 10px 18px; cursor: pointer; font-weight: 600; }
    .tab.active { background: var(--cor-primaria); color: #fff; border-color: var(--cor-primaria); }
    .lista { display: grid; gap: 14px; }
    .item { border:1px solid var(--cor-borda); border-radius: 14px; padding: 16px; background: #fff; }
    .linha { display: flex; justify-content: space-between; gap: 12px; align-items: center; }
    .acoes { display: flex; gap: 10px; margin-top: 12px; }
    .btn { height: 38px; } 
    .btn-primario { background: var(--cor-sucesso); }
    .btn-critico { background: var(--cor-erro); }
    .muted { color: var(--cor-texto-suave); }
    @media (max-width: 720px) { .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 480px) { .grid { grid-template-columns: 1fr; } .topo { flex-direction: column; align-items: flex-start; gap: 12px; } }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="topo">
      <div style="display:flex; align-items:center; gap:12px;">
        <img src="<?php echo APP_LOGO; ?>" alt="Logo <?php echo APP_NAME; ?>" style="width:44px; height:44px; border-radius:12px;">
        <div>
          <h1><?php echo APP_NAME; ?> Admin</h1>
          <p class="muted">Aprova empresas, documentos e acompanha chamados.</p>
        </div>
      </div>
      <a class="btn btn-secundario" href="tela_login.php">Sair</a>
    </div>

    <div class="grid">
      <div class="kpi"><div class="rotulo">Empresas pendentes</div><div class="valor" id="totalPendentes">0</div></div>
      <div class="kpi"><div class="rotulo">Documentos pendentes</div><div class="valor" id="totalDocumentos">0</div></div>
      <div class="kpi"><div class="rotulo">Tickets abertos</div><div class="valor" id="totalTickets">0</div></div>
      <div class="kpi"><div class="rotulo">Empresas aprovadas</div><div class="valor" id="totalAprovadas">0</div></div>
    </div>

    <div class="card">
      <div class="tabs">
        <button class="tab active" data-tipo="empresas">Empresas</button>
        <button class="tab" data-tipo="documentos">Documentos</button>
        <button class="tab" data-tipo="tickets">Tickets</button>
      </div>
      <div id="listaAdmin" class="lista"></div>
    </div>
  </div>

  <script>
    const lista = document.getElementById('listaAdmin');
    const tabs = document.querySelectorAll('.tab');
    let tipoAtual = 'empresas';

    function moeda(v) {
      return Number(v || 0).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function setTab(tipo) {
      tipoAtual = tipo;
      tabs.forEach(tab => tab.classList.toggle('active', tab.dataset.tipo === tipo));
      carregarDados();
    }

    tabs.forEach(tab => tab.addEventListener('click', () => setTab(tab.dataset.tipo)));

    async function carregarDados() {
      try {
        const [empresasRes, docsRes, ticketsRes] = await Promise.all([
          fetch('listar_pedentes.php'),
          fetch('listar_documentos.php'),
          fetch('listar_tickets.php')
        ]);

        const empresasJson = await empresasRes.json();
        const docsJson = await docsRes.json();
        const ticketsJson = await ticketsRes.json();

        const pendentes = empresasJson.pendentes || [];
        const documentos = docsJson.documentos || [];
        const tickets = ticketsJson.tickets || [];

        document.getElementById('totalPendentes').textContent = pendentes.length;
        document.getElementById('totalDocumentos').textContent = documentos.filter(d => d.status === 'pendente').length;
        document.getElementById('totalTickets').textContent = tickets.filter(t => t.status === 'aberto' || t.status === 'em_andamento').length;
        document.getElementById('totalAprovadas').textContent = (pendentes.length ? 0 : 1);

        if (tipoAtual === 'empresas') {
          renderEmpresas(pendentes);
        } else if (tipoAtual === 'documentos') {
          renderDocumentos(documentos);
        } else {
          renderTickets(tickets);
        }
      } catch (err) {
        lista.innerHTML = '<div class="item"><strong>Erro:</strong> não foi possível carregar os dados do painel.</div>';
      }
    }

    function renderEmpresas(empresas) {
      if (!empresas.length) {
        lista.innerHTML = '<div class="item"><p class="muted">Nenhuma empresa pendente de aprovação.</p></div>';
        return;
      }

      lista.innerHTML = empresas.map(e => `
        <div class="item">
          <div class="linha">
            <div>
              <strong>${e.nome_empresa}</strong><br>
              <span class="muted">${e.nome_responsavel} · ${e.email}</span>
            </div>
            <span class="tag-papel tag-gerente">Pendente</span>
          </div>
          <div class="muted" style="margin-top:10px;">CNPJ: ${e.cnpj || '-'} · ${e.cidade || '-'} / ${e.estado || '-'}</div>
          <div class="acoes">
            <button class="btn btn-primario" data-empresa="${e.id}" data-status="aprovado">Aprovar</button>
            <button class="btn btn-critico" data-empresa="${e.id}" data-status="reprovado">Reprovar</button>
          </div>
        </div>
      `).join('');

      document.querySelectorAll('[data-status]').forEach(botao => {
        botao.addEventListener('click', async () => {
          const empresaId = botao.dataset.empresa;
          const status = botao.dataset.status;
          const res = await fetch('aprovar_empresa.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ empresa_id: empresaId, status })
          });
          const json = await res.json();
          if (json.sucesso) {
            carregarDados();
          }
        });
      });
    }

    function renderDocumentos(documentos) {
      if (!documentos.length) {
        lista.innerHTML = '<div class="item"><p class="muted">Nenhum documento enviado.</p></div>';
        return;
      }

      lista.innerHTML = documentos.map(d => `
        <div class="item">
          <div class="linha">
            <div>
              <strong>${d.nome_documento}</strong><br>
              <span class="muted">${d.tipo} · ${d.nome_empresa}</span>
            </div>
            <span class="tag-papel ${d.status === 'aprovado' ? 'tag-dono' : d.status === 'reprovado' ? 'tag-funcionario' : 'tag-gerente'}">${d.status}</span>
          </div>
          <div class="muted" style="margin-top:10px;">Arquivo: ${d.caminho_arquivo || 'sem arquivo'}</div>
          <div class="acoes">
            <button class="btn btn-primario" data-doc="${d.id}" data-status="aprovado">Aprovar</button>
            <button class="btn btn-critico" data-doc="${d.id}" data-status="reprovado">Reprovar</button>
          </div>
        </div>
      `).join('');

      document.querySelectorAll('[data-doc]').forEach(botao => {
        botao.addEventListener('click', async () => {
          const documentoId = botao.dataset.doc;
          const status = botao.dataset.status;
          const res = await fetch('aprovar_documento.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ documento_id: documentoId, status, observacao: status === 'reprovado' ? 'Reprovado pelo administrador' : 'Aprovado pelo administrador' })
          });
          const json = await res.json();
          if (json.sucesso) {
            carregarDados();
          }
        });
      });
    }

    function renderTickets(tickets) {
      if (!tickets.length) {
        lista.innerHTML = '<div class="item"><p class="muted">Nenhum ticket registrado.</p></div>';
        return;
      }

      lista.innerHTML = tickets.map(t => `
        <div class="item">
          <div class="linha">
            <div>
              <strong>${t.assunto}</strong><br>
              <span class="muted">${t.nome_empresa || 'Empresa'} · ${t.status}</span>
            </div>
            <span class="tag-papel ${t.status === 'resolvido' ? 'tag-dono' : t.status === 'em_andamento' ? 'tag-gerente' : 'tag-funcionario'}">${t.status}</span>
          </div>
          <div class="muted" style="margin-top:10px;">${t.descricao || 'Sem descrição'}</div>
          <div class="acoes">
            <button class="btn btn-secundario" data-ticket="${t.id}" data-status="em_andamento">Em andamento</button>
            <button class="btn btn-primario" data-ticket="${t.id}" data-status="resolvido">Resolver</button>
          </div>
        </div>
      `).join('');

      document.querySelectorAll('[data-ticket]').forEach(botao => {
        botao.addEventListener('click', async () => {
          const ticketId = botao.dataset.ticket;
          const status = botao.dataset.status;
          const res = await fetch('atualizar_ticket.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ticket_id: ticketId, status })
          });
          const json = await res.json();
          if (json.sucesso) {
            carregarDados();
          }
        });
      });
    }

    carregarDados();
  </script>
</body>
</html>
