<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar Senha</title>
<link rel="stylesheet" href="style.css">
<style>
  body { display: flex; justify-content: center; padding: var(--espaco-xl) var(--espaco-lg); }
  .tela { width: 100%; max-width: 440px; }

  .topo { display: flex; align-items: center; gap: var(--espaco-md); margin-bottom: var(--espaco-xl); }
  .topo .voltar { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--cor-texto-titulo); }
  .topo .icone { width: 36px; height: 36px; border-radius: var(--raio-padrao); background: var(--cor-primaria); display: flex; align-items: center; justify-content: center; }
  .topo .icone svg { width: 20px; height: 20px; }
  .topo h2 { font-size: 17px; }

  .card-central { text-align: center; margin-bottom: var(--espaco-lg); }
  .icone-central {
    width: 72px; height: 72px; border-radius: 50%; background: var(--cor-primaria);
    display: flex; align-items: center; justify-content: center; margin: 0 auto var(--espaco-md);
    position: relative;
  }
  .icone-central svg { width: 32px; height: 32px; }
  .selo-cadeado {
    position: absolute; bottom: -2px; right: -2px; width: 24px; height: 24px; border-radius: 50%;
    background: var(--cor-sucesso); border: 3px solid var(--cor-fundo);
    display: flex; align-items: center; justify-content: center; font-size: 11px;
  }
  .rotulo-seguranca {
    font-size: 11px; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase;
    color: var(--cor-primaria); margin-bottom: var(--espaco-sm);
  }
  .card-central h1 { font-size: 24px; margin-bottom: var(--espaco-sm); }
  .card-central p { font-size: 14px; color: var(--cor-texto-suave); }

  .card-form { background: #FFFFFF; border: 1px solid var(--cor-borda); border-radius: var(--raio-lg); padding: var(--espaco-xl); box-shadow: var(--sombra-card); margin-bottom: var(--espaco-lg); }

  .info-box {
    display: flex; gap: var(--espaco-md); background: var(--cor-primaria-fundo-suave);
    border-radius: var(--raio-padrao); padding: var(--espaco-md); font-size: 13px; color: var(--cor-texto-corpo); margin: var(--espaco-md) 0 var(--espaco-lg);
  }

  .btn-full { width: 100%; }

  .card-suporte {
    display: flex; align-items: center; justify-content: space-between; gap: var(--espaco-md);
    background: var(--cor-fundo); border-radius: var(--raio-md); padding: var(--espaco-lg);
    font-size: 13px; color: var(--cor-texto-corpo);
  }

  /* Etapa 2: código */
  #etapaCodigo { display: none; }
  .codigo-inputs { display: flex; gap: var(--espaco-sm); justify-content: center; margin: var(--espaco-lg) 0; }
  .codigo-inputs input {
    width: 44px; height: 52px; text-align: center; font-size: 22px; font-weight: 700;
    border: 1px solid var(--cor-borda); border-radius: var(--raio-padrao); background: var(--cor-fundo);
  }
  .codigo-inputs input:focus { outline: none; border: 2px solid var(--cor-primaria); background: #FFFFFF; }

  .erro-msg, .sucesso-msg {
    display: none; border-radius: var(--raio-padrao); padding: var(--espaco-md);
    font-size: 13px; margin-bottom: var(--espaco-lg);
  }
  .erro-msg { background: var(--cor-erro-fundo); color: var(--cor-erro-texto); }
  .sucesso-msg { background: var(--cor-sucesso-fundo); color: var(--cor-sucesso-texto); }
</style>
</head>
<body>

<div class="tela">

  <div class="topo">
    <button class="voltar" onclick="location.href='tela_login.php'">←</button>
    <div class="icone">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
    <h2>Recuperar Senha</h2>
  </div>

  <!-- ETAPA 1: solicitar código -->
  <div id="etapaEmail">
    <div class="card-central">
      <div class="icone-central">
        ✉<div class="selo-cadeado">🔒</div>
      </div>
      <div class="rotulo-seguranca">Segurança Corporativa</div>
      <h1>Recuperar Acesso</h1>
      <p>Informe o e-mail cadastrado. Enviaremos um código de verificação de 6 dígitos para redefinir sua senha.</p>
    </div>

    <div class="card-form">
      <div id="erroEmail" class="erro-msg"></div>

      <div class="campo">
        <label for="emailRecuperacao">E-mail cadastrado</label>
        <input type="email" id="emailRecuperacao" placeholder="exemplo@suaempresa.com.br" required>
      </div>

      <div class="info-box">
        📧 O envio é feito pelo nosso servidor de e-mail autenticado. Verifique também sua caixa de spam se não chegar em 2 minutos.
      </div>

      <button class="btn btn-primario btn-full" onclick="enviarCodigo()">➤ Enviar Código de 6 Dígitos</button>
    </div>
  </div>

  <!-- ETAPA 2: código + nova senha -->
  <div id="etapaCodigo">
    <div class="card-central">
      <h1>Código de Segurança</h1>
      <p>Digite o código de 6 dígitos enviado para <strong id="emailMascarado"></strong></p>
    </div>

    <div class="card-form">
      <div id="erroCodigo" class="erro-msg"></div>
      <div id="sucessoCodigo" class="sucesso-msg"></div>

      <div class="codigo-inputs">
        <input type="text" maxlength="1" class="digito">
        <input type="text" maxlength="1" class="digito">
        <input type="text" maxlength="1" class="digito">
        <input type="text" maxlength="1" class="digito">
        <input type="text" maxlength="1" class="digito">
        <input type="text" maxlength="1" class="digito">
      </div>

      <div class="campo">
        <label for="novaSenha">Nova senha</label>
        <input type="password" id="novaSenha" placeholder="Mínimo 8 caracteres" minlength="8" required>
      </div>
      <div class="campo">
        <label for="confirmarSenha">Confirmar nova senha</label>
        <input type="password" id="confirmarSenha" placeholder="Repita a nova senha" required>
      </div>

      <button class="btn btn-primario btn-full" onclick="redefinirSenha()">✓ Validar e Redefinir Senha</button>
    </div>
  </div>

  <div class="card-suporte">
    <span>Não recebeu o código?</span>
    <a href="mailto:suportesaasgestao@gmail.com" style="color:var(--cor-primaria); font-weight:600; text-decoration:none;">Contatar suporte</a>
  </div>

</div>

<script>
let emailAtual = '';

// Navegação automática entre os dígitos do código
document.querySelectorAll('.digito').forEach((input, i, all) => {
  input.addEventListener('input', () => {
    if (input.value && i < all.length - 1) all[i + 1].focus();
  });
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && !input.value && i > 0) all[i - 1].focus();
  });
});

async function enviarCodigo() {
  const erroDiv = document.getElementById('erroEmail');
  erroDiv.style.display = 'none';
  emailAtual = document.getElementById('emailRecuperacao').value;

  if (!emailAtual) {
    erroDiv.textContent = 'Informe o e-mail';
    erroDiv.style.display = 'block';
    return;
  }

  try {
    const resposta = await fetch('solicitar_recuperacao.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: emailAtual })
    });
    const json = await resposta.json();

    if (json.sucesso) {
      const partes = emailAtual.split('@');
      document.getElementById('emailMascarado').textContent = partes[0].slice(0, 4) + '****@' + partes[1];
      document.getElementById('etapaEmail').style.display = 'none';
      document.getElementById('etapaCodigo').style.display = 'block';
    } else {
      erroDiv.textContent = json.erro || 'Erro ao enviar código';
      erroDiv.style.display = 'block';
    }
  } catch (err) {
    erroDiv.textContent = 'Não foi possível conectar ao servidor';
    erroDiv.style.display = 'block';
  }
}

async function redefinirSenha() {
  const erroDiv = document.getElementById('erroCodigo');
  const sucessoDiv = document.getElementById('sucessoCodigo');
  erroDiv.style.display = 'none';
  sucessoDiv.style.display = 'none';

  const token = Array.from(document.querySelectorAll('.digito')).map(i => i.value).join('');
  const novaSenha = document.getElementById('novaSenha').value;
  const confirmarSenha = document.getElementById('confirmarSenha').value;

  if (token.length !== 6) {
    erroDiv.textContent = 'Digite o código completo de 6 dígitos';
    erroDiv.style.display = 'block';
    return;
  }
  if (novaSenha !== confirmarSenha) {
    erroDiv.textContent = 'As senhas não coincidem';
    erroDiv.style.display = 'block';
    return;
  }

  try {
    const resposta = await fetch('redefinir_senha.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: emailAtual, token: token, nova_senha: novaSenha })
    });
    const json = await resposta.json();

    if (json.sucesso) {
      sucessoDiv.textContent = 'Senha alterada com sucesso! Redirecionando para o login...';
      sucessoDiv.style.display = 'block';
      setTimeout(() => location.href = 'tela_login.php', 1500);
    } else {
      erroDiv.textContent = json.erro || 'Código inválido ou expirado';
      erroDiv.style.display = 'block';
    }
  } catch (err) {
    erroDiv.textContent = 'Não foi possível conectar ao servidor';
    erroDiv.style.display = 'block';
  }
}
</script>

</body>
</html>
