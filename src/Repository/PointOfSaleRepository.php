<?php

namespace App\Repository;

use App\Entity\PointOfSale;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointOfSale>
 */
class PointOfSaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointOfSale::class);
    }

    /**
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     * @return array
     */
    public function findSummaryByPeriod(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        return $this->createQueryBuilder('p')
            ->select(
                'p.id',
                'p.name',
                'COUNT(o.id) AS orderCount',
                'COALESCE(SUM(o.totalAmount), 0) AS totalRevenue'
            )
            ->addSelect('CASE
                WHEN COUNT(o.id) > 0
                THEN SUM(o.totalAmount) / COUNT(o.id)
                ELSE 0
                END AS averageOrderValue'
            )
            ->leftJoin('p.orders', 'o', "WITH", 'o.createdAt BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->where('p.isActive = :isActive')
            ->setParameter('isActive', true)
            ->groupBy('p.id')
            ->addGroupBy('p.name')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
