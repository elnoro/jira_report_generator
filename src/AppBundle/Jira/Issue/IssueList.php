<?php

namespace AppBundle\Jira\Issue;

/**
 * Class IssueList.
 */
final class IssueList
{
    /** @var Issue[] */
    private $issues;

    /**
     * @param array $denormalized
     *
     * @return IssueList
     */
    public static function denormalize(array $denormalized): self
    {
        return new self(array_map([Issue::class, 'denormalize'], $denormalized['issues'] ?? []));
    }

    /**
     * IssueList constructor.
     *
     * @param Issue[] $issues
     */
    public function __construct(array $issues)
    {
        $this->issues = $issues;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return count($this->issues);
    }

    /**
     * @return Issue[]
     */
    public function getIssues(): array
    {
        return array_values($this->issues);
    }
}
