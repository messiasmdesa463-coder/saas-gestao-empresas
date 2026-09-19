<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Novo Produto</title>
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

  .topo h2 {
    font-size: 17px;
    margin: 0;
  }

  .titulo-clicavel {
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .titulo-clicavel:hover {
    color: var(--cor-primaria);
  }

  .conteudo {
    max-width: 520px;
    margin: 0 auto;
    padding: 24px 18px 0;
  }

  .grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .btn-full { width: 100%; }

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

  .campo input {
    background: #f8fafc;
    border: 1px solid #dfe7f2;
    border-radius: 12px;
    min-height: 48px;
    padding: 0 14px;
  }

  .upload-box {
    border: 1.5px dashed #cdd6f7;
    background: #f8faff;
    border-radius: 16px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    margin-bottom: 18px;
  }

  .upload-box input {
    display: none;
  }

  .upload-box-preview {
    width: 100%;
    min-height: 150px;
    border-radius: 12px;
    background: linear-gradient(135deg, #eef2ff, #e5e7eb);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 12px;
    border: 1px solid #dfe7f2;
  }

  .upload-box-preview img {
    max-width: 100%;
    max-height: 180px;
    object-fit: cover;
    display: none;
  }

  .upload-box-preview.has-image img {
    display: block;
  }

  .upload-box small {
    color: var(--cor-texto-suave);
    display: block;
    margin-top: 8px;
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

  @media (max-width: 520px) {
    .grid-2 {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>

<div class="topo">
  <button class="voltar" onclick="voltarParaDashboard()">←</button>
  <h2 id="tituloProduto" class="titulo-clicavel">Novo Produto</h2>
</div>

<div class="conteudo">
  <div id="erroMsg" class="erro-msg"></div>
  <div id="sucessoMsg" class="sucesso-msg"></div>

  <form id="formProduto">
    <label class="upload-box" for="fotoProduto">
      <div id="previewProduto" class="upload-box-preview">
        <img id="imagemPreview" alt="Pré-visualização do produto">
        <span id="textoPreview">📷 Adicionar foto do produto</span>
      </div>
      <strong>Selecionar foto</strong>
      <small>Você pode escolher uma imagem do celular ou tirar uma nova foto.</small>
      <input type="file" id="fotoProduto" accept="image/*" capture="environment">
    </label>

    <div class="campo">
      <label for="nome">Nome do produto</label>
      <input type="text" id="nome" required placeholder="Ex: Furadeira de Impacto 750W">
    </div>
    <div class="campo">
      <label for="descricao">Descrição / categoria</label>
      <input type="text" id="descricao" placeholder="Ex: Ferramentas">
    </div>
    <div class="grid-2">
      <div class="campo">
        <label for="preco">Preço (R$)</label>
        <input type="number" id="preco" step="0.01" placeholder="0.00">
      </div>
      <div class="campo">
        <label for="quantidade">Quantidade inicial</label>
        <input type="number" id="quantidade" placeholder="0">
      </div>
    </div>
    <div class="campo">
      <label for="quantidade_minima">Quantidade mínima (alerta de estoque baixo)</label>
      <input type="number" id="quantidade_minima" value="5">
    </div>
    <button type="submit" class="btn btn-primario btn-full">Salvar Produto</button>
  </form>
</div>

<script>
const empresaId = new URLSearchParams(window.location.search).get('empresa_id') || 1;
const tituloProduto = document.getElementById('tituloProduto');
const fotoProdutoInput = document.getElementById('fotoProduto');
const imagemPreview = document.getElementById('imagemPreview');
const previewProduto = document.getElementById('previewProduto');
const textoPreview = document.getElementById('textoPreview');
let fotoProdutoBase64 = '';

function voltarParaDashboard() {
  window.location.href = `tela_dashboard.php?empresa_id=${empresaId}`;
}

if (tituloProduto) {
  tituloProduto.addEventListener('click', voltarParaDashboard);
}

function lerArquivoComoBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;
    reader.readAsDataURL(file);
  });
}

fotoProdutoInput.addEventListener('change', async (event) => {
  const arquivo = event.target.files && event.target.files[0];
  if (!arquivo) return;

  try {
    fotoProdutoBase64 = await lerArquivoComoBase64(arquivo);
    imagemPreview.src = fotoProdutoBase64;
    previewProduto.classList.add('has-image');
    textoPreview.textContent = '';
  } catch (err) {
    console.error('Erro ao carregar imagem', err);
    fotoProdutoBase64 = '';
  }
});

document.getElementById('formProduto').addEventListener('submit', async (e) => {
  e.preventDefault();
  const erroDiv = document.getElementById('erroMsg');
  const sucessoDiv = document.getElementById('sucessoMsg');
  erroDiv.style.display = 'none';
  sucessoDiv.style.display = 'none';

  const dados = {
    empresa_id: empresaId,
    nome: document.getElementById('nome').value,
    descricao: document.getElementById('descricao').value,
    preco: document.getElementById('preco').value,
    quantidade: document.getElementById('quantidade').value,
    quantidade_minima: document.getElementById('quantidade_minima').value,
    foto: fotoProdutoBase64
  };

  try {
    const resposta = await fetch('cadastrar_produtos.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const json = await resposta.json();

    if (json.sucesso) {
      sucessoDiv.textContent = 'Produto cadastrado com sucesso!';
      sucessoDiv.style.display = 'block';
      setTimeout(() => voltarParaDashboard(), 700);
    } else {
      erroDiv.textContent = json.erro || 'Erro ao cadastrar produto';
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
