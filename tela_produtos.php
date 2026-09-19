<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SaaS Gestão - Produtos</title>
<link rel="stylesheet" href="style.css">
<style>
  body {
    background: linear-gradient(180deg, #f5f7ff 0%, #f3f6fb 100%);
    padding-bottom: 90px;
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
  .topo .marca .nomes h2 { font-size: 15px; line-height: 18px; margin: 0; }
  .topo .marca .nomes p { font-size: 12px; color: var(--cor-texto-suave); margin-top: 2px; }
  .topo .acoes { display: flex; align-items: center; gap: 12px; }

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
    padding: 24px 18px 0;
  }

  .busca-wrap { position: relative; margin-bottom: 16px; }
  .busca-wrap input {
    width: 100%; height: 52px;
    border: 1px solid var(--cor-borda);
    border-radius: 14px;
    padding: 0 16px 0 44px;
    font-size: 14px;
    background: #fff;
    box-shadow: var(--sombra-card);
  }
  .busca-wrap .icone-lupa {
    position: absolute;
    left: 14px;
    top: 15px;
    color: var(--cor-texto-suave);
    font-size: 20px;
  }

  .filtros {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    margin-bottom: 16px;
    padding-bottom: 4px;
  }

  .filtro-chip {
    flex-shrink: 0;
    height: 36px;
    padding: 0 16px;
    border-radius: 999px;
    border: 1px solid var(--cor-borda);
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: var(--cor-texto-corpo);
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
  }

  .filtro-chip.ativo {
    background: var(--cor-primaria-fundo-suave);
    border-color: var(--cor-primaria);
    color: var(--cor-primaria);
  }

  .linha-resumo {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: var(--cor-texto-suave);
    margin-bottom: 14px;
  }
  .linha-resumo strong { color: var(--cor-texto-titulo); }

  .card-produto {
    background: #fff;
    border: 1px solid var(--cor-borda);
    border-radius: 18px;
    padding: 18px;
    margin-bottom: 16px;
    box-shadow: var(--sombra-card);
  }

  .card-produto .cabecalho {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
  }

  .card-produto .thumb {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    flex-shrink: 0;
    overflow: hidden;
    border: 1px solid var(--cor-borda);
  }

  .card-produto .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .card-produto .info h3 {
    font-size: 16px;
    line-height: 1.3;
    margin: 0 0 4px;
  }

  .card-produto .info .sku {
    display: inline-block;
    font-size: 12px;
    color: var(--cor-primaria);
    font-weight: 700;
    font-family: 'Inter', monospace;
    margin-bottom: 4px;
  }

  .card-produto .info .categoria {
    font-size: 12px;
    color: var(--cor-texto-suave);
  }

  .estoque-box {
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 14px;
  }

  .estoque-box.saudavel { background: var(--cor-primaria-fundo-suave); }
  .estoque-box.baixo { background: var(--cor-atencao-fundo); }
  .estoque-box.critico { background: var(--cor-erro-fundo); }

  .estoque-box .linha-topo {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 12px;
    margin-bottom: 10px;
  }

  .estoque-box .rotulo { font-size: 13px; color: var(--cor-texto-corpo); }
  .estoque-box .valor {
    font-size: 26px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .estoque-box .valor small {
    font-size: 13px;
    font-weight: 500;
    color: var(--cor-texto-suave);
  }

  .barra {
    height: 8px;
    border-radius: 999px;
    background: rgba(148, 163, 184, 0.25);
    overflow: hidden;
  }

  .barra .preenchido {
    height: 100%;
    border-radius: inherit;
  }

  .rodape-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }

  .btn-movimentar {
    height: 36px;
    padding: 0 14px;
    border-radius: 10px;
    background: var(--cor-primaria);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
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
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .titulo-clicavel {
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .titulo-clicavel:hover {
    color: var(--cor-primaria);
  }
</style>
</head>
<body>

<div class="topo">
  <div class="marca">
    <div class="icone">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 17L9 11L13 15L21 6" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="nomes">
      <h2 id="nomeEmpresaTopo" class="titulo-clicavel">Produtos</h2>
      <p>Produtos</p>
    </div>
  </div>
  <div class="acoes">
    <div class="avatar"></div>
  </div>
</div>

<div class="conteudo">

  <div class="busca-wrap">
    <span class="icone-lupa">🔍</span>
    <input type="text" id="campoBusca" placeholder="Buscar por nome ou SKU...">
  </div>

  <div class="filtros">
    <button class="filtro-chip ativo" data-filtro="todos">Todos</button>
    <button class="filtro-chip" data-filtro="baixo">● Estoque Baixo</button>
    <button class="filtro-chip" data-filtro="saudavel">● Em Estoque</button>
  </div>

  <div class="linha-resumo">
    <span>Catálogo ativo</span>
    <strong id="totalProdutos">0 itens</strong>
  </div>

  <div id="listaProdutos"></div>

</div>

<button class="fab-novo" onclick="window.location.href='tela_cadastrar_produto.php?empresa_id=' + empresaId">+ Novo Produto</button>

<script>
// Ajuste aqui: pegar da sessão/login real, este é um valor fixo de exemplo
const empresaId = new URLSearchParams(window.location.search).get('empresa_id') || 1;
const nomeEmpresaTopo = document.getElementById('nomeEmpresaTopo');

if (nomeEmpresaTopo) {
  nomeEmpresaTopo.addEventListener('click', () => {
    window.location.href = `tela_dashboard.php?empresa_id=${empresaId}`;
  });
}

let todosProdutos = [];

async function carregarProdutos() {
  try {
    const resposta = await fetch(`listar_produtos.php?empresa_id=${empresaId}`);

    let json = null;
    try {
      json = await resposta.json();
    } catch (e) {
      json = { sucesso: false, erro: 'Resposta inválida do servidor. Verifique se o PHP/MySQL está funcionando.' };
    }

    if (json.sucesso) {
      todosProdutos = json.produtos || [];
      renderizar(todosProdutos);
      return;
    }

    const mensagem = json.erro || 'Erro ao carregar produtos.';
    document.getElementById('listaProdutos').innerHTML = `<p style="color:var(--cor-erro-texto)">${mensagem}</p>`;
  } catch (err) {
    document.getElementById('listaProdutos').innerHTML = '<p style="color:var(--cor-erro-texto)">Erro ao carregar produtos. Verifique a conexão com o banco.</p>';
  }
}

function renderizar(produtos) {
  document.getElementById('totalProdutos').textContent = produtos.length + ' itens';
  const lista = document.getElementById('listaProdutos');

  if (produtos.length === 0) {
    lista.innerHTML = '<p style="color:var(--cor-texto-suave); text-align:center; padding: 40px 0;">Nenhum produto cadastrado ainda.</p>';
    return;
  }

  lista.innerHTML = produtos.map(p => {
    const critico = p.quantidade == 0;
    const baixo = !critico && Number(p.estoque_baixo) === 1;
    const classe = critico ? 'critico' : (baixo ? 'baixo' : 'saudavel');
    const rotuloStatus = critico ? 'Disponível Crítico' : (baixo ? 'Estoque Baixo' : 'Disponível');
    const corBarra = critico ? 'var(--cor-erro)' : (baixo ? 'var(--cor-atencao)' : 'var(--cor-sucesso)');
    const pct = Math.min(100, (p.quantidade / Math.max(p.quantidade_minima * 2, 1)) * 100);
    const imagemProduto = p.foto ? `<img src="${p.foto}" alt="${p.nome}">` : '<span style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:20px;">📦</span>';

    return `
      <div class="card-produto">
        <div class="cabecalho">
          <div class="thumb">${imagemProduto}</div>
          <div class="info">
            <h3>${p.nome}</h3>
            <span class="sku">#${p.id}</span>
            <div class="categoria">${p.descricao || ''}</div>
          </div>
        </div>
        <div class="estoque-box ${classe}">
          <div class="linha-topo">
            <span class="rotulo">${rotuloStatus}</span>
            <span class="valor">${p.quantidade} <small>/ mín. ${p.quantidade_minima} un</small></span>
          </div>
          <div class="barra"><div class="preenchido" style="width:${pct}%; background:${corBarra}"></div></div>
        </div>
        <div class="rodape-card">
          <span class="badge ${critico ? 'badge-erro' : (baixo ? 'badge-atencao' : 'badge-sucesso')}">
            <span class="badge-dot"></span> ${critico ? 'Crítico' : (baixo ? 'Estoque Baixo (Qtd ≤ Mín)' : 'Estoque Saudável')}
          </span>
          <button class="btn-movimentar" onclick="window.location.href='tela_movimentar_estoque.php?produto_id=${p.id}'">⇄ Movimentar</button>
        </div>
      </div>
    `;
  }).join('');
}

document.querySelectorAll('.filtro-chip').forEach(chip => {
  chip.addEventListener('click', () => {
    document.querySelectorAll('.filtro-chip').forEach(c => c.classList.remove('ativo'));
    chip.classList.add('ativo');
    const filtro = chip.dataset.filtro;
    if (filtro === 'todos') renderizar(todosProdutos);
    else if (filtro === 'baixo') renderizar(todosProdutos.filter(p => Number(p.estoque_baixo) === 1));
    else if (filtro === 'saudavel') renderizar(todosProdutos.filter(p => Number(p.estoque_baixo) !== 1));
  });
});

document.getElementById('campoBusca').addEventListener('input', (e) => {
  const termo = e.target.value.toLowerCase();
  renderizar(todosProdutos.filter(p => p.nome.toLowerCase().includes(termo)));
});

carregarProdutos();
</script>

</body>
</html>
