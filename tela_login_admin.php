<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Login</title>
<link rel="stylesheet" href="style.css">
<style>
  body { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: var(--espaco-lg); }
  .tela { width: 100%; max-width: 380px; }
  .logo-wrap { display: flex; flex-direction: column; align-items: center; gap: var(--espaco-sm); margin-bottom: var(--espaco-xl); }
  .logo-icone { width: 64px; height: 64px; border-radius: var(--raio-lg); background: var(--cor-texto-titulo); display: flex; align-items: center; justify-content: center; font-size: 28px; }
  .logo-wrap h1 { font-size: 22px; }
  .logo-wrap p { color: var(--cor-texto-suave); font-size: 13px; }
  .card { padding: var(--espaco-xl); }
  .btn-full { width: 100%; }
  .erro-msg { display: none; background: var(--cor-erro-fundo); color: var(--cor-erro-texto); border-radius: var(--raio-padrao); padding: var(--espaco-md); font-size: 13px; margin-bottom: var(--espaco-lg); }
</style>
</head>
<body>
<div class="tela">
  <div class="logo-wrap">
    <div class="logo-icone">🛡</div>
    <h1>Painel do Administrador</h1>
    <p>Acesso restrito</p>
  </div>
  <div class="card">
    <div id="erroMsg" class="erro-msg"></div>
    <form id="formLoginAdmin">
      <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" required>
      </div>
      <div class="campo">
        <label for="senha">Senha</label>
        <input type="password" id="senha" required>
      </div>
      <button type="submit" class="btn btn-primario btn-full">Entrar</button>
    </form>
  </div>
</div>
<script>
document.getElementById('formLoginAdmin').addEventListener('submit', async (e) => {
  e.preventDefault();
  const erroDiv = document.getElementById('erroMsg');
  erroDiv.style.display = 'none';

  try {
    const resposta = await fetch('login_admin.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify({
        email: document.getElementById('email').value,
        senha: document.getElementById('senha').value
      })
    });
    const json = await resposta.json();

    if (json.sucesso) {
      window.location.href = 'tela_painel_admin.php';
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
