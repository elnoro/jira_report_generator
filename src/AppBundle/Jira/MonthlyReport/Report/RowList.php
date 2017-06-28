<?php

namespace AppBundle\Jira\MonthlyReport\Report;

use League\Period\Period;

/**
 * Class RowList.
 */
class RowList
{
    /** @var Period */
    private $period;

    /** @var Row[] */
    private $rows;

    /**
     * RowList constructor.
     *
     * @param Period $period
     * @param Row[]  $rows
     */
    public function __construct(Period $period, array $rows)
    {
        $this->period = $period;
        $this->rows = $rows;
    }

    /**
     * @return Period
     */
    public function getPeriod(): Period
    {
        return $this->period;
    }

    /**
     * @return Row[]
     */
    public function getRows(): array
    {
        return $this->rows;
    }
}
