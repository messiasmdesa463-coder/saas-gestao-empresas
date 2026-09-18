import Link from 'next/link';

export default function Home() {
  return (
    <main className="min-h-screen bg-slate-950 text-white">
      <section className="mx-auto max-w-6xl px-6 py-24">
        <span className="rounded-full bg-blue-500/20 px-4 py-2 text-sm text-blue-300">SaaS multiempresa</span>
        <h1 className="mt-8 max-w-3xl text-5xl font-bold tracking-tight">Gestão simples, estoque em tempo real e suporte em um só lugar.</h1>
        <p className="mt-6 max-w-2xl text-lg text-slate-300">Cadastre sua empresa, produtos, equipe e acompanhe tudo com aprovações, alertas, relatórios e chamados.</p>
        <div className="mt-10 flex gap-4"><Link className="rounded-lg bg-blue-600 px-5 py-3 font-semibold hover:bg-blue-500" href="/dashboard">Acessar painel</Link><Link className="rounded-lg border border-slate-700 px-5 py-3" href="/api/products?companyId=demo">API de produtos</Link></div>
      </section>
    </main>
  );
}
