# SaaS Gestão Empresas

Plataforma SaaS para gestão empresarial multiempresa, com foco em cadastros, operações, controle de estoque, aprovação de dados e administração de clientes.

Este projeto foi pensado para servir como base para um produto escalável, com organização por empresas, usuários, permissões, planos e módulos operacionais.

## Visão geral

O sistema permite:

- cadastrar empresas e usuários
- controlar permissões por perfil e empresa
- gerenciar produtos e movimentação de estoque
- acompanhar cadastros e aprovações administrativas
- configurar planos comerciais e assinaturas
- visualizar relatórios e métricas operacionais
- abrir e acompanhar chamados de suporte

A estrutura foi montada para evoluir em etapas, partindo de um MVP funcional e pronto para extensão.

## Stack

- Next.js 14
- TypeScript
- Prisma ORM
- PostgreSQL
- NextAuth
- Tailwind CSS
- API REST em `src/app/api`

## Funcionalidades previstas

### Autenticação e acesso
- login por e-mail e senha
- recuperação de senha
- autenticação com NextAuth
- gestão de perfis e permissões
- suporte a multiempresa com usuários por empresa

### Gestão empresarial
- cadastro de empresa
- dados cadastrais completos (CEP, logo, foto, site, e-mail)
- aprovação de dados pelo administrador
- gerenciamento de pessoas e contatos

### Produtos e estoque
- cadastro de produtos por categoria
- movimentação de estoque
- controle de baixa de itens
- alertas de estoque mínimo
- histórico de movimentações

### Administração
- gestão de planos e assinaturas
- relatórios mensais automatizados
- painel administrativo
- gestão de chamados e suporte

### Infraestrutura
- banco de dados PostgreSQL
- arquitetura modular em API routes do Next.js
- estrutura preparada para expandir novos módulos

## Estrutura do projeto

```bash
.
├── prisma/
│   └── schema.prisma
├── src/
│   ├── app/
│   │   ├── api/
│   │   ├── page.tsx
│   │   └── globals.css
│   ├── components/
│   ├── lib/
│   └── types/
├── .env.example
├── package.json
├── README.md
└── tsconfig.json
```

## Requisitos

Antes de iniciar, você precisará ter instalado:

- Node.js 18+
- npm
- PostgreSQL
- Git

## Configuração local

1. Clone o repositório

```bash
git clone https://github.com/messiasmdesa463-coder/saas-gestao-empresas.git
cd saas-gestao-empresas
```

2. Copie o arquivo de ambiente

```bash
cp .env.example .env
```

3. Ajuste as variáveis de ambiente no arquivo `.env`

Exemplo:

```dotenv
DATABASE_URL="postgresql://postgres:postgres@localhost:5432/saas_gestao?schema=public"
NEXT_PUBLIC_APP_NAME="Gestão Empresas"
NEXTAUTH_SECRET="troque-por-um-segredo-forte"
EMAIL_FROM="noreply@example.com"
SMS_PROVIDER_API_KEY=""
```

4. Instale as dependências

```bash
npm install
```

5. Gere o Prisma Client

```bash
npx prisma generate
```

6. Execute as migrations

```bash
npx prisma migrate dev --name init
```

7. Inicie o ambiente de desenvolvimento

```bash
npm run dev
```

A aplicação ficará disponível em:

```bash
http://localhost:3000
```

## Observações importantes

- O projeto ainda está em fase de MVP e estrutura inicial.
- Autenticação, envio de e-mail, SMS e integrações externas precisam ser configuradas com suas credenciais reais.
- O banco de dados deve estar rodando localmente antes de iniciar a aplicação.

## Roadmap

- autenticação completa com roles e permissões
- cadastro de usuários e empresas
- aprovação de dados cadastrais
- fluxo de produtos e estoque
- relatórios e dashboards
- integrações com suporte e comunicação
- evolução para multi-tenant escalável

## Licença

Este projeto está em desenvolvimento e pode ser adaptado conforme a necessidade da solução.

## Status

Status atual: base inicial do produto em desenvolvimento, com estrutura principal pronta para continuidade.

---

Se quiser, também posso te entregar uma versão mais comercial, mais enxuta ou uma README com foco em apresentação para GitHub/cliente.
