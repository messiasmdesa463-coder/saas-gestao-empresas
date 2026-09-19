<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Equipe</title>
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
  .topo .marca h2 { font-size: 15px; margin: 0; }

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
    padding: 28px 18px 0;
  }

  .card-titulo {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
  }

  .card-titulo .icone-caixa {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: var(--cor-primaria-fundo-suave);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }

  .card-titulo h1 {
    font-size: 22px;
    margin: 0 0 2px;
  }

  .card-titulo p {
    font-size: 13px;
    color: var(--cor-texto-suave);
  }

  .card-membro {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px;
    margin-bottom: 16px;
    box-shadow: var(--sombra-card);
  }

  .card-membro .linha-topo {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
  }

  .card-membro .avatar-membro {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dfe8ff, #c7d2fe);
    flex-shrink: 0;
  }

  .card-membro h3 {
    font-size: 16px;
    margin: 0;
  }

  .card-membro .email {
    font-size: 13px;
    color: var(--cor-texto-suave);
    margin-top: 4px;
  }

  .card-membro .rodape {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .status-ativo {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--cor-sucesso);
    font-weight: 700;
  }

  .status-ativo .ponto {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--cor-sucesso);
  }

  .status-inativo {
    color: var(--cor-texto-suave);
  }

  .status-inativo .ponto {
    background: var(--cor-texto-suave);
  }

  .btn-remover {
    height: 34px;
    padding: 0 14px;
    border-radius: 10px;
    background: var(--cor-erro-fundo);
    color: var(--cor-erro-texto);
    font-size: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
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

  .modal-fundo {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,0.45);
    align-items: center;
    justify-content: center;
    padding: 16px;
    z-index: 50;
  }

  .modal-caixa {
    background: #fff;
    border-radius: 18px;
    padding: 22px;
    width: 100%;
    max-width: 420px;
    box-shadow: var(--sombra-flutuante);
  }

  .modal-caixa h2 {
    font-size: 20px;
    margin-bottom: 16px;
  }

  .modal-acoes {
    display: flex;
    gap: 12px;
    margin-top: 18px;
  }

  .modal-acoes .btn {
    flex: 1;
  }

  .erro-msg {
    display: none;
    background: var(--cor-erro-fundo);
    color: var(--cor-erro-texto);
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 13px;
    margin-bottom: 16px;
  }
</style>
</head>
<body>

<div class="topo">
  <div class="marca">
    <div class="icone"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
    <h2 id="nomeEmpresaTopo" class="titulo-clicavel">Equipe</h2>
  </div>
  <div class="avatar"></div>
</div>

<div class="conteudo">

  <div class="card-titulo">
    <div class="icone-caixa">👥</div>
    <div>
      <h1>Gestão de Equipe</h1>
      <p id="totalMembros">Carregando...</p>
    </div>
  </div>

  <div id="listaMembros"></div>

</div>

<button class="fab-novo" onclick="abrirModal()">+ Convidar Colaborador</button>

<div class="modal-fundo" id="modalConvite">
  <div class="modal-caixa">
    <h2>Convidar colaborador</h2>
    <div id="erroModal" class="erro-msg"></div>
    <div class="campo">
      <label for="nomeNovo">Nome</label>
      <input type="text" id="nomeNovo" placeholder="Nome completo">
    </div>
    <div class="campo">
      <label for="emailNovo">E-mail</label>
      <input type="email" id="emailNovo" placeholder="email@empresa.com">
    </div>
    <div class="campo">
      <label for="senhaNovo">Senha provisória</label>
      <input type="password" id="senhaNovo" placeholder="Mínimo 8 caracteres">
    </div>
    <div class="campo">
      <label for="papelNovo">Papel</label>
      <select id="papelNovo">
        <option value="funcionario">Funcionário</option>
        <option value="gerente">Gerente</option>
      </select>
    </div>
    <div class="modal-acoes">
      <button class="btn btn-secundario" onclick="fecharModal()">Cancelar</button>
      <button class="btn btn-primario" onclick="convidarMembro()">Convidar</button>
    </div>
  </div>
</div>

<script>
const empresaId = new URLSearchParams(window.location.search).get('empresa_id') || 1;
const nomeEmpresaTopo = document.getElementById('nomeEmpresaTopo');

if (nomeEmpresaTopo) {
  nomeEmpresaTopo.addEventListener('click', () => {
    window.location.href = `tela_dashboard.php?empresa_id=${empresaId}`;
  });
}

async function carregarEquipe() {
  try {
    const resposta = await fetch(`config/listar_funcionarios.php?empresa_id=${empresaId}`);
    const json = await resposta.json();
    if (json.sucesso) {
      renderizar(json.funcionarios || []);
      return;
    }
    document.getElementById('listaMembros').innerHTML = '<p style="color:var(--cor-erro-texto)">Erro ao carregar equipe.</p>';
  } catch (err) {
    document.getElementById('listaMembros').innerHTML = '<p style="color:var(--cor-erro-texto)">Erro ao carregar equipe.</p>';
  }
}

function renderizar(membros) {
  document.getElementById('totalMembros').textContent = membros.length + ' membro(s) na equipe';
  const lista = document.getElementById('listaMembros');

  if (membros.length === 0) {
    lista.innerHTML = '<p style="color:var(--cor-texto-suave); text-align:center; padding: 40px 0;">Nenhum colaborador cadastrado ainda.</p>';
    return;
  }

  const tagClasse = { dono: 'tag-dono', gerente: 'tag-gerente', funcionario: 'tag-funcionario' };
  const tagRotulo = { dono: 'Dono', gerente: 'Gerente', funcionario: 'Funcionário' };

  lista.innerHTML = membros.map(m => `
    <div class="card-membro">
      <div class="linha-topo">
        <div class="avatar-membro"></div>
        <div>
          <h3>${m.nome} <span class="tag-papel ${tagClasse[m.papel]}">${tagRotulo[m.papel]}</span></h3>
          <div class="email">${m.email}</div>
        </div>
      </div>
      <div class="rodape">
        <span class="status-ativo ${Number(m.ativo) === 1 ? '' : 'status-inativo'}">
          <span class="ponto"></span> ${Number(m.ativo) === 1 ? 'Ativo' : 'Desativado'}
        </span>
        ${Number(m.ativo) === 1 ? `<button class="btn-remover" onclick="removerMembro(${m.id})">Desativar</button>` : ''}
      </div>
    </div>
  `).join('');
}

function abrirModal() { document.getElementById('modalConvite').style.display = 'flex'; }
function fecharModal() { document.getElementById('modalConvite').style.display = 'none'; }

async function convidarMembro() {
  const erroDiv = document.getElementById('erroModal');
  erroDiv.style.display = 'none';

  const dados = {
    empresa_id: empresaId,
    nome: document.getElementById('nomeNovo').value,
    email: document.getElementById('emailNovo').value,
    senha: document.getElementById('senhaNovo').value,
    papel: document.getElementById('papelNovo').value
  };

  try {
    const resposta = await fetch('cadastrar.funcionario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      fecharModal();
      carregarEquipe();
    } else {
      erroDiv.textContent = json.erro || 'Erro ao convidar colaborador';
      erroDiv.style.display = 'block';
    }
  } catch (err) {
    erroDiv.textContent = 'Não foi possível conectar ao servidor';
    erroDiv.style.display = 'block';
  }
}

async function removerMembro(usuarioId) {
  if (!confirm('Desativar este colaborador?')) return;
  try {
    await fetch('remover_funcionario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ usuario_id: usuarioId })
    });
    carregarEquipe();
  } catch (err) {
    alert('Erro ao desativar colaborador');
  }
}

carregarEquipe();
</script>

</body>
</html>
