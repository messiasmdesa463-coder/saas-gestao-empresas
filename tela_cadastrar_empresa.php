<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SaaS Gestão - Cadastro de Empresa</title>
<link rel="stylesheet" href="style.css">
<style>
  body { display: flex; justify-content: center; padding: var(--espaco-xl) var(--espaco-lg); }
  .tela { width: 100%; max-width: 480px; }

  .logo-wrap { display: flex; flex-direction: column; align-items: center; gap: var(--espaco-sm); margin-bottom: var(--espaco-xl); }
  .logo-icone { width: 64px; height: 64px; border-radius: var(--raio-lg); background: var(--cor-primaria); display: flex; align-items: center; justify-content: center; }
  .logo-icone svg { width: 32px; height: 32px; }
  .logo-wrap h1 { font-size: 24px; }
  .logo-wrap p { color: var(--cor-texto-suave); font-size: 14px; text-align: center; }

  .card-form {
    background: #FFFFFF; border: 1px solid var(--cor-borda); border-radius: var(--raio-lg);
    padding: var(--espaco-xl); box-shadow: var(--sombra-flutuante);
  }

  .secao-titulo {
    font-size: 13px; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase;
    color: var(--cor-primaria); margin: var(--espaco-xl) 0 var(--espaco-md);
  }
  .secao-titulo:first-child { margin-top: 0; }

  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: var(--espaco-lg); }

  .erro-msg, .sucesso-msg {
    display: none; border-radius: var(--raio-padrao); padding: var(--espaco-md);
    font-size: 13px; margin-bottom: var(--espaco-lg);
  }
  .erro-msg { background: var(--cor-erro-fundo); color: var(--cor-erro-texto); }
  .sucesso-msg { background: var(--cor-sucesso-fundo); color: var(--cor-sucesso-texto); }

  .btn-full { width: 100%; }

  .rodape-login { text-align: center; margin-top: var(--espaco-lg); font-size: 13px; color: var(--cor-texto-corpo); }
  .rodape-login a { color: var(--cor-primaria); font-weight: 600; text-decoration: none; }
</style>
</head>
<body>

<div class="tela">

  <div class="logo-wrap">
    <div class="logo-icone">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="21" cy="6" r="2.5" fill="#10B981"/>
      </svg>
    </div>
    <h1>Cadastre sua empresa</h1>
    <p>Leva menos de 2 minutos. Seu cadastro entra em análise após o envio.</p>
  </div>

  <div class="card-form">

    <div id="erroMsg" class="erro-msg"></div>
    <div id="sucessoMsg" class="sucesso-msg"></div>

    <form id="formCadastro">

      <div class="secao-titulo">Dados da empresa</div>
      <div class="campo">
        <label for="nome_empresa">Nome da empresa</label>
        <input type="text" id="nome_empresa" name="nome_empresa" placeholder="Distribuidora Silva Ltda" required>
      </div>
      <div class="campo">
        <label for="nome_responsavel">Nome do responsável</label>
        <input type="text" id="nome_responsavel" name="nome_responsavel" placeholder="Seu nome completo" required>
      </div>

      <div class="secao-titulo">Endereço</div>
      <div class="grid-2">
        <div class="campo">
          <label for="cep">CEP</label>
          <input type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9">
        </div>
        <div class="campo">
          <label for="estado">Estado</label>
          <input type="text" id="estado" name="estado" placeholder="SP" maxlength="2">
        </div>
      </div>
      <div class="campo">
        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" placeholder="São Paulo">
      </div>

      <div class="secao-titulo">Acesso</div>
      <div class="campo">
        <label for="cnpj">CNPJ da empresa</label>
        <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" maxlength="18" required>
      </div>
      <div class="campo">
        <label for="email">E-mail de acesso</label>
        <input type="email" id="email" name="email" placeholder="exemplo@suaempresa.com.br" required>
      </div>
      <div class="campo">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Mínimo 8 caracteres" minlength="8" required>
      </div>

      <button type="submit" class="btn btn-primario btn-full">Enviar cadastro para análise</button>
    </form>

  </div>

  <div class="rodape-login">
    Já tem conta? <a href="tela_login.php">Fazer login</a>
  </div>

</div>

<script>
document.getElementById('formCadastro').addEventListener('submit', async function(e) {
  e.preventDefault();
  const erroDiv = document.getElementById('erroMsg');
  const sucessoDiv = document.getElementById('sucessoMsg');
  erroDiv.style.display = 'none';
  sucessoDiv.style.display = 'none';

  const dados = {
    nome_empresa: document.getElementById('nome_empresa').value.trim(),
    nome_responsavel: document.getElementById('nome_responsavel').value.trim(),
    cnpj: document.getElementById('cnpj').value.trim(),
    email: document.getElementById('email').value.trim(),
    senha: document.getElementById('senha').value.trim(),
    cep: document.getElementById('cep').value.trim(),
    cidade: document.getElementById('cidade').value.trim(),
    estado: document.getElementById('estado').value.trim()
  };

  const cnpjLimpo = dados.cnpj.replace(/\D/g, '');
  if (!dados.nome_empresa || !dados.email || !dados.senha || cnpjLimpo.length !== 14) {
    erroDiv.textContent = 'Preencha nome da empresa, e-mail, senha e CNPJ válidos';
    erroDiv.style.display = 'block';
    return;
  }

  try {
    const resposta = await fetch('cadastrar_empresa.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      sucessoDiv.textContent = 'Cadastro enviado! Assim que for aprovado, você poderá fazer login.';
      sucessoDiv.style.display = 'block';
      document.getElementById('formCadastro').reset();
      setTimeout(() => {
        window.location.href = 'tela_login.php?cadastro=sucesso';
      }, 1200);
    } else {
      erroDiv.textContent = json.erro || 'Erro ao cadastrar';
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
