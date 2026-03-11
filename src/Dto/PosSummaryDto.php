<?php

namespace App\Dto;

/**
 * Class PosSummaryDto
 *
 * data transporting (and isolation) layer
 */
readonly class PosSummaryDto
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $orderCount,
        public float  $totalRevenue,
        public float  $averageOrderValue,
    ) {}
}
