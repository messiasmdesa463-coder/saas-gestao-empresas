<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SaaS Gestão - Login</title>
<link rel="stylesheet" href="style.css">
<style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: var(--espaco-lg);
  }

  .tela-login {
    width: 100%;
    max-width: 420px;
  }

  .logo-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--espaco-sm);
    margin-bottom: var(--espaco-xl);
  }

  .logo-icone-wrap { position: relative; margin-bottom: var(--espaco-sm); }

  .logo-icone {
    width: 72px;
    height: 72px;
    border-radius: var(--raio-lg);
    background: var(--cor-primaria);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .logo-icone svg { width: 36px; height: 36px; }

  .logo-check {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--cor-sucesso);
    border: 3px solid var(--cor-fundo);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .logo-check svg { width: 12px; height: 12px; }

  .logo-wrap h1 {
    font-size: 28px;
    line-height: 34px;
  }

  .logo-wrap p {
    color: var(--cor-texto-suave);
    font-size: 14px;
    text-align: center;
  }

  .faixa-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--espaco-md);
    background: var(--cor-primaria-fundo-suave);
    border-radius: var(--raio-md);
    padding: var(--espaco-md) var(--espaco-lg);
    margin-bottom: var(--espaco-md);
  }

  .faixa-info .esquerda { display: flex; align-items: center; gap: var(--espaco-md); }
  .faixa-info .icone-caixa {
    width: 36px; height: 36px; border-radius: var(--raio-padrao);
    background: #FFFFFF; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .faixa-info .titulo-pequeno {
    font-size: 11px; font-weight: 700; letter-spacing: 0.04em;
    color: var(--cor-primaria); text-transform: uppercase;
  }
  .faixa-info .texto-principal { font-size: 14px; font-weight: 600; color: var(--cor-texto-titulo); }
  .faixa-info .selo {
    background: #FFFFFF; border-radius: var(--raio-pill);
    padding: 4px 10px; font-size: 11px; font-weight: 700; color: var(--cor-primaria);
    white-space: nowrap;
  }

  .aviso-status {
    display: none;
    gap: var(--espaco-md);
    background: linear-gradient(135deg, #ecfdf5 0%, #dffaf0 100%);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: var(--raio-md);
    padding: var(--espaco-lg);
    margin-bottom: var(--espaco-lg);
    position: relative;
    box-shadow: 0 10px 24px rgba(16, 185, 129, 0.08);
  }
  .aviso-status .icone-relogio {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, var(--cor-sucesso), #059669);
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 18px;
    box-shadow: 0 10px 18px rgba(16, 185, 129, 0.2);
  }
  .aviso-status h3 {
    font-size: 15px;
    margin-bottom: 4px;
    color: #065f46;
  }
  .aviso-status p {
    font-size: 13px;
    color: #0f766e;
    line-height: 18px;
    margin: 0;
  }
  .aviso-status .fechar {
    position: absolute; top: 12px; right: 12px;
    background: none; border: none; cursor: pointer; color: #0f766e;
    font-size: 16px; line-height: 1;
  }

  .card-login {
    background: #FFFFFF;
    border: 1px solid var(--cor-borda);
    border-radius: var(--raio-lg);
    padding: var(--espaco-xl);
    box-shadow: var(--sombra-flutuante);
  }

  .abas-modo {
    display: flex;
    background: #F1F5F9;
    border-radius: var(--raio-padrao);
    padding: 3px;
    margin-bottom: var(--espaco-xl);
  }
  .aba-modo {
    flex: 1;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    height: 40px;
    border-radius: 6px;
    font-size: 13px; font-weight: 600;
    color: var(--cor-texto-corpo);
    background: none; border: none; cursor: pointer;
  }
  .aba-modo.ativa {
    background: #FFFFFF;
    color: var(--cor-texto-titulo);
    box-shadow: 0 1px 2px rgba(0,0,0,0.06);
  }

  .linha-topo-campo {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .linha-topo-campo .obrigatorio { font-size: 12px; color: var(--cor-texto-suave); }

  .linha-topo-campo a {
    color: var(--cor-primaria);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
  }

  .campo-senha-wrap { position: relative; }
  .campo-senha-wrap input { width: 100%; padding-right: 44px; }

  .toggle-senha {
    position: absolute;
    right: 14px;
    top: 12px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--cor-texto-suave);
  }

  .lembrar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: var(--espaco-lg);
    font-size: 12px;
    color: var(--cor-texto-corpo);
  }
  .lembrar .esquerda { display: flex; align-items: center; gap: var(--espaco-sm); }
  .lembrar .dias {
    background: #F1F5F9;
    border-radius: var(--raio-pill);
    padding: 2px 8px;
    font-size: 10px;
    font-weight: 600;
    color: var(--cor-texto-corpo);
    line-height: 1.4;
  }

  .btn-full { width: 100%; }

  .perfis-suportados { text-align: center; margin-top: var(--espaco-xl); }
  .perfis-suportados .rotulo {
    font-size: 11px; font-weight: 700; letter-spacing: 0.04em;
    color: var(--cor-texto-suave); text-transform: uppercase;
    margin-bottom: var(--espaco-md);
  }
  .perfis-suportados .lista { display: flex; justify-content: center; gap: var(--espaco-sm); flex-wrap: wrap; }

  .rodape-cadastro {
    text-align: center;
    margin-top: var(--espaco-lg);
    background: var(--cor-primaria-fundo-suave);
    border-radius: var(--raio-md);
    padding: var(--espaco-md);
    font-size: 13px;
    color: var(--cor-texto-corpo);
  }
  .rodape-cadastro a { color: var(--cor-primaria); font-weight: 600; text-decoration: none; }

  .rodape-seguranca {
    text-align: center;
    margin-top: var(--espaco-xl);
    font-size: 12px;
    color: var(--cor-texto-suave);
    line-height: 18px;
  }

  .erro-msg {
    display: none;
    background: var(--cor-erro-fundo);
    color: var(--cor-erro-texto);
    border-radius: var(--raio-padrao);
    padding: var(--espaco-md);
    font-size: 13px;
    margin-bottom: var(--espaco-lg);
  }
</style>
</head>
<body>

<div class="tela-login">

  <div class="logo-wrap">
    <div class="logo-icone-wrap">
      <div class="logo-icone">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="logo-check">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 13L9 17L19 7" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
    <h1>SaaS Gestão</h1>
    <p>Sistema Integrado de Gestão Empresarial</p>
  </div>

  <div class="faixa-info">
    <div class="esquerda">
      <div class="icone-caixa">🏢</div>
      <div>
        <div class="titulo-pequeno">Acesso Unificado Multi-Empresa</div>
        <div class="texto-principal">E-mail corporativo ou CNPJ</div>
      </div>
    </div>
    <div class="selo">🛡 3 Níveis</div>
  </div>

  <div class="aviso-status" id="avisoStatus">
    <button class="fechar" onclick="document.getElementById('avisoStatus').style.display='none'">✕</button>
    <div class="icone-relogio">✅</div>
    <div>
      <h3>Cadastro enviado</h3>
      <p>Seu cadastro foi enviado com sucesso. Assim que for aprovado, você poderá acessar o sistema.</p>
    </div>
  </div>

  <div class="card-login">

    <div class="abas-modo">
      <button type="button" class="aba-modo ativa" data-modo="email">✉ E-mail</button>
      <button type="button" class="aba-modo" data-modo="cnpj">🏢 CNPJ</button>
    </div>

    <div id="erroLogin" class="erro-msg"></div>

    <form id="formLogin">
      <div class="campo">
        <div class="linha-topo-campo">
          <label for="login">E-mail de Acesso</label>
          <span class="obrigatorio">Obrigatório</span>
        </div>
        <input type="email" id="login" name="login" placeholder="exemplo@suaempresa.com.br" required>
      </div>

      <div class="campo">
        <div class="linha-topo-campo">
          <label for="senha">Senha</label>
          <a href="tela_recuperar_senha.php">Esqueceu sua senha? Recuperar</a>
        </div>
        <div class="campo-senha-wrap">
          <input type="password" id="senha" name="senha" placeholder="••••••••••••" required>
          <button type="button" class="toggle-senha" onclick="alternarSenha()">👁</button>
        </div>
      </div>

      <label class="lembrar">
        <span class="esquerda"><input type="checkbox" id="lembrar" checked> Lembrar de mim</span>
        <span class="dias">30 dias</span>
      </label>

      <button type="submit" class="btn btn-primario btn-full">→ Entrar no Sistema</button>
    </form>

    <div class="perfis-suportados">
      <div class="rotulo">Perfis Suportados na Plataforma</div>
      <div class="lista">
        <span class="tag-papel tag-dono">● Dono</span>
        <span class="tag-papel tag-gerente">● Gerente</span>
        <span class="tag-papel tag-funcionario">● Funcionário</span>
      </div>
    </div>

  </div>

  <div class="rodape-cadastro">
    Não possui conta? <a href="tela_cadastrar_empresa.php">Cadastre sua empresa</a>
  </div>

  <div class="rodape-seguranca">
    🔒 Conexão Segura SSL de 256 bits<br>
    API REST Empresarial • v4.12.0
  </div>

</div>

<script>
function alternarSenha() {
  const campo = document.getElementById('senha');
  campo.type = campo.type === 'password' ? 'text' : 'password';
}

function mostrarMensagemCadastroSeNecessario() {
  const params = new URLSearchParams(window.location.search);
  const cadastro = params.get('cadastro');
  const aviso = document.getElementById('avisoStatus');

  if (cadastro === 'sucesso' && aviso) {
    aviso.style.display = 'flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

function atualizarModoLogin(modo) {
  const campoLogin = document.getElementById('login');
  const labelLogin = document.querySelector('label[for="login"]');

  if (modo === 'cnpj') {
    campoLogin.type = 'text';
    campoLogin.placeholder = '00.000.000/0000-00';
    campoLogin.setAttribute('inputmode', 'numeric');
    labelLogin.textContent = 'CNPJ da Empresa';
  } else {
    campoLogin.type = 'email';
    campoLogin.placeholder = 'exemplo@suaempresa.com.br';
    campoLogin.setAttribute('inputmode', 'email');
    labelLogin.textContent = 'E-mail de Acesso';
  }
}

document.querySelectorAll('.aba-modo').forEach(botao => {
  botao.addEventListener('click', function() {
    document.querySelectorAll('.aba-modo').forEach(item => item.classList.remove('ativa'));
    this.classList.add('ativa');
    atualizarModoLogin(this.dataset.modo);
  });
});

mostrarMensagemCadastroSeNecessario();

document.getElementById('formLogin').addEventListener('submit', async function(e) {
  e.preventDefault();
  const erroDiv = document.getElementById('erroLogin');
  erroDiv.style.display = 'none';

  const dados = {
    login: document.getElementById('login').value,
    senha: document.getElementById('senha').value
  };

  try {
    const resposta = await fetch('login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      if (json.papel === 'admin') {
        window.location.href = 'tela_admin.php';
      } else {
        window.location.href = 'tela_dashboard.php';
      }
    } else {
      erroDiv.textContent = json.erro || 'Erro ao entrar';
      erroDiv.style.display = 'block';
    }
  } catch (err) {
    erroDiv.textContent = 'Não foi possível conectar ao servidor';
    erroDiv.style.display = 'block';
  }
});
</script>

</body>
</html>
