<?php

namespace AppBundle\Jira\MonthlyReport\PeriodCalculator;

use League\Period\Period;

final class MonthCalculator implements PeriodCalculatorInterface
{
    /** @var callable */
    private $clock;

    public static function createWithInternalClock(): self
    {
        return new self(function () { return new \DateTimeImmutable(); });
    }

    /**
     * MonthCalculator constructor.
     *
     * @param callable $clock
     */
    public function __construct(callable $clock)
    {
        $this->clock = $clock;
    }

    public function calculate(): Period
    {
        /** @var \DateTimeImmutable $today */
        $today = ($this->clock)();

        $year = (int) $today->format('Y');
        $month = (int) $today->format('m');

        if ($this->previousMonthIsCalculated($today)) {
            if ($month > 1) {
                --$month;
            } else {
                --$year;
                $month = 12;
            }
            $period = Period::createFromMonth($year, $month);

            return $period->moveEndDate('-1 day');
        }

        return Period::createFromMonth($year, $month)->endingOn($today);
    }

    private function previousMonthIsCalculated(\DateTimeImmutable $today): bool
    {
        return $today->format('d') <= 3;
    }
}
