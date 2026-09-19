<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nova Movimentação</title>
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
    width: 40px;
    height: 40px;
    border: 1px solid var(--cor-borda);
    border-radius: 12px;
    background: #fff;
    font-size: 20px;
    cursor: pointer;
    color: var(--cor-texto-titulo);
    box-shadow: var(--sombra-card);
    transition: all 0.2s ease;
  }

  .topo .voltar:hover {
    background: var(--cor-primaria-fundo-suave);
    border-color: rgba(79, 70, 229, 0.25);
    color: var(--cor-primaria);
    transform: translateX(-1px);
  }

  .topo .icone {
    width: 36px;
    height: 36px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--cor-primaria), #2d4bd8);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 18px rgba(79, 70, 229, 0.2);
  }

  .topo .icone svg { width: 18px; height: 18px; }
  .topo h2 { font-size: 17px; margin: 0; }
  .topo p { font-size: 12px; color: var(--cor-texto-suave); margin: 2px 0 0; }

  .titulo-clicavel {
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .titulo-clicavel:hover {
    color: var(--cor-primaria);
  }

  .conteudo {
    max-width: 540px;
    margin: 0 auto;
    padding: 24px 18px 0;
  }

  .aviso-tempo-real {
    color: var(--cor-primaria);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
  }

  .aviso-tempo-real + p {
    font-size: 13px;
    color: var(--cor-texto-suave);
    margin-bottom: 18px;
  }

  .abas-tipo {
    display: flex;
    background: #f1f5f9;
    border-radius: 12px;
    padding: 4px;
    margin-bottom: 16px;
  }

  .aba-tipo {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    height: 44px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    background: transparent;
    color: var(--cor-texto-corpo);
  }

  .aba-tipo.ativa-entrada {
    background: #fff;
    color: var(--cor-sucesso);
    box-shadow: 0 1px 2px rgba(0,0,0,0.06);
  }

  .aba-tipo.ativa-saida {
    background: #fff;
    color: var(--cor-primaria);
    box-shadow: 0 1px 2px rgba(0,0,0,0.06);
  }

  .produto-selecionado,
  .quantidade-card,
  .card-form {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px;
    box-shadow: var(--sombra-card);
  }

  .produto-selecionado {
    margin-bottom: 16px;
  }

  .produto-selecionado .rotulo {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: var(--cor-primaria);
    text-transform: uppercase;
    margin-bottom: 6px;
  }

  .produto-selecionado h3 {
    font-size: 18px;
    margin: 0 0 6px;
  }

  .produto-selecionado .sku {
    font-size: 12px;
    color: var(--cor-texto-suave);
    font-family: monospace;
    margin-bottom: 12px;
  }

  .alerta-caixa {
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 13px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .alerta-caixa.critico { background: var(--cor-erro-fundo); color: var(--cor-erro-texto); }
  .alerta-caixa.info { background: var(--cor-atencao-fundo); color: var(--cor-atencao-texto); }

  .quantidade-card {
    text-align: center;
    margin-bottom: 16px;
  }

  .quantidade-card .rotulo {
    font-size: 13px;
    color: var(--cor-texto-corpo);
    margin-bottom: 16px;
    font-weight: 600;
  }

  .stepper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 26px;
  }

  .stepper button {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    border: 1px solid var(--cor-borda);
    background: var(--cor-primaria-fundo-suave);
    color: var(--cor-primaria);
    font-size: 22px;
    cursor: pointer;
  }

  .stepper .valor {
    font-size: 36px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--cor-primaria);
    min-width: 60px;
  }

  .stepper .unidade {
    font-size: 12px;
    color: var(--cor-texto-suave);
    display: block;
    margin-top: 4px;
  }

  .campo {
    margin-bottom: 16px;
  }

  .campo input {
    background: #f8fafc;
    border: 1px solid #dfe7f2;
    border-radius: 12px;
    min-height: 48px;
    padding: 0 14px;
  }

  .btn-full { width: 100%; margin-top: 4px; }
  .btn-cancelar {
    width: 100%;
    margin-top: 12px;
    background: #f1f5f9;
    color: var(--cor-texto-corpo);
  }

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
  <button class="voltar" onclick="voltarParaDashboard()">←</button>
  <div class="icone">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </div>
  <div>
    <h2 id="tituloMovimentacao" class="titulo-clicavel">Nova Movimentação</h2>
    <p id="nomeEmpresaTopo">Carregando...</p>
  </div>
</div>

<div class="conteudo">

  <div class="aviso-tempo-real">⇄ OPERAÇÃO EM TEMPO REAL</div>
  <p>Atualização automática com trava de segurança e cálculo de saldo imediato.</p>

  <div class="abas-tipo">
    <button type="button" class="aba-tipo ativa-entrada" id="btnEntrada" data-tipo="entrada">🟢 Entrada (+)</button>
    <button type="button" class="aba-tipo" id="btnSaida" data-tipo="saida">🔵 Saída (−)</button>
  </div>

  <div class="produto-selecionado">
    <div class="rotulo">Produto Selecionado</div>
    <h3 id="produtoNome">Carregando...</h3>
    <div class="sku">SKU: <span id="produtoId">-</span></div>
    <div class="alerta-caixa critico" id="alertaEstoque" style="display:none;">
      <span>⚠ Estoque Crítico</span>
      <span id="estoqueAtualMin"></span>
    </div>
  </div>

  <div class="quantidade-card">
    <div class="rotulo">Quantidade da Movimentação</div>
    <div class="stepper">
      <button type="button" onclick="alterarQtd(-1)">−</button>
      <div>
        <div class="valor" id="qtdValor">1</div>
        <span class="unidade">UNIDADES</span>
      </div>
      <button type="button" onclick="alterarQtd(1)">+</button>
    </div>
  </div>

  <div class="campo">
    <label for="observacao">Observações (opcional)</label>
    <input type="text" id="observacao" placeholder="Ex: Venda a cliente, pedido #1084">
  </div>

  <div id="erroMsg" class="erro-msg"></div>
  <div id="sucessoMsg" class="sucesso-msg"></div>

  <button class="btn btn-primario btn-full" id="btnConfirmar" onclick="confirmarMovimentacao()">✓ Confirmar Movimentação</button>
  <button class="btn btn-cancelar" onclick="voltarParaDashboard()">Cancelar Operação</button>

</div>

<script>
const params = new URLSearchParams(window.location.search);
const produtoId = params.get('produto_id');
const empresaId = params.get('empresa_id') || 1;
const tituloMovimentacao = document.getElementById('tituloMovimentacao');
let tipoAtual = 'entrada';
let quantidade = 1;

function voltarParaDashboard() {
  window.location.href = `tela_dashboard.php?empresa_id=${empresaId}`;
}

if (tituloMovimentacao) {
  tituloMovimentacao.addEventListener('click', voltarParaDashboard);
}

document.getElementById('produtoId').textContent = produtoId || '-';

document.getElementById('btnEntrada').addEventListener('click', () => selecionarTipo('entrada'));
document.getElementById('btnSaida').addEventListener('click', () => selecionarTipo('saida'));

function selecionarTipo(tipo) {
  tipoAtual = tipo;
  document.getElementById('btnEntrada').className = 'aba-tipo' + (tipo === 'entrada' ? ' ativa-entrada' : '');
  document.getElementById('btnSaida').className = 'aba-tipo' + (tipo === 'saida' ? ' ativa-saida' : '');
}

function alterarQtd(delta) {
  quantidade = Math.max(1, quantidade + delta);
  document.getElementById('qtdValor').textContent = quantidade;
}

async function confirmarMovimentacao() {
  const erroDiv = document.getElementById('erroMsg');
  const sucessoDiv = document.getElementById('sucessoMsg');
  erroDiv.style.display = 'none';
  sucessoDiv.style.display = 'none';

  if (!produtoId) {
    erroDiv.textContent = 'Produto não identificado';
    erroDiv.style.display = 'block';
    return;
  }

  const dados = {
    produto_id: produtoId,
    tipo: tipoAtual,
    quantidade: quantidade,
    observacao: document.getElementById('observacao').value
  };

  try {
    const resposta = await fetch('movimentar_estoque.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      sucessoDiv.textContent = 'Movimentação registrada com sucesso!';
      sucessoDiv.style.display = 'block';
      setTimeout(() => voltarParaDashboard(), 700);
    } else {
      erroDiv.textContent = json.erro || 'Erro ao registrar movimentação';
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
