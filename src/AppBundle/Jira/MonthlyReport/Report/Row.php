<?php

namespace AppBundle\Jira\MonthlyReport\Report;

use AppBundle\Jira\Issue\Issue;

/**
 * Class Row.
 */
class Row
{
    /** @var Issue */
    private $issue;

    /** @var string|null */
    private $suggestedDescription;

    public function __construct(Issue $issue, ?string $suggestedDescription = null)
    {
        $this->issue = $issue;
        $this->suggestedDescription = $suggestedDescription;
    }

    public function getIssueCode(): string
    {
        return $this->issue->getDescription()->getKey();
    }

    public function getOriginalDescription(): string
    {
        return $this->issue->getDescription()->getSummary();
    }

    public function getSuggestedDescription(): ?string
    {
        return $this->suggestedDescription;
    }

    public function suggestDescription(string $suggestedDescription)
    {
        $this->suggestedDescription = $suggestedDescription;
    }
}
