import { NextResponse } from 'next/server';
import { db } from '@/lib/db';

export async function GET() {
  const products = await db.product.findMany({ where: { active: true }, include: { company: true }, orderBy: { stock: 'asc' } });
  const lowStock = products.filter((product) => product.stock <= product.minimumStock);
  return NextResponse.json({ lowStock, count: lowStock.length, message: lowStock.length ? 'Existem produtos com estoque baixo.' : 'Estoque normal.' });
}
