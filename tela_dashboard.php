<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME; ?> - Dashboard</title>
<link rel="stylesheet" href="cores/syle.css">
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

  .banner-hero {
    width: 100%;
    height: 160px;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--cor-borda);
    box-shadow: var(--sombra-card);
    margin-bottom: 22px;
    background-size: cover;
    background-position: center;
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
  .topo .marca .nomes h2 { font-size: 15px; margin: 0; }
  .topo .marca .nomes p { font-size: 12px; color: var(--cor-texto-suave); margin-top: 2px; }

  .avatar-wrap {
    position: relative;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dfe8ff, #c7d2fe);
    border: 2px solid #fff;
    box-shadow: 0 6px 12px rgba(79, 70, 229, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: var(--cor-primaria);
    font-size: 16px;
    overflow: hidden;
  }

  .avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .config-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 14px;
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 10px;
    color: var(--cor-texto-titulo);
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--sombra-card);
  }

  .config-panel {
    position: absolute;
    right: 0;
    top: calc(100% + 12px);
    width: 220px;
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 14px;
    box-shadow: var(--sombra-flutuante);
    padding: 12px;
    display: none;
    z-index: 30;
  }

  .config-panel.aberto { display: block; }

  .config-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    border: none;
    background: transparent;
    padding: 10px 8px;
    border-radius: 10px;
    text-align: left;
    color: var(--cor-texto-corpo);
    font-size: 13px;
    cursor: pointer;
  }

  .config-item:hover { background: var(--cor-primaria-fundo-suave); }

  .conteudo {
    max-width: 1200px;
    margin: 0 auto;
    padding: 28px 18px 0;
  }

  .menu-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border: 1px solid var(--cor-borda);
    border-radius: 12px;
    background: #fff;
    color: var(--cor-texto-titulo);
    font-size: 22px;
    cursor: pointer;
    box-shadow: var(--sombra-card);
    margin-right: 12px;
  }

  .nav-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.35);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
    z-index: 40;
  }

  .nav-overlay.aberto {
    opacity: 1;
    visibility: visible;
  }

  .nav-drawer {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 260px;
    background: #fff;
    border-right: 1px solid var(--cor-borda);
    box-shadow: 18px 0 40px rgba(15, 23, 42, 0.12);
    padding: 20px 14px 18px;
    transform: translateX(-110%);
    transition: transform 0.22s ease;
    z-index: 50;
    overflow-y: auto;
  }

  .nav-drawer.aberto {
    transform: translateX(0);
  }

  .nav-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding: 0 6px;
  }

  .nav-header h3 {
    margin: 0;
    font-size: 15px;
    color: var(--cor-texto-titulo);
  }

  .nav-close {
    width: 34px;
    height: 34px;
    border: 1px solid var(--cor-borda);
    border-radius: 10px;
    background: #fff;
    color: var(--cor-texto-titulo);
    font-size: 22px;
    cursor: pointer;
  }

  .nav-title {
    font-size: 11px;
    font-weight: 700;
    color: var(--cor-texto-suave);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin: 6px 10px 12px;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 12px 12px;
    border-radius: 12px;
    text-decoration: none;
    color: var(--cor-texto-corpo);
    font-weight: 600;
    margin-bottom: 6px;
    transition: background 0.15s ease, color 0.15s ease;
  }

  .nav-item:hover,
  .nav-item.active {
    background: var(--cor-primaria-fundo-suave);
    color: var(--cor-primaria);
  }

  .nav-icone {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border: 1px solid var(--cor-borda);
    font-size: 16px;
  }

  .nav-item.active .nav-icone {
    background: rgba(79, 70, 229, 0.08);
    border-color: transparent;
  }

  .conteudo-principal {
    min-width: 0;
  }

  .saudacao {
    margin-bottom: 22px;
  }

  .saudacao h1 {
    font-size: clamp(26px, 3vw, 34px);
    margin-bottom: 6px;
  }

  .saudacao p {
    font-size: 14px;
    color: var(--cor-texto-suave);
  }

  .kpis {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 28px;
  }

  .nome-empresa {
    opacity: 1;
    transition: opacity 0.2s ease;
  }

  .nome-empresa.carregando {
    opacity: 0;
  }

  .kpi-card {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px 18px 16px;
    box-shadow: var(--sombra-card);
  }

  .kpi-card .rotulo {
    font-size: 12px;
    color: var(--cor-texto-suave);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .kpi-card .valor {
    font-size: 32px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    line-height: 1.1;
    color: var(--cor-texto-titulo);
  }

  .kpi-card.alerta .valor { color: var(--cor-erro); }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 28px;
  }

  .info-card {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px 18px 16px;
    box-shadow: var(--sombra-card);
  }

  .info-card .titulo {
    font-size: 12px;
    color: var(--cor-texto-suave);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .info-card .valor {
    font-size: 26px;
    font-weight: 700;
    color: var(--cor-texto-titulo);
    margin-bottom: 6px;
  }

  .info-card .meta {
    font-size: 12px;
    color: var(--cor-texto-suave);
  }

  .painel-duplo {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 20px;
    margin-bottom: 28px;
  }

  .panel {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    box-shadow: var(--sombra-card);
    padding: 18px;
  }

  .panel h3 {
    margin: 0 0 14px;
    font-size: 15px;
    color: var(--cor-texto-titulo);
  }

  .lista-pontos {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .lista-pontos .item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 12px;
    background: #f8fafc;
    border: 1px solid var(--cor-borda);
    border-radius: 12px;
    color: var(--cor-texto-corpo);
    font-size: 13px;
  }

  .lista-pontos .badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 28px;
    padding: 0 8px;
    border-radius: 999px;
    background: var(--cor-primaria-fundo-suave);
    color: var(--cor-primaria);
    font-weight: 700;
  }

  .secao-titulo {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--cor-texto-suave);
    margin-bottom: 14px;
  }

  .atalhos {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
  }

  .atalho {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px 16px;
    text-decoration: none;
    color: var(--cor-texto-titulo);
    display: flex;
    flex-direction: column;
    gap: 8px;
    box-shadow: var(--sombra-card);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }

  .atalho:hover {
    transform: translateY(-1px);
    box-shadow: var(--sombra-flutuante);
  }

  .atalho .icone {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--cor-primaria-fundo-suave);
    font-size: 22px;
  }

  .atalho .titulo {
    font-size: 15px;
    font-weight: 600;
  }

  @media (max-width: 900px) {
    .dashboard-layout {
      grid-template-columns: 1fr;
    }

    .sidebar-nav {
      position: static;
    }
  }

  @media (max-width: 560px) {
    .kpis,
    .info-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>

<div class="topo">
  <div class="marca">
    <button class="menu-toggle" id="btnMenuDashboard" type="button" aria-label="Abrir navegação">☰</button>
    <div class="icone"><img src="<?php echo APP_LOGO; ?>" alt="Logo <?php echo APP_NAME; ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;"></div>
    <div class="nomes">
      <h2 id="nomeEmpresa" class="nome-empresa">Dashboard</h2>
      <p><?php echo APP_NAME; ?> • Dashboard</p>
    </div>
  </div>

  <div class="avatar-wrap">
    <div class="avatar" id="avatarUsuario" aria-label="Usuário">U</div>
    <button class="config-btn" id="btnConfigDashboard" type="button">⚙ Config</button>

    <div class="config-panel" id="configPanelDashboard">
      <button class="config-item" type="button" onclick="window.location.href='tela_config_dashboard.php'">⚙ Abrir config Dashboard</button>
      <button class="config-item" type="button" onclick="window.location.href='tela_config_dashboard.php#perfil'">👤 Perfil da conta</button>
      <button class="config-item" type="button" onclick="window.location.href='tela_config_dashboard.php#seguranca'">🔒 Segurança</button>
      <button class="config-item" type="button" onclick="window.location.href='tela_login.php'">🚪 Sair</button>
    </div>
  </div>
</div>

<div class="nav-overlay" id="navOverlay"></div>

<aside class="nav-drawer" id="navDrawer" aria-label="Menu de navegação">
  <div class="nav-header">
    <h3>Navegação</h3>
    <button class="nav-close" id="btnCloseNav" type="button" aria-label="Fechar navegação">×</button>
  </div>
  <div class="nav-title">Menu</div>
  <a class="nav-item active" href="tela_dashboard.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">🏠</span>
    <span>Dashboard</span>
  </a>
  <a class="nav-item" href="tela_produtos.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">📦</span>
    <span>Produtos</span>
  </a>
  <a class="nav-item" href="tela_movimentar_estoque.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">📥</span>
    <span>Estoque</span>
  </a>
  <a class="nav-item" href="tela_atendimento.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">💬</span>
    <span>Atendimento</span>
  </a>
  <a class="nav-item" href="tela_equipe.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">👥</span>
    <span>Equipe</span>
  </a>
  <a class="nav-item" href="relatorio_mensal.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">📊</span>
    <span>Relatórios</span>
  </a>
  <a class="nav-item" href="tela_config_dashboard.php?empresa_id=<?php echo $_GET['empresa_id'] ?? 1; ?>">
    <span class="nav-icone">⚙️</span>
    <span>Configurações</span>
  </a>
</aside>

<div class="conteudo">
  <main class="conteudo-principal">
      <div class="banner-hero" id="bannerHero" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80');"></div>

      <div class="saudacao">
        <h1>Bem-vindo de volta 👋</h1>
        <p>Aqui está o resumo completo do seu negócio.</p>
      </div>

      <div class="kpis">
        <div class="kpi-card">
          <div class="rotulo">Total de Produtos</div>
          <div class="valor" id="kpiProdutos">-</div>
        </div>
        <div class="kpi-card alerta">
          <div class="rotulo">Estoque Baixo</div>
          <div class="valor" id="kpiEstoqueBaixo">-</div>
        </div>
        <div class="kpi-card">
          <div class="rotulo">Entradas no mês</div>
          <div class="valor" id="kpiEntradas">-</div>
        </div>
        <div class="kpi-card">
          <div class="rotulo">Saídas no mês</div>
          <div class="valor" id="kpiSaidas">-</div>
        </div>
      </div>

      <div class="info-grid">
        <div class="info-card">
          <div class="titulo">Usuários ativos</div>
          <div class="valor" id="infoUsuarios">-</div>
          <div class="meta" id="infoUsuariosMeta">equipes e acessos</div>
        </div>
        <div class="info-card">
          <div class="titulo">Tickets abertos</div>
          <div class="valor" id="infoTickets">-</div>
          <div class="meta" id="infoTicketsMeta">em atendimento</div>
        </div>
        <div class="info-card">
          <div class="titulo">Documentos</div>
          <div class="valor" id="infoDocumentos">-</div>
          <div class="meta" id="infoDocumentosMeta">pendentes</div>
        </div>
        <div class="info-card">
          <div class="titulo">Valor em estoque</div>
          <div class="valor" id="infoEstoqueValor">-</div>
          <div class="meta" id="infoEstoqueMeta">estoque atual</div>
        </div>
      </div>

      <div class="painel-duplo">
        <div class="panel">
          <h3>Resumo operacional</h3>
          <div class="lista-pontos">
            <div class="item"><span>Equipe ativa</span><span class="badge" id="badgeUsuarios">-</span></div>
            <div class="item"><span>Atendimentos em andamento</span><span class="badge" id="badgeTickets">-</span></div>
            <div class="item"><span>Produtos com alerta</span><span class="badge" id="badgeEstoque">-</span></div>
            <div class="item"><span>Documentos aprovados</span><span class="badge" id="badgeDocs">-</span></div>
          </div>
        </div>

        <div class="panel">
          <h3>Performance</h3>
          <div class="lista-pontos">
            <div class="item"><span>Volume de entradas</span><span class="badge" id="badgeEntradas">-</span></div>
            <div class="item"><span>Volume de saídas</span><span class="badge" id="badgeSaidas">-</span></div>
            <div class="item"><span>Capacidade de resposta</span><span class="badge" id="badgeResponse">-</span></div>
            <div class="item"><span>Status geral</span><span class="badge" id="badgeStatus">OK</span></div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
const params = new URLSearchParams(window.location.search);
const empresaId = params.get('empresa_id') || 1;
const configSaved = params.get('config_saved') === '1';
const dashboardRefreshKey = 'saas_dashboard_refresh';

const bannerHero = document.getElementById('bannerHero');
const avatarUsuario = document.getElementById('avatarUsuario');
const nomeEmpresaEl = document.getElementById('nomeEmpresa');
const logoEmpresaEl = document.querySelector('.icone img');
const bannerPadrao = 'linear-gradient(135deg, #1f2937 0%, #0f172a 35%, #4f46e5 100%)';

function aplicarBanner(url) {
  const nomeEmpresa = (nomeEmpresaEl && nomeEmpresaEl.textContent ? nomeEmpresaEl.textContent.trim() : 'Minha Empresa');

  if (url && url.trim()) {
    bannerHero.innerHTML = '';
    bannerHero.style.backgroundImage = `url('${url.trim().replace(/['"]/g, '')}')`;
    bannerHero.style.backgroundSize = 'cover';
    bannerHero.style.backgroundPosition = 'center';
    return;
  }

  bannerHero.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#fff;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;">' + nomeEmpresa + '</div>';
  bannerHero.style.backgroundImage = bannerPadrao;
  bannerHero.style.backgroundSize = 'cover';
  bannerHero.style.backgroundPosition = 'center';
}

async function carregarConfiguracoesDashboard() {
  try {
    const resposta = await fetch('carregar_config_dashboard.php');
    const json = await resposta.json();
    const config = json.config || {};

    aplicarBanner(config.banner || bannerPadrao);

    if (config.fotoLogo) {
      logoEmpresaEl.src = config.fotoLogo;
    }

    if (config.fotoPerfil) {
      avatarUsuario.innerHTML = `<img src="${config.fotoPerfil}" alt="Perfil do usuário">`;
    }

    if (config.empresaNome) {
      nomeEmpresaEl.textContent = config.empresaNome;
      nomeEmpresaEl.classList.remove('carregando');
    } else {
      nomeEmpresaEl.classList.remove('carregando');
      nomeEmpresaEl.textContent = 'Dashboard';
    }

    if (config.nome) {
      const nomeInicial = config.nome.trim().charAt(0).toUpperCase();
      if (!config.fotoPerfil) {
        avatarUsuario.textContent = nomeInicial || 'U';
      }
    }
  } catch (err) {
    console.error('Erro ao carregar configurações do dashboard', err);
  }
}

document.getElementById('linkProdutos')?.setAttribute('href', `tela_produtos.php?empresa_id=${empresaId}`);
document.getElementById('linkEstoque')?.setAttribute('href', `tela_produtos.php?empresa_id=${empresaId}`);
document.getElementById('linkAtendimento')?.setAttribute('href', `tela_atendimento.php?empresa_id=${empresaId}`);
document.getElementById('linkEquipe')?.setAttribute('href', `tela_equipe.php?empresa_id=${empresaId}`);

const btnConfigDashboard = document.getElementById('btnConfigDashboard');
const configPanelDashboard = document.getElementById('configPanelDashboard');
const btnMenuDashboard = document.getElementById('btnMenuDashboard');
const navDrawer = document.getElementById('navDrawer');
const navOverlay = document.getElementById('navOverlay');
const btnCloseNav = document.getElementById('btnCloseNav');

function abrirMenu() {
  navDrawer.classList.add('aberto');
  navOverlay.classList.add('aberto');
}

function fecharMenu() {
  navDrawer.classList.remove('aberto');
  navOverlay.classList.remove('aberto');
}

btnMenuDashboard.addEventListener('click', function() {
  const aberto = navDrawer.classList.contains('aberto');
  if (aberto) {
    fecharMenu();
  } else {
    abrirMenu();
  }
});

btnCloseNav.addEventListener('click', fecharMenu);
navOverlay.addEventListener('click', fecharMenu);

btnConfigDashboard.addEventListener('click', function() {
  configPanelDashboard.classList.toggle('aberto');
  fecharMenu();
});

document.addEventListener('click', function(event) {
  if (!event.target.closest('.avatar-wrap')) {
    configPanelDashboard.classList.remove('aberto');
  }

  if (!event.target.closest('#btnMenuDashboard') && !event.target.closest('.nav-drawer') && !event.target.closest('.nav-overlay')) {
    fecharMenu();
  }
});

function formatarMoeda(valor) {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2
  }).format(Number(valor || 0));
}

async function carregarResumo() {
  try {
    const resposta = await fetch(`relatorio_mensal.php?empresa_id=${empresaId}`);
    const json = await resposta.json();
    if (json.sucesso) {
      document.getElementById('kpiProdutos').textContent = json.total_produtos;
      document.getElementById('kpiEstoqueBaixo').textContent = json.produtos_estoque_baixo;
      document.getElementById('kpiEntradas').textContent = json.entradas_estoque;
      document.getElementById('kpiSaidas').textContent = json.saidas_estoque;

      document.getElementById('infoUsuarios').textContent = json.usuarios_ativos || 0;
      document.getElementById('infoUsuariosMeta').textContent = `${json.total_usuarios || 0} total(s)`;

      document.getElementById('infoTickets').textContent = json.tickets_abertos || 0;
      document.getElementById('infoTicketsMeta').textContent = `${json.tickets_total || 0} no total`;

      document.getElementById('infoDocumentos').textContent = json.documentos_pendentes || 0;
      document.getElementById('infoDocumentosMeta').textContent = `${json.documentos_aprovados || 0} aprovados`;

      document.getElementById('infoEstoqueValor').textContent = formatarMoeda(json.valor_estoque || 0);
      document.getElementById('infoEstoqueMeta').textContent = `${json.total_produtos || 0} itens no estoque`;

      document.getElementById('badgeUsuarios').textContent = json.usuarios_ativos || 0;
      document.getElementById('badgeTickets').textContent = json.tickets_abertos || 0;
      document.getElementById('badgeEstoque').textContent = json.produtos_estoque_baixo || 0;
      document.getElementById('badgeDocs').textContent = json.documentos_aprovados || 0;
      document.getElementById('badgeEntradas').textContent = json.entradas_estoque || 0;
      document.getElementById('badgeSaidas').textContent = json.saidas_estoque || 0;

      const percentualResposta = json.tickets_total ? Math.max(0, Math.min(100, Math.round(((json.tickets_total - (json.tickets_abertos || 0)) / json.tickets_total) * 100))) : 100;
      document.getElementById('badgeResponse').textContent = `${percentualResposta}%`;
      document.getElementById('miniDocsAprovados').textContent = json.documentos_aprovados || 0;
      document.getElementById('miniAtendimentoHoje').textContent = json.tickets_abertos || 0;
      document.getElementById('accProdutos').textContent = json.total_produtos || 0;
      document.getElementById('accEstoqueBaixo').textContent = json.produtos_estoque_baixo || 0;
      document.getElementById('accValorEstoque').textContent = formatarMoeda(json.valor_estoque || 0);
      document.getElementById('accTicketsAbertos').textContent = json.tickets_abertos || 0;
      document.getElementById('accTicketsTotal').textContent = json.tickets_total || 0;
      document.getElementById('accResposta').textContent = `${percentualResposta}%`;
      document.getElementById('accUsuariosAtivos').textContent = json.usuarios_ativos || 0;
      document.getElementById('accUsuariosTotal').textContent = json.total_usuarios || 0;

      if ((json.produtos_estoque_baixo || 0) > 0) {
        document.getElementById('badgeStatus').textContent = 'ALERTA';
        document.getElementById('miniStatusGeral').textContent = 'ALERTA';
        document.getElementById('accStatusEquipe').textContent = 'ALERTA';
      } else {
        document.getElementById('miniStatusGeral').textContent = 'OK';
        document.getElementById('accStatusEquipe').textContent = 'OK';
      }
    }
  } catch (err) {
    console.error('Erro ao carregar resumo', err);
  }
}

carregarResumo();
carregarConfiguracoesDashboard();

if (configSaved || localStorage.getItem(dashboardRefreshKey)) {
  localStorage.removeItem(dashboardRefreshKey);
  setTimeout(() => {
    const url = new URL(window.location.href);
    url.searchParams.delete('config_saved');
    url.searchParams.delete('ts');
    window.history.replaceState({}, document.title, url.toString());
  }, 150);
}
</script>

</body>
</html>
