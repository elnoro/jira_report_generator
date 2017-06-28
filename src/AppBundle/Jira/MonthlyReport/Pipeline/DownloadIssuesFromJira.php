<?php

namespace AppBundle\Jira\MonthlyReport\Pipeline;

use AppBundle\Jira\API\SearchEngineInterface;
use AppBundle\Jira\Issue\Issue;
use AppBundle\Jira\Issue\IssueList;
use AppBundle\Jira\MonthlyReport\PeriodCalculator\PeriodCalculatorInterface;
use AppBundle\Jira\MonthlyReport\Query\QueryProviderInterface;
use AppBundle\Jira\MonthlyReport\Report\Row;
use AppBundle\Jira\MonthlyReport\Report\RowList;

final class DownloadIssuesFromJira
{
    /** @var SearchEngineInterface */
    private $searchEngine;

    /** @var QueryProviderInterface */
    private $reportQueryProvider;

    /** @var PeriodCalculatorInterface */
    private $periodCalculator; // todo refactor it to evade duplication

    /**
     * DownloadIssuesFromJira constructor.
     *
     * @param SearchEngineInterface     $searchEngine
     * @param QueryProviderInterface    $reportQueryProvider
     * @param PeriodCalculatorInterface $periodCalculator
     */
    public function __construct(
        SearchEngineInterface $searchEngine,
        QueryProviderInterface $reportQueryProvider,
        PeriodCalculatorInterface $periodCalculator
    ) {
        $this->searchEngine = $searchEngine;
        $this->reportQueryProvider = $reportQueryProvider;
        $this->periodCalculator = $periodCalculator;
    }

    public function __invoke()
    {
        return $this->getRows();
    }

    public function getRows(): RowList
    {
        $issuesToReport = $this->getIssuesToReport();
        $rows = array_map(function (Issue $issueToReport) {
            return new Row($issueToReport);
        }, $issuesToReport->getIssues());

        return new RowList($this->periodCalculator->calculate(), $rows);
    }

    private function getIssuesToReport(): IssueList
    {
        $reportQuery = $this->reportQueryProvider->getQuery();
        $issuesToReport = $this->searchEngine->search($reportQuery);

        return $issuesToReport;
    }
}
