<?php

namespace AppBundle\Jira\MonthlyReport\Pipeline;

use AppBundle\Jira\MonthlyReport\Report\Row;
use AppBundle\Jira\MonthlyReport\Report\RowList;

final class SuggestNewRelicDescription
{
    const MARKERS = ['uncaught exception', 'noticed exception'];
    const NEW_RELIC_DESCRIPTION = 'Баг из NewRelic';

    public function __invoke($payload)
    {
        return $this->addNewRelicDescriptions($payload);
    }

    public function addNewRelicDescriptions(RowList $reportRows): RowList
    {
        foreach ($reportRows->getRows() as $reportRow) {
            if ($this->isIssueFromNewRelic($reportRow)) {
                $reportRow->suggestDescription(self::NEW_RELIC_DESCRIPTION);
            }
        }

        return $reportRows;
    }

    private function isIssueFromNewRelic(Row $reportRow): bool
    {
        foreach (self::MARKERS as $marker) {
            if (0 === stripos($reportRow->getOriginalDescription(), $marker)) {
                return true;
            }
        }

        return false;
    }
}
