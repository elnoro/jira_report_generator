<?php

namespace AppBundle\Jira\Issue;

/**
 * Class Issue.
 */
final class Issue
{
    const SPRINT_FIELD = 'customfield_10007';
    /** @var Description */
    private $description;

    /** @var string */
    private $currentStatus;

    /** @var Estimate */
    private $estimate;

    /**
     * @param array $denormalized
     *
     * @return Issue
     */
    public static function denormalize(array $denormalized): self
    {
        $description = new Description(
            $denormalized['key'] ?? '',
            $denormalized['fields']['summary'] ?? '',
            $denormalized['fields']['priority']['name'] ?? ''
        );
        $status = $denormalized['fields']['status']['name'] ?? '';
        $estimate = new Estimate($denormalized['fields']['timeoriginalestimate'] ?? null);
        if (empty($denormalized['fields']['fixVersions']) && empty($denormalized['fields'][self::SPRINT_FIELD])) {
            $estimate = Estimate::delayed();
        }

        return new self($description, $status, $estimate);
    }

    /**
     * Issue constructor.
     *
     * @param Description $description
     * @param string      $currentStatus
     * @param Estimate    $estimate
     */
    public function __construct(Description $description, $currentStatus, Estimate $estimate)
    {
        $this->description = $description;
        $this->currentStatus = $currentStatus;
        $this->estimate = $estimate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->description->getHumanId();
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->description->getPriority();
    }

    /**
     * @return bool
     */
    public function isEstimated(): bool
    {
        return (bool) $this->estimate->getOriginal();
    }
}
