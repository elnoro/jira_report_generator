<?php

namespace AppBundle\Jira\Dashboard;

use AppBundle\Jira\API\SearchEngineInterface;
use AppBundle\Jira\Issue\Issue;
use AppBundle\Jira\Issue\IssueList;

/**
 * Class Dashboard.
 */
final class Dashboard
{
    /** @var SearchEngineInterface */
    private $searchEngine;

    /**
     * Dashboard constructor.
     *
     * @param SearchEngineInterface $searchEngine
     */
    public function __construct(SearchEngineInterface $searchEngine)
    {
        $this->searchEngine = $searchEngine;
    }

    /**
     * @return int
     */
    public function countUnresolvedIssues(): int
    {
        return $this->getUnresolvedIssueList()->getTotal();
    }

    /**
     * @return IssueList
     */
    public function getIssuesInProgress(): IssueList
    {
        $issues = $this->getUnresolvedIssueList()->getIssues();

        return new IssueList(array_filter($issues, function (Issue $issue) {
            return 'In Progress' === $issue->getCurrentStatus();
        }));
    }

    /**
     * @return IssueList
     */
    public function getIssuesWithoutEstimation(): IssueList
    {
        $issues = $this->getUnresolvedIssueList()->getIssues();

        return new IssueList(array_filter($issues, function (Issue $issue) {
            return !$issue->isEstimated();
        }));
    }

    /**
     * @return IssueList
     */
    private function getUnresolvedIssueList(): IssueList
    {
        $issueList = $this
            ->searchEngine
            ->search('assignee=currentUser() AND resolution=Unresolved');

        return $issueList;
    }
}
