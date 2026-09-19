<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Novo Atendimento</title>
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
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 20;
  }

  .topo .voltar {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: var(--cor-texto-titulo);
  }

  .topo h2 {
    font-size: 17px;
    margin: 0;
  }

  .conteudo {
    max-width: 520px;
    margin: 0 auto;
    padding: 24px 18px 0;
  }

  form {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 22px 18px;
    box-shadow: var(--sombra-card);
  }

  .campo {
    margin-bottom: 16px;
  }

  .campo input,
  textarea {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #dfe7f2;
    border-radius: 12px;
    min-height: 48px;
    padding: 12px 14px;
    font-family: inherit;
    font-size: 14px;
  }

  textarea {
    min-height: 120px;
    resize: vertical;
  }

  .btn-full { width: 100%; }

  .erro-msg, .sucesso-msg {
    display: none;
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 13px;
    margin-bottom: 16px;
  }

  .erro-msg { background: var(--cor-erro-fundo); color: var(--cor-erro-texto); }
  .sucesso-msg { background: var(--cor-sucesso-fundo); color: var(--cor-sucesso-texto); }
</style>
</head>
<body>

<div class="topo">
  <button class="voltar" onclick="history.back()">←</button>
  <h2>Novo Atendimento</h2>
</div>

<div class="conteudo">
  <div id="erroMsg" class="erro-msg"></div>
  <div id="sucessoMsg" class="sucesso-msg"></div>

  <form id="formTicket">
    <div class="campo">
      <label for="assunto">Assunto</label>
      <input type="text" id="assunto" required placeholder="Ex: Dúvida sobre garantia do produto">
    </div>
    <div class="campo">
      <label for="descricao">Descrição</label>
      <textarea id="descricao" placeholder="Descreva o que você precisa..."></textarea>
    </div>
    <button type="submit" class="btn btn-primario btn-full">Abrir Chamado</button>
  </form>
</div>

<script>
const empresaId = new URLSearchParams(window.location.search).get('empresa_id') || 1;

document.getElementById('formTicket').addEventListener('submit', async (e) => {
  e.preventDefault();
  const erroDiv = document.getElementById('erroMsg');
  const sucessoDiv = document.getElementById('sucessoMsg');
  erroDiv.style.display = 'none';
  sucessoDiv.style.display = 'none';

  const dados = {
    empresa_id: empresaId,
    assunto: document.getElementById('assunto').value,
    descricao: document.getElementById('descricao').value
  };

  try {
    const resposta = await fetch('criar_ticket.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      sucessoDiv.textContent = 'Chamado aberto com sucesso!';
      sucessoDiv.style.display = 'block';
      setTimeout(() => location.href = `tela_atendimento.php?empresa_id=${empresaId}`, 1000);
    } else {
      erroDiv.textContent = json.erro || 'Erro ao abrir chamado';
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
