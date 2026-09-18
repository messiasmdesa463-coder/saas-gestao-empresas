# SaaS Gestão Empresas

MVP de uma plataforma SaaS multiempresa para cadastro e movimentação de produtos, usuários, estoque, aprovação cadastral, planos, relatórios e chamados de suporte.

## Stack

- Next.js 14 + TypeScript
- Prisma ORM
- PostgreSQL
- NextAuth preparado para autenticação
- Tailwind CSS
- API REST em `src/app/api`

## Módulos previstos

- Login e recuperação de senha por e-mail/SMS
- Cadastro de pessoa e empresa com CEP, logo, foto, e-mail e site
- Aprovação de dados pessoais e empresariais pelo administrador
- Multiempresa com gerente, funcionários e permissões
- Produtos de qualquer categoria, movimentação de estoque e alerta de baixo estoque
- 30 planos comerciais configuráveis
- Relatório mensal agendado para o dia 1
- Central de chamados/TKT separada, integrada por API
- Painel administrativo

## Executar localmente

```bash
cp .env.example .env
npm install
npx prisma generate
npx prisma migrate dev --name init
npm run dev
```

Abra http://localhost:3000.

> Este commit entrega a fundação do produto: modelo de dados, API de empresas/produtos e layout inicial. Provedores de SMS/e-mail e autenticação devem ser configurados com suas credenciais antes de produção.
