<?php

namespace AppBundle\Jira\API;

use AppBundle\Jira\Issue\IssueList;

/**
 * Class CachingClient.
 */
final class CachingClient implements SearchEngineInterface
{
    /** @var SearchEngineInterface */
    private $internalSearchEngine;

    /** @var array */
    private $arrayCache = [];

    /**
     * CachingClient constructor.
     *
     * @param SearchEngineInterface $internalSearchEngine
     */
    public function __construct(SearchEngineInterface $internalSearchEngine)
    {
        $this->internalSearchEngine = $internalSearchEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $jql): IssueList
    {
        if (!array_key_exists($jql, $this->arrayCache)) {
            $this->arrayCache[$jql] = $this->internalSearchEngine->search($jql);
        }

        return $this->arrayCache[$jql];
    }
}
