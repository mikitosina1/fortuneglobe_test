<?php declare(strict_types=1);

namespace App\Service;

use App\Dto\PosSummaryDto;
use App\Repository\PointOfSaleRepository;
use DateMalformedStringException;
use DateTimeImmutable;

/**
 * Class PosSummaryService
 *
 * separates business logic from controller
 */
class PosSummaryService
{
    /** @var PointOfSaleRepository $repository - local var for repo injection */
    private PointOfSaleRepository $repository;

    public function __construct(PointOfSaleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DateTimeImmutable|null $from
     * @param DateTimeImmutable|null $to
     * @return PosSummaryDto[]
     * @throws DateMalformedStringException
     */
    public function getSummaryByPeriod(?DateTimeImmutable $from, ?DateTimeImmutable $to): array
    {
        if (null === $from || null === $to) {
            $now = new DateTimeImmutable();
            $from = $now->modify('first day of this month')->setTime(0, 0, 0);
            $to = $now->modify('last day of this month')->setTime(23, 59, 59);
        }
        $rows =  $this->repository->findSummaryByPeriod($from, $to);
        $result = [];

        foreach ($rows as $row) {
            $result[] = new PosSummaryDto(
                (int) $row["id"],
                (string) $row["name"],
                (int) $row["orderCount"],
                (float) $row["totalRevenue"],
                (float) $row["averageOrderValue"]
            );
        }

        return $result;
    }
}
