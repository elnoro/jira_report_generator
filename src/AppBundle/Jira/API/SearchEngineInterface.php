<?php

namespace AppBundle\Jira\API;

use AppBundle\Jira\Issue\IssueList;

/**
 * Interface SearchEngineInterface.
 */
interface SearchEngineInterface
{
    /**
     * @param string $jql
     *
     * @return IssueList
     */
    public function search(string $jql): IssueList;
}
