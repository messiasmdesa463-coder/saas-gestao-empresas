import { NextResponse } from 'next/server';
import { z } from 'zod';
import { db } from '@/lib/db';

const productSchema = z.object({
  companyId: z.string().min(1), name: z.string().min(2), sku: z.string().min(1),
  category: z.string().optional(), description: z.string().optional(),
  unitPrice: z.coerce.number().nonnegative(), stock: z.coerce.number().int().nonnegative(),
  minimumStock: z.coerce.number().int().nonnegative().default(5)
});

export async function GET(request: Request) {
  const companyId = new URL(request.url).searchParams.get('companyId');
  if (!companyId) return NextResponse.json({ error: 'companyId é obrigatório' }, { status: 400 });
  return NextResponse.json(await db.product.findMany({ where: { companyId, active: true }, orderBy: { name: 'asc' } }));
}

export async function POST(request: Request) {
  const parsed = productSchema.safeParse(await request.json());
  if (!parsed.success) return NextResponse.json({ error: parsed.error.flatten() }, { status: 400 });
  const product = await db.product.create({ data: { ...parsed.data, unitPrice: parsed.data.unitPrice } });
  return NextResponse.json(product, { status: 201 });
}
