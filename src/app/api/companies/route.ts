import { NextResponse } from 'next/server';
import { z } from 'zod';
import { db } from '@/lib/db';

const companySchema = z.object({
  name: z.string().min(2),
  document: z.string().min(8),
  email: z.string().email(),
  website: z.string().url().optional().or(z.literal('')),
  zipCode: z.string().optional(),
  address: z.string().optional(),
  logoUrl: z.string().url().optional().or(z.literal(''))
});

export async function GET() {
  const companies = await db.company.findMany({ include: { members: true, _count: { select: { products: true, tickets: true } } }, orderBy: { createdAt: 'desc' } });
  return NextResponse.json(companies);
}

export async function POST(request: Request) {
  const parsed = companySchema.safeParse(await request.json());
  if (!parsed.success) return NextResponse.json({ error: parsed.error.flatten() }, { status: 400 });
  const company = await db.company.create({ data: parsed.data });
  return NextResponse.json(company, { status: 201 });
}
