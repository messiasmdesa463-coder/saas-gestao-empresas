<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo APP_NAME; ?> - Configurações</title>
  <link rel="stylesheet" href="cores/syle.css">
  <style>
    body {
      background: linear-gradient(180deg, #f8fafc, #eef2ff);
      padding: 32px 18px 48px;
    }

    .wrap {
      max-width: 1100px;
      margin: 0 auto;
    }

    .topo {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 24px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .logo {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: var(--sombra-flutuante);
    }

    .logo img { width: 100%; height: 100%; object-fit: cover; }

    .card {
      background: #fff;
      border: 1px solid var(--cor-borda);
      border-radius: 18px;
      box-shadow: var(--sombra-card);
      padding: 24px;
    }

    .grid {
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 24px;
      margin-top: 18px;
    }

    .menu-config {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #fff;
      border: 1px solid var(--cor-borda);
      border-radius: 12px;
      padding: 12px 14px;
      color: var(--cor-texto-titulo);
      text-decoration: none;
      font-weight: 600;
    }

    .menu-item.ativo {
      background: var(--cor-primaria-fundo-suave);
      border-color: #c7d2fe;
      color: var(--cor-primaria);
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 18px;
    }

    .campo {
      margin-bottom: 0;
    }

    .full { grid-column: 1 / -1; }

    .switch-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 16px;
      background: #f8fafc;
      border: 1px solid var(--cor-borda);
      border-radius: 12px;
      margin-top: 10px;
    }

    .switch {
      width: 46px;
      height: 26px;
      border-radius: 999px;
      background: #cbd5e1;
      position: relative;
      display: inline-block;
    }

    .switch::after {
      content: "";
      position: absolute;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #fff;
      top: 4px;
      left: 4px;
      box-shadow: 0 2px 4px rgba(15, 23, 42, 0.12);
    }

    .switch.on {
      background: var(--cor-primaria);
    }

    .switch.on::after {
      left: 24px;
    }

    .alerta-salvo {
      display: none;
      margin-top: 16px;
      padding: 12px 14px;
      border-radius: 12px;
      background: #ecfdf5;
      color: #047857;
      border: 1px solid #a7f3d0;
      font-weight: 600;
    }

    .alerta-salvo.show {
      display: block;
    }

    .btn-salvar-succes {
      background: var(--cor-sucesso);
      color: #fff;
    }

    @media (max-width: 768px) {
      .grid,
      .form-grid {
        grid-template-columns: 1fr;
      }

      .topo {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="topo">
      <div class="brand">
        <div class="logo"><img src="<?php echo APP_LOGO; ?>" alt="Logo <?php echo APP_NAME; ?>"></div>
        <div>
          <h1><?php echo APP_NAME; ?></h1>
          <p class="muted">Configurações gerais da empresa</p>
        </div>
      </div>
      <a href="tela_dashboard.php" class="btn btn-secundario">Voltar ao dashboard</a>
    </div>

    <div class="card">
      <div class="grid">
        <aside>
          <div class="menu-config">
            <a href="#perfil" class="menu-item ativo">👤 Perfil da conta</a>
            <a href="#seguranca" class="menu-item">🔒 Segurança</a>
            <a href="#empresa" class="menu-item">🏢 Empresa</a>
            <a href="tela_login.php" class="menu-item">🚪 Sair</a>
          </div>
        </aside>

        <section>
          <div id="perfil">
            <h2>Perfil da conta</h2>
            <div class="form-grid" style="margin-top:16px;">
              <div class="campo">
                <label for="nome">Nome</label>
                <input id="nome" type="text" value="">
              </div>
              <div class="campo">
                <label for="email">E-mail</label>
                <input id="email" type="email" value="">
              </div>
              <div class="campo">
                <label for="cargo">Cargo</label>
                <input id="cargo" type="text" value="">
              </div>
              <div class="campo">
                <label for="whatsapp">WhatsApp</label>
                <input id="whatsapp" type="text" value="">
              </div>
              <div class="campo full">
                <label for="fotoPerfil">URL da foto de perfil</label>
                <input id="fotoPerfil" type="url" value="">
              </div>
              <div class="campo full">
                <label for="fotoLogo">URL da logo do sistema</label>
                <input id="fotoLogo" type="url" value="">
              </div>
              <div class="campo full">
                <label for="banner">URL do banner / imagem principal do dashboard</label>
                <input id="banner" type="url" value="">
              </div>
            </div>
          </div>

          <div id="seguranca" style="margin-top:32px;">
            <h2>Segurança</h2>
            <div class="switch-row">
              <div>
                <strong>Autenticação de duas etapas</strong><br>
                <span class="muted">Reforça a segurança do painel administrativo.</span>
              </div>
              <span class="switch on" aria-label="Autenticação ativa"></span>
            </div>
            <div class="switch-row" style="margin-top:12px;">
              <div>
                <strong>Notificações de login</strong><br>
                <span class="muted">Receber alerta quando houver acesso novo.</span>
              </div>
              <span class="switch on" aria-label="Notificação ativa"></span>
            </div>
          </div>

          <div id="empresa" style="margin-top:32px;">
            <h2>Empresa</h2>
            <div class="form-grid" style="margin-top:16px;">
              <div class="campo">
                <label for="empresaNome">Nome da empresa</label>
                <input id="empresaNome" type="text" value="Admin SaaS">
              </div>
              <div class="campo">
                <label for="empresaCnpj">CNPJ</label>
                <input id="empresaCnpj" type="text" value="00.000.000/0000-00">
              </div>
              <div class="campo full">
                <label for="endereco">Endereço</label>
                <input id="endereco" type="text" value="São Paulo, SP">
              </div>
            </div>
          </div>

          <div id="mensagemSucesso" class="alerta-salvo" role="alert">✅ Salvo com sucesso.</div>

          <div style="margin-top:24px; display:flex; gap:12px; justify-content:flex-end;">
            <button type="button" class="btn btn-secundario">Cancelar</button>
            <button id="btnSalvarConfig" type="button" class="btn btn-primario">Salvar</button>
          </div>
        </section>
      </div>
    </div>
  </div>

  <script>
    const btnSalvarConfig = document.getElementById('btnSalvarConfig');
    const mensagemSucesso = document.getElementById('mensagemSucesso');

    async function carregarConfiguracoes() {
      try {
        const resposta = await fetch('carregar_config_dashboard.php');
        const json = await resposta.json();
        if (json.sucesso && json.config) {
          const config = json.config;
          document.getElementById('nome').value = config.nome ?? '';
          document.getElementById('email').value = config.email ?? '';
          document.getElementById('cargo').value = config.cargo ?? '';
          document.getElementById('whatsapp').value = config.whatsapp ?? '';
          document.getElementById('fotoPerfil').value = config.fotoPerfil ?? '';
          document.getElementById('fotoLogo').value = config.fotoLogo ?? '';
          document.getElementById('banner').value = config.banner ?? '';
          document.getElementById('empresaNome').value = config.empresaNome ?? '';
          document.getElementById('empresaCnpj').value = config.empresaCnpj ?? '';
          document.getElementById('endereco').value = config.endereco ?? '';
        }
      } catch (err) {
        console.error('Erro ao carregar configurações', err);
      }
    }

    btnSalvarConfig.addEventListener('click', async function() {
      const dados = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        cargo: document.getElementById('cargo').value,
        whatsapp: document.getElementById('whatsapp').value,
        fotoPerfil: document.getElementById('fotoPerfil').value,
        fotoLogo: document.getElementById('fotoLogo').value,
        banner: document.getElementById('banner').value,
        empresaNome: document.getElementById('empresaNome').value,
        empresaCnpj: document.getElementById('empresaCnpj').value,
        endereco: document.getElementById('endereco').value
      };

      try {
        const resposta = await fetch('salvar_config_dashboard.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(dados)
        });

        const json = await resposta.json();
        if (json.sucesso) {
          mensagemSucesso.classList.add('show');
          btnSalvarConfig.textContent = 'Salvo';
          btnSalvarConfig.classList.add('btn-salvar-succes');
          btnSalvarConfig.disabled = true;

          const empresaId = new URLSearchParams(window.location.search).get('empresa_id') || 1;
          const ts = Date.now();
          localStorage.setItem('saas_dashboard_refresh', String(ts));

          setTimeout(() => {
            window.location.href = `tela_dashboard.php?empresa_id=${empresaId}&config_saved=1&ts=${ts}`;
          }, 900);
        }
      } catch (err) {
        mensagemSucesso.textContent = '❌ Não foi possível salvar.';
        mensagemSucesso.classList.add('show');
      }
    });

    carregarConfiguracoes();
  </script>
</body>
</html>
