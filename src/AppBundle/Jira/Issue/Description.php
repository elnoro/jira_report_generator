<?php

namespace AppBundle\Jira\Issue;

/**
 * Class Description.
 */
final class Description
{
    /** @var string */
    private $key;

    /** @var string */
    private $summary;

    /** @var string */
    private $priority;

    /**
     * Description constructor.
     *
     * @param string $key
     * @param string $summary
     * @param string $priority
     */
    public function __construct(string $key, string $summary, string $priority)
    {
        $this->key = $key;
        $this->summary = $summary;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getHumanId(): string
    {
        if ($this->summary && $this->key) {
            return sprintf('%s - %s', $this->key, $this->summary);
        }
        if ($this->key) {
            return $this->key;
        }

        return $this->summary;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }
}
