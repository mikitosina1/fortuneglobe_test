<?php

namespace App\Controller;

use App\Service\PosSummaryService;
use DateTimeImmutable;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PosSummaryController extends AbstractController
{
    private PosSummaryService $posSummaryService;
    public function __construct(PosSummaryService $posSummaryService)
    {
        $this->posSummaryService = $posSummaryService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/pos/summary', name: 'api_pos_summary', methods: ['GET'])]
    public function summary(Request $request): JsonResponse
    {
        try {
            $date = $this->parseDate(
                $request->query->get('from'),
                $request->query->get('to'),
            );
            if ($date['from'] !== null && $date['to'] !== null && $date['from'] > $date['to']) {
                return $this->json(
                    ['message' => 'Start date must be not greater than end date'],
                    Response::HTTP_BAD_REQUEST
                );
            }
            return $this->json($this->posSummaryService->getSummaryByPeriod($date['from'], $date['to']));

        } catch (Exception $e) {
            return $this->json([
                'message' => 'Bad data format, use please YYYY-mm-dd',
                'error_text' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string|null $from
     * @param string|null $to
     * @return array{ from: DateTimeImmutable, to: DateTimeImmutable }
     * @throws Exception
     */
    public function parseDate(?string $from, ?string $to): array
    {
        return [
            'from' => $this->parseSingleDate($from),
            'to' => $this->parseSingleDate($to, false)
        ];
    }

    /**
     * @param string|null $dateString
     * @param bool $isStart
     * @return DateTimeImmutable|null
     * @throws Exception
     */
    private function parseSingleDate(?string $dateString, bool $isStart = true): ?DateTimeImmutable
    {
        if (!$dateString) {
            return null;
        }

        $date = DateTimeImmutable::createFromFormat('Y-m-d', $dateString);

        if (!$date) {
            throw new Exception("Invalid date format: {$dateString}. Use YYYY-mm-dd");
        }

        return $isStart
            ? $date->setTime(0, 0, 0)
            : $date->setTime(23, 59, 59);
    }
}
