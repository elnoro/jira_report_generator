<?php

namespace AppBundle\Jira\MonthlyReport\Pipeline;

use AppBundle\Jira\MonthlyReport\Report\RowList;
use League\Csv\Writer;
use League\Period\Period;

final class GenerateReportFile
{
    /** @var string */
    private $pathToReportDirectory;

    /**
     * GenerateReportFile constructor.
     * @param string $pathToReportDirectory
     */
    public function __construct(string $pathToReportDirectory)
    {
        $this->pathToReportDirectory = $pathToReportDirectory;
    }

    public function __invoke($payload)
    {
        return $this->getReportFile($payload);
    }

    public function getReportFile(RowList $reportRows): \SplFileInfo
    {
        $pathToReport = $this->generateFileName($reportRows->getPeriod());
        $writer = Writer::createFromPath($pathToReport, 'w+');
        foreach ($reportRows->getRows() as $reportRow) {
            $reportColumns = [
                $reportRow->getIssueCode(),
                $reportRow->getSuggestedDescription(),
                $reportRow->getOriginalDescription(),
            ];
            $writer->insertOne($reportColumns);
        }

        return new \SplFileInfo($pathToReport);
    }

    private function generateFileName(Period $period): string
    {
        $filename = $period->getStartDate()->format('Y_m');

        return $this->pathToReportDirectory.'/'.$filename.'.csv';
    }
}
