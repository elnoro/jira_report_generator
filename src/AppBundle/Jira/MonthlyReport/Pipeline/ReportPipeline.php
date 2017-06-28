<?php

namespace AppBundle\Jira\MonthlyReport\Pipeline;

use League\Pipeline\Pipeline;

/**
 * Class ReportPipeline.
 */
final class ReportPipeline
{
    /** @var callable[] */
    private $stages;

    /**
     * ReportPipeline constructor.
     *
     * @param \callable[] $stages
     */
    public function __construct(callable ...$stages)
    {
        $this->stages = $stages;
    }

    public function getReport(): \SplFileInfo
    {
        $pipeline = new Pipeline();

        foreach ($this->stages as $stage) {
            $pipeline = $pipeline->pipe($stage);
        }

        return $pipeline->process(null);
    }
}
