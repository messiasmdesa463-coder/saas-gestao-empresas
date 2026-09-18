import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

async function main() {
  await prisma.plan.createMany({
    data: Array.from({ length: 30 }, (_, index) => ({
      name: `Plano ${index + 1}`,
      priceCents: (index + 1) * 9900,
      maxUsers: (index + 1) * 2,
      maxProducts: (index + 1) * 100,
      features: { reports: true, support: index > 2, api: index > 9 }
    })),
    skipDuplicates: true
  });
}

main().finally(() => prisma.$disconnect());
