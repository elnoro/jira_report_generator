<?php

namespace AppBundle\Jira\MonthlyReport\Query;

use AppBundle\Jira\MonthlyReport\PeriodCalculator\PeriodCalculatorInterface;

/**
 * Class PeriodQueryProvider.
 */
class PeriodQueryProvider implements QueryProviderInterface
{
    const QUERY_TEMPLATE = '
        status in (Resolved, Closed, "In Review", "IN UAT", "READY FOR RELEASE", "READY FOR UAT") AND
        resolved >= %s AND resolved <= %s AND
        assignee was in (currentUser()) ORDER BY priority DESC, updated DESC
    ';
    const QUERY_DATE_FORMAT = 'Y-m-d';

    /** @var PeriodCalculatorInterface */
    private $periodCalculator;

    public function __construct(PeriodCalculatorInterface $periodCalculator)
    {
        $this->periodCalculator = $periodCalculator;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        $period = $this->periodCalculator->calculate();

        return sprintf(
            self::QUERY_TEMPLATE,
            $period->getStartDate()->format(self::QUERY_DATE_FORMAT),
            $period->getEndDate()->format(self::QUERY_DATE_FORMAT)
        );
    }
}
