import type { Metadata } from 'next';
import './globals.css';

export const metadata: Metadata = { title: 'Gestão Empresas', description: 'Plataforma SaaS de gestão empresarial' };
export default function RootLayout({ children }: { children: React.ReactNode }) { return <html lang="pt-BR"><body>{children}</body></html>; }
