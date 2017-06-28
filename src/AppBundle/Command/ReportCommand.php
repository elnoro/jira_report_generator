<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('report')
            ->setDescription('Generates report from JIRA for current month');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reportPipeline = $this->getContainer()->get('app.jira_monthly_report_pipeline.report_pipeline');

        $report = $reportPipeline->getReport();

        $output->writeln(sprintf('✅ Generated report %s', $report->getFilename()));
    }
}
